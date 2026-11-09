<?php

/**
 * Balih Film - Modern Cinema Booking System
 *
 * @author    I Gede Aldi Irawan <gedealdiirawan5@gmail.com>
 * @copyright 2026 I Gede Aldi Irawan (https://github.com/aldwrnnnnn)
 * @license   All Rights Reserved / Proprietary
 */

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\BookingItem;
use App\Models\Concession;
use App\Models\Showtime;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\View\View;

class BookingController extends Controller
{
    /**
     * Show the booking page for selecting seats and snacks.
     */
    public function create(Showtime $showtime): View|RedirectResponse
    {
        $showtime->load(['movie', 'studio']);

        // Check if the showtime has already passed
        $showtimeDateTime = Carbon::parse($showtime->show_date->format('Y-m-d').' '.$showtime->start_time);
        if ($showtimeDateTime->isPast()) {
            return redirect()
                ->route('movies.show', $showtime->movie->slug)
                ->withErrors([
                    'showtime' => 'Jadwal tayang ini sudah selesai dan tidak dapat dipesan lagi. Silakan pilih jam tayang lainnya.',
                ]);
        }

        $bookedSeats = $showtime->bookedSeats();

        // Get row labels and col count
        $rowLabels = array_filter(array_map('trim', explode(',', $showtime->studio->row_labels)));
        $totalCols = $showtime->studio->total_cols;

        // Group concessions by category
        $concessions = Concession::where('is_available', true)
            ->orderBy('category')
            ->orderBy('price')
            ->get()
            ->groupBy('category');

        return view('bookings.create', [
            'showtime' => $showtime,
            'movie' => $showtime->movie,
            'studio' => $showtime->studio,
            'bookedSeats' => $bookedSeats,
            'rowLabels' => $rowLabels,
            'totalCols' => $totalCols,
            'concessions' => $concessions,
        ]);
    }

