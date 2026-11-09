<?php

namespace Tests\Feature;

use App\Models\Booking;
use App\Models\Concession;
use App\Models\Movie;
use App\Models\Showtime;
use Carbon\Carbon;
use Database\Seeders\CinemaSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CinemaBookingTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(CinemaSeeder::class);
    }

    public function test_movies_index_page_loads_successfully(): void
    {
        $response = $this->get(route('movies.index'));

        $response->assertStatus(200);
        $response->assertSee('balihfilm');
        $response->assertSee('Sedang Tayang');
        $response->assertSee('Akan Datang');
    }

    public function test_movie_show_page_displays_details_and_showtimes(): void
    {
        $movie = Movie::where('status', 'now_playing')->first();
        $this->assertNotNull($movie);

        $response = $this->get(route('movies.show', $movie->slug));

        $response->assertStatus(200);
        $response->assertSee($movie->title);
        $response->assertSee('Jadwal Tayang');
    }

    public function test_booking_create_page_displays_seat_layout_and_concessions(): void
    {
        $showtime = Showtime::with(['movie', 'studio'])->first();
        $this->assertNotNull($showtime);

        $response = $this->get(route('bookings.create', $showtime->id));

        $response->assertStatus(200);
        $response->assertSee($showtime->movie->title);
        $response->assertSee('LAYAR BIOSKOP');
        $response->assertSee('Pilih Tempat Duduk');
        $response->assertSee('Tambah Makanan');
    }

    public function test_can_book_tickets_with_concessions_and_receive_barcode(): void
    {
        $showtime = Showtime::where('show_date', '>=', Carbon::today())->first();
        $this->assertNotNull($showtime);

        $concession = Concession::where('is_available', true)->first();
        $this->assertNotNull($concession);

        $seats = ['A1', 'A2'];

        $payload = [
            'showtime_id' => $showtime->id,
            'customer_name' => 'Budi Santoso',
            'customer_email' => 'budi@example.com',
            'customer_phone' => '08123456789',
            'seats' => $seats,
            'payment_method' => 'QRIS',
            'concessions' => [
                $concession->id => 2,
            ],
        ];

        $response = $this->post(route('bookings.store'), $payload);

        $this->assertDatabaseHas('bookings', [
            'customer_name' => 'Budi Santoso',
            'customer_email' => 'budi@example.com',
            'seat_count' => 2,
            'payment_method' => 'QRIS',
        ]);

        $booking = Booking::where('customer_email', 'budi@example.com')->latest()->first();
        $this->assertNotNull($booking);
        $this->assertNotEmpty($booking->barcode);
        $this->assertNotEmpty($booking->booking_code);

        $response->assertRedirect(route('bookings.show', $booking->booking_code));

        // Test viewing the ticket page
        $ticketResponse = $this->get(route('bookings.show', $booking->booking_code));
        $ticketResponse->assertStatus(200);
        $ticketResponse->assertSee($booking->booking_code);
        $ticketResponse->assertSee($booking->barcode);
        $ticketResponse->assertSee('Barcode Bioskop');
        $ticketResponse->assertSee('Budi Santoso');
        $ticketResponse->assertSee('A1');
        $ticketResponse->assertSee('A2');
    }

    public function test_cannot_book_already_booked_seat(): void
    {
        $showtime = Showtime::first();
        $this->assertNotNull($showtime);

        // Pre-create a booking with seat B1
        Booking::create([
            'booking_code' => 'TEST-OCCUPIED-01',
            'showtime_id' => $showtime->id,
            'customer_name' => 'Existing Customer',
            'customer_email' => 'existing@example.com',
            'customer_phone' => '08111111111',
            'seats' => ['B1'],
            'seat_count' => 1,
            'ticket_price' => $showtime->price,
            'ticket_subtotal' => $showtime->price,
            'snack_subtotal' => 0,
            'total_amount' => $showtime->price,
            'payment_method' => 'QRIS',
            'payment_status' => 'confirmed',
            'barcode' => 'BLH-TEST-OCCUPIED',
        ]);

        // Attempt to book the exact same seat B1
        $payload = [
            'showtime_id' => $showtime->id,
            'customer_name' => 'Late Booker',
            'customer_email' => 'late@example.com',
            'customer_phone' => '08222222222',
            'seats' => ['B1', 'B2'],
            'payment_method' => 'QRIS',
        ];

        $response = $this->post(route('bookings.store'), $payload);
        $response->assertSessionHasErrors('seats');
    }

    public function test_cannot_book_invalid_seat_geometry(): void
    {
        $showtime = Showtime::first();
        $this->assertNotNull($showtime);

        $payload = [
            'showtime_id' => $showtime->id,
            'customer_name' => 'Invalid Seat Booker',
            'customer_email' => 'invalid@example.com',
            'customer_phone' => '08333333333',
            'seats' => ['Z99'],
            'payment_method' => 'QRIS',
        ];

        $response = $this->post(route('bookings.store'), $payload);
        $response->assertSessionHasErrors('seats');
    }

    public function test_ticket_lookup_redirects_to_booking(): void
    {
        $booking = Booking::first();
        $this->assertNotNull($booking);

        $response = $this->get(route('bookings.lookup', ['code' => $booking->booking_code]));
        $response->assertRedirect(route('bookings.show', $booking->booking_code));
    }

    public function test_cannot_book_duplicate_seats_in_single_order(): void
    {
        $showtime = Showtime::where('show_date', '>=', Carbon::today())->first();
        $this->assertNotNull($showtime);

        $payload = [
            'showtime_id' => $showtime->id,
            'customer_name' => 'Duplicate Seat Booker',
            'customer_email' => 'duplicate@example.com',
            'customer_phone' => '08444444444',
            'seats' => ['A1', 'A1'],
            'payment_method' => 'QRIS',
        ];

        $response = $this->post(route('bookings.store'), $payload);
        $response->assertSessionHasErrors();
    }

    public function test_cannot_book_more_than_eight_seats(): void
    {
        $showtime = Showtime::where('show_date', '>=', Carbon::today())->first();
        $this->assertNotNull($showtime);

        $payload = [
            'showtime_id' => $showtime->id,
            'customer_name' => 'Greedy Booker',
            'customer_email' => 'greedy@example.com',
            'customer_phone' => '08555555555',
            'seats' => ['A1', 'A2', 'A3', 'A4', 'A5', 'A6', 'A7', 'A8', 'B1'],
            'payment_method' => 'QRIS',
        ];

        $response = $this->post(route('bookings.store'), $payload);
        $response->assertSessionHasErrors('seats');
    }

    public function test_cannot_book_past_showtime(): void
    {
        $showtime = Showtime::first();
        $this->assertNotNull($showtime);

        // Update showtime to yesterday
        $showtime->update([
            'show_date' => Carbon::yesterday()->toDateString(),
            'start_time' => '10:00:00',
        ]);

        $payload = [
            'showtime_id' => $showtime->id,
            'customer_name' => 'Past Booker',
            'customer_email' => 'past@example.com',
            'customer_phone' => '08666666666',
            'seats' => ['A1'],
            'payment_method' => 'QRIS',
        ];

        $response = $this->post(route('bookings.store'), $payload);
        $response->assertSessionHasErrors('seats');
    }
}