    /**
     * Store a new booking in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'showtime_id' => ['required', 'exists:showtimes,id'],
            'customer_name' => ['required', 'string', 'max:100'],
            'customer_email' => ['required', 'email', 'max:100'],
            'customer_phone' => ['required', 'string', 'max:20'],
            'seats' => ['required', 'array', 'min:1', 'max:8'],
            'seats.*' => ['required', 'string', 'distinct', 'max:5', 'regex:/^[A-Z][0-9]{1,2}$/'],
            'payment_method' => ['required', 'string', 'in:QRIS,BCA Virtual Account,Mandiri Virtual Account,GoPay/ShopeePay,Tunai di Bioskop'],
            'concessions' => ['nullable', 'array'],
            'concessions.*' => ['nullable', 'integer', 'min:0', 'max:20'],
        ], [
            'seats.required' => 'Silakan pilih minimal 1 kursi sebelum melanjutkan pemesanan.',
            'seats.min' => 'Silakan pilih minimal 1 kursi bioskop.',
            'seats.max' => 'Maksimal pemesanan adalah 8 kursi per transaksi.',
            'seats.*.distinct' => 'Nomor kursi tidak boleh duplikat dalam satu pesanan.',
            'seats.*.regex' => 'Format kode kursi tidak valid.',
            'customer_name.required' => 'Nama lengkap pemesan wajib diisi.',
            'customer_email.required' => 'Alamat email wajib diisi untuk pengiriman e-tiket.',
            'customer_phone.required' => 'Nomor WhatsApp / HP wajib diisi.',
        ]);

        return DB::transaction(function () use ($validated) {
            $showtime = Showtime::with(['movie', 'studio'])->lockForUpdate()->findOrFail($validated['showtime_id']);

            // 0. Verify that the showtime has not passed
            $showtimeDateTime = Carbon::parse($showtime->show_date->format('Y-m-d').' '.$showtime->start_time);
            if ($showtimeDateTime->isPast()) {
                return back()
                    ->withInput()
                    ->withErrors([
                        'seats' => 'Jadwal tayang ini sudah selesai dan tidak dapat dipesan lagi.',
                    ]);
            }

            // 1. Verify seat availability and valid geometry
            $validRows = array_filter(array_map('trim', explode(',', $showtime->studio->row_labels)));
            $maxCol = $showtime->studio->total_cols;

            foreach ($validated['seats'] as $seat) {
                $row = substr($seat, 0, 1);
                $col = (int) substr($seat, 1);
                if (! in_array($row, $validRows) || $col < 1 || $col > $maxCol) {
                    return back()
                        ->withInput()
                        ->withErrors([
                            'seats' => 'Kursi '.$seat.' tidak valid untuk studio ini.',
                        ]);
                }
            }

            $currentBooked = $showtime->bookedSeats();
            $conflictingSeats = array_intersect($validated['seats'], $currentBooked);

            if (! empty($conflictingSeats)) {
                return back()
                    ->withInput()
                    ->withErrors([
                        'seats' => 'Kursi '.implode(', ', $conflictingSeats).' baru saja dipesan oleh penonton lain. Silakan pilih kursi lain yang masih tersedia.',
                    ]);
            }

            // 2. Compute Ticket Amounts
            $seatCount = count($validated['seats']);
            $ticketPrice = $showtime->price;
            $ticketSubtotal = $seatCount * $ticketPrice;

            // 3. Compute Concessions (Only available concessions)
            $concessionItemsToCreate = [];
            $snackSubtotal = 0;

            if (! empty($validated['concessions'])) {
                $concessionIds = array_keys(array_filter($validated['concessions'], fn ($qty) => $qty > 0));
                if (! empty($concessionIds)) {
                    $dbConcessions = Concession::whereIn('id', $concessionIds)
                        ->where('is_available', true)
                        ->get()
                        ->keyBy('id');

                    foreach ($validated['concessions'] as $concessionId => $qty) {
                        $qty = (int) $qty;
                        if ($qty > 0 && isset($dbConcessions[$concessionId])) {
                            $itemModel = $dbConcessions[$concessionId];
                            $itemSubtotal = $qty * $itemModel->price;
                            $snackSubtotal += $itemSubtotal;

                            $concessionItemsToCreate[] = [
                                'concession_id' => $concessionId,
                                'quantity' => $qty,
                                'unit_price' => $itemModel->price,
                                'subtotal' => $itemSubtotal,
                            ];
                        }
                    }
                }
            }

            $totalAmount = $ticketSubtotal + $snackSubtotal;

            // 4. Generate unique booking code and barcode with collision avoidance
            do {
                $bookingCode = 'BF-'.date('Ymd').'-'.strtoupper(Str::random(5));
            } while (Booking::where('booking_code', $bookingCode)->exists());

            do {
                $barcodeToken = 'BLH-'.date('ymd').'-'.strtoupper(Str::random(8));
            } while (Booking::where('barcode', $barcodeToken)->exists());

            // 5. Create Booking
            $booking = Booking::create([
                'booking_code' => $bookingCode,
                'showtime_id' => $showtime->id,
                'customer_name' => $validated['customer_name'],
                'customer_email' => $validated['customer_email'],
                'customer_phone' => $validated['customer_phone'],
                'seats' => $validated['seats'],
                'seat_count' => $seatCount,
                'ticket_price' => $ticketPrice,
                'ticket_subtotal' => $ticketSubtotal,
                'snack_subtotal' => $snackSubtotal,
                'total_amount' => $totalAmount,
                'payment_method' => $validated['payment_method'],
                'payment_status' => 'confirmed',
                'barcode' => $barcodeToken,
            ]);

            // 6. Create Booking Items
            foreach ($concessionItemsToCreate as $itemData) {
                $itemData['booking_id'] = $booking->id;
                BookingItem::create($itemData);
            }

            return redirect()
                ->route('bookings.show', $booking->booking_code)
                ->with('success', 'Pemesanan tiket bioskop berhasil! Simpan e-tiket dan barcode berikut untuk ditunjukkan di bioskop.');
        });
    }

    /**
     * Show booking details & barcode download page.
     */
    public function show(string $booking_code): View
    {
        $booking = Booking::where('booking_code', $booking_code)
            ->with([
                'showtime.movie',
                'showtime.studio',
                'items.concession',
            ])
            ->firstOrFail();

        return view('bookings.show', [
            'booking' => $booking,
            'movie' => $booking->showtime->movie,
            'studio' => $booking->showtime->studio,
            'showtime' => $booking->showtime,
        ]);
    }

    /**
     * Show lookup page or search for booking by code, phone, or email.
     */
    public function lookup(Request $request): View|RedirectResponse
    {
        $code = trim($request->query('code', ''));

        if ($code) {
            // First check if searching directly by unique booking code
            $booking = Booking::where('booking_code', strtoupper($code))->first();

            if ($booking) {
                return redirect()->route('bookings.show', $booking->booking_code);
            }

            // Check if searching by phone or email (supports returning multiple bookings)
            $matchingBookings = Booking::where('customer_phone', $code)
                ->orWhere('customer_email', $code)
                ->with(['showtime.movie', 'showtime.studio'])
                ->latest()
                ->get();

            if ($matchingBookings->count() === 1) {
                return redirect()->route('bookings.show', $matchingBookings->first()->booking_code);
            }

            if ($matchingBookings->count() > 1) {
                return view('bookings.lookup', [
                    'searchedCode' => $code,
                    'matchingBookings' => $matchingBookings,
                    'notFound' => false,
                ]);
            }

            return view('bookings.lookup', [
                'searchedCode' => $code,
                'matchingBookings' => collect(),
                'notFound' => true,
            ]);
        }

        return view('bookings.lookup', [
            'searchedCode' => null,
            'matchingBookings' => collect(),
            'notFound' => false,
        ]);
    }
}
