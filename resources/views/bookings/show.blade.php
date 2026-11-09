@extends('layouts.app')

@section('title', 'E-Tiket & Barcode Bioskop: ' . $booking->booking_code . ' | balihfilm')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12">
    
    <!-- Top Action & Notice -->
    <div class="no-print mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-100 text-emerald-900 border border-emerald-300 text-xs font-semibold">
                <span class="w-2 h-2 rounded-full bg-emerald-600"></span>
                Pemesanan Berhasil & Terkonfirmasi
            </div>
            <h1 class="font-serif text-2xl sm:text-3xl font-bold text-[#350812] mt-2">
                E-Tiket & Barcode Bioskop
            </h1>
            <p class="text-xs sm:text-sm text-[#4B0C1A]/80 mt-0.5">
                Simpan atau unduh barcode di bawah ini untuk ditunjukkan kepada petugas saat masuk bioskop.
            </p>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-wrap items-center gap-2 shrink-0">
            <button type="button" 
                    id="downloadTicketBtn"
                    class="px-4 py-2.5 rounded-xl bg-[#4B0C1A] text-[#FAF6F0] hover:bg-[#641225] font-semibold text-xs transition-all shadow flex items-center gap-2 active:scale-95">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                <span>Download Tiket Lengkap</span>
            </button>
            <button type="button" 
                    id="downloadBarcodeOnlyBtn"
                    class="px-3.5 py-2.5 rounded-xl bg-[#FFFDF9] text-[#350812] hover:bg-[#F3EBE0] border border-[#D3C2AB] font-semibold text-xs transition-all shadow-sm flex items-center gap-1.5 active:scale-95">
                <svg class="w-4 h-4 text-[#4B0C1A]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/></svg>
                <span>Barcode Saja</span>
            </button>
            <button type="button" 
                    onclick="window.print()" 
                    class="px-3.5 py-2.5 rounded-xl bg-[#FFFDF9] text-[#350812] hover:bg-[#F3EBE0] border border-[#D3C2AB] font-semibold text-xs transition-all shadow-sm flex items-center gap-1.5 active:scale-95">
                <svg class="w-4 h-4 text-[#4B0C1A]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                <span>Cetak PDF</span>
            </button>
        </div>
    </div>

    <!-- Authentic Cinema Ticket Stub Pass (The printable & downloadable element) -->
    <div id="cinemaTicketCard" class="bg-[#FFFDF9] rounded-3xl border border-[#D3C2AB] shadow-xl overflow-hidden relative print-full">
        
        <!-- Ticket Header Banner (Burgundy) -->
        <div class="bg-[#350812] text-[#FAF6F0] p-6 sm:p-8 border-b-2 border-[#4B0C1A] relative">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-xl bg-[#4B0C1A] border border-[#7E1B31] flex items-center justify-center text-[#C49F6A]">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M4 4h16a2 2 0 012 2v12a2 2 0 01-2 2H4a2 2 0 01-2-2V6a2 2 0 012-2zm0 2v3h2V6H4zm4 0v3h8V6H8zm10 0v3h2V6h-2zM4 11v3h2v-3H4zm16 0v3h2v-3h-2zM4 16v2h2v-2H4zm16 0v2h2v-2h-2zM8 11h8v7H8v-7z"/>
                        </svg>
                    </div>
                    <div>
                        <div class="font-serif text-2xl font-bold tracking-wider text-[#FAF6F0]">
                            balih<span class="text-[#C49F6A]">film</span>
                        </div>
                        <div class="text-[10px] tracking-widest uppercase text-[#D3C2AB]">
                            Official Cinema Pass &bull; E-Ticket
                        </div>
                    </div>
                </div>

                <!-- Booking Code Badge -->
                <div class="text-left sm:text-right">
                    <span class="text-[10px] uppercase tracking-wider text-[#BAA386] block">Kode Pemesanan</span>
                    <span class="font-mono text-base sm:text-lg font-bold text-[#FAF6F0] tracking-wider select-all">
                        {{ $booking->booking_code }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Ticket Body Details -->
        <div class="p-6 sm:p-8 space-y-6">
            
            <!-- Movie Highlights -->
            <div class="grid grid-cols-1 sm:grid-cols-12 gap-6 items-center pb-6 border-b border-[#F3EBE0]">
                
                <div class="sm:col-span-8 space-y-2">
                    <div class="flex items-center gap-2">
                        <span class="px-2 py-0.5 rounded bg-[#4B0C1A] text-[#FAF6F0] text-[10px] font-bold">
                            {{ $movie->rating }}
                        </span>
                        <span class="text-xs font-semibold text-[#7E1B31] uppercase tracking-wider">
                            {{ $movie->genre }}
                        </span>
                    </div>

                    <h2 class="font-serif text-2xl sm:text-3xl font-bold text-[#350812]">
                        {{ $movie->title }}
                    </h2>

                    <div class="text-xs text-[#2B1D20]/80">
                        Durasi: {{ $movie->duration }} Menit &bull; Sutradara: {{ $movie->director ?? 'N/A' }}
                    </div>
                </div>

                <div class="sm:col-span-4 bg-[#FAF6F0] p-4 rounded-2xl border border-[#E5D9C7] text-center space-y-1">
                    <span class="text-[11px] text-[#BAA386] uppercase tracking-wider block font-medium">Studio Nonton</span>
                    <span class="font-serif font-bold text-base text-[#4B0C1A] block">
                        {{ $studio->name }}
                    </span>
                    <span class="text-[10px] px-2 py-0.5 rounded-full bg-[#E5D9C7] text-[#350812] inline-block font-semibold">
                        Layar Utama
                    </span>
                </div>

            </div>

            <!-- Key Screening Data: Date, Time & Seats -->
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 pb-6 border-b border-[#F3EBE0]">
                <div>
                    <span class="text-[11px] text-[#BAA386] uppercase tracking-wider block">Hari & Tanggal</span>
                    <span class="font-bold text-sm text-[#350812] block mt-0.5">
                        {{ \Carbon\Carbon::parse($showtime->show_date)->translatedFormat('l, d M Y') }}
                    </span>
                </div>

                <div>
                    <span class="text-[11px] text-[#BAA386] uppercase tracking-wider block">Jam Tayang</span>
                    <span class="font-bold text-sm text-[#4B0C1A] block mt-0.5">
                        {{ \Carbon\Carbon::parse($showtime->start_time)->format('H:i') }} WIB
                    </span>
                </div>

                <div>
                    <span class="text-[11px] text-[#BAA386] uppercase tracking-wider block">Jumlah Kursi</span>
                    <span class="font-bold text-sm text-[#350812] block mt-0.5">
                        {{ $booking->seat_count }} Tiket
                    </span>
                </div>

                <div>
                    <span class="text-[11px] text-[#BAA386] uppercase tracking-wider block">Nomor Kursi</span>
                    <div class="flex flex-wrap gap-1 mt-0.5">
                        @foreach ($booking->seats as $seat)
                            <span class="px-2 py-0.5 rounded-md bg-[#4B0C1A] text-[#FAF6F0] font-mono font-bold text-xs">
                                {{ $seat }}
                            </span>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Customer & Payment Details -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 text-xs pb-6 border-b border-[#F3EBE0]">
                <div>
                    <span class="text-[#BAA386] block">Nama Pemesan:</span>
                    <span class="font-bold text-[#350812] text-sm">{{ $booking->customer_name }}</span>
                    <span class="text-[#2B1D20]/70 block">{{ $booking->customer_phone }}</span>
                </div>

                <div>
                    <span class="text-[#BAA386] block">Metode Pembayaran:</span>
                    <span class="font-bold text-[#350812] text-sm">{{ $booking->payment_method }}</span>
                    <span class="text-emerald-700 font-semibold block flex items-center gap-1 mt-0.5">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        Pembayaran Lunas
                    </span>
                </div>

                <div>
                    <span class="text-[#BAA386] block">Total Pembayaran:</span>
                    <span class="font-serif font-extrabold text-lg text-[#4B0C1A]">
                        Rp {{ number_format($booking->total_amount, 0, ',', '.') }}
                    </span>
                    <span class="text-[11px] text-[#2B1D20]/60 block">Tiket: Rp {{ number_format($booking->ticket_subtotal, 0, ',', '.') }}</span>
                </div>
            </div>

            <!-- F&B Snack Order Section (if any) -->
            @if($booking->items->isNotEmpty())
                <div class="p-4 rounded-2xl bg-[#FAF6F0] border border-[#E5D9C7] space-y-2">
                    <div class="flex items-center justify-between">
                        <span class="font-serif font-bold text-xs sm:text-sm text-[#4B0C1A] flex items-center gap-1.5">
                            🍿 Pesanan Makanan & Minuman Bioskop
                        </span>
                        <span class="text-xs font-semibold text-[#350812]">
                            Subtotal: Rp {{ number_format($booking->snack_subtotal, 0, ',', '.') }}
                        </span>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 pt-1 text-xs">
                        @foreach ($booking->items as $item)
                            <div class="flex items-center justify-between p-2 rounded-lg bg-[#FFFDF9] border border-[#E5D9C7]">
                                <span class="font-medium text-[#350812]">
                                    {{ $item->quantity }}&times; {{ $item->concession->name }}
                                </span>
                                <span class="text-[#BAA386]">
                                    Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                    <div class="text-[11px] text-[#7E1B31] italic pt-1">
                        &bull; Tunjukkan barcode ini di loket Concession / F&B untuk mengambil pesanan Anda.
                    </div>
                </div>
            @endif

        </div>

        <!-- Ticket Perforated Divider Strip -->
        <div class="relative py-2 bg-[#FAF6F0] border-y-2 border-dashed border-[#D3C2AB] flex items-center justify-center">
            <div class="ticket-perforation-left"></div>
            <div class="ticket-perforation-right"></div>
            <span class="text-[11px] font-mono tracking-widest text-[#BAA386] uppercase select-none">
                - - - - - - - - TIKET MASUK RESMI - - - - - - - -
            </span>
        </div>

        <!-- Barcode & QR Code Section -->
        <div class="p-6 sm:p-8 bg-[#FFFDF9] text-center space-y-4">
            
            <div class="max-w-md mx-auto">
                <span class="text-xs font-bold uppercase tracking-wider text-[#350812] block mb-3">
                    Pindai Barcode / QR Code di Pintu Masuk
                </span>

                <!-- Barcode Graphics Card -->
                <div class="p-5 bg-white rounded-2xl border-2 border-[#350812] shadow-sm inline-block w-full">
                    
                    <!-- SVG Barcode Generator (Dynamically mapped based on token) -->
                    <div class="flex justify-center items-center py-2">
                        <svg id="barcodeSvg" class="w-full max-w-sm h-20" viewBox="0 0 320 80">
                            <rect width="320" height="80" fill="#ffffff"/>
                            <g id="barcodeBarsGroup" fill="#20040A">
                                <!-- Bars will be dynamically populated by JS based on barcode string -->
                            </g>
                            <text x="160" y="75" font-family="Space Mono, monospace" font-size="11" font-weight="bold" text-anchor="middle" fill="#20040A">
                                {{ $booking->barcode }}
                            </text>
                        </svg>
                    </div>

                    <div class="font-mono text-xs font-bold text-[#350812] tracking-wider pt-2 border-t border-gray-100 flex items-center justify-center gap-2">
                        <span>{{ $booking->barcode }}</span>
                    </div>
                </div>

                <div class="mt-4 p-3.5 rounded-xl bg-[#FAF6F0] border border-[#E5D9C7] text-xs text-[#4B0C1A] text-left space-y-1">
                    <div class="font-bold flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-[#4B0C1A]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span>Petunjuk Penukaran & Masuk Studio:</span>
                    </div>
                    <ul class="list-disc list-inside space-y-0.5 text-[11px] text-[#2B1D20]/80">
                        <li>Tunjukkan barcode pada tiket ini langsung dari layar ponsel Anda kepada petugas di pintu studio bioskop balihfilm.</li>
                        <li>Pintu studio dibuka 15 menit sebelum jam tayang film dimulai.</li>
                        <li>Jika Anda memesan paket makanan/snack, ambil di loket F&B dengan menunjukkan barcode ini.</li>
                    </ul>
                </div>

            </div>

        </div>

        <!-- Ticket Footer Ribbon -->
        <div class="bg-[#20040A] text-[#FAF6F0] p-4 text-center text-xs border-t border-[#350812]">
            <div class="flex flex-col sm:flex-row justify-between items-center max-w-xl mx-auto gap-2 text-[11px] text-[#D3C2AB]">
                <span>balihfilm Cinema &bull; Balih Central Mall Lt. 3</span>
                <span>Layanan Pelanggan: 0815-2943-4240</span>
            </div>
        </div>

    </div>

    <!-- Bottom Navigation CTA -->
    <div class="no-print mt-8 flex flex-col sm:flex-row items-center justify-between gap-4">
        <a href="{{ route('movies.index') }}" class="text-xs font-semibold text-[#4B0C1A] hover:underline flex items-center gap-1.5">
            <span>Kembali ke Jadwal Film</span>
        </a>

        <div class="flex items-center gap-3">
            <button type="button" 
                    id="copyBookingCodeBtn"
                    class="px-4 py-2.5 rounded-xl bg-[#FAF6F0] hover:bg-[#F3EBE0] border border-[#D3C2AB] text-xs font-semibold text-[#350812] transition-colors active:scale-95">
                Salin Kode Booking
            </button>
            <a href="{{ route('bookings.lookup') }}" class="text-xs text-[#7E1B31] font-semibold hover:underline">
                Cek Tiket Lainnya
            </a>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    @php
        $formattedTotal = 'Rp ' . number_format($booking->total_amount, 0, ',', '.');
        $formattedDate = \Carbon\Carbon::parse($showtime->show_date)->format('d M Y');
        $formattedTime = \Carbon\Carbon::parse($showtime->start_time)->format('H:i') . ' WIB';
        $seatsJoined = implode(', ', $booking->seats);
        $seatCountLabel = $booking->seat_count . ' Tiket';
        $snackStrings = $booking->items->map(fn($i) => $i->quantity . 'x ' . $i->concession->name)->values()->toArray();
    @endphp

    // Safely encoded data from PHP to avoid any JS apostrophe or quotes injection issues
    const bookingCode = @json($booking->booking_code);
    const barcodeCode = @json($booking->barcode);
    const movieTitle = @json($movie->title);
    const movieGenre = @json($movie->genre);
    const movieRating = @json($movie->rating);
    const studioName = @json($studio->name);
    const customerName = @json($booking->customer_name);
    const customerPhone = @json($booking->customer_phone);
    const paymentMethod = @json($booking->payment_method);
    const totalAmount = @json($formattedTotal);
    const showDate = @json($formattedDate);
    const showTime = @json($formattedTime);
    const seatsString = @json($seatsJoined);
    const seatCount = @json($seatCountLabel);
    const snackList = @json($snackStrings);

    // 1. Generate Algorithmic SVG Barcode based on barcodeCode
    function generateBarcodeBars(code) {
        const group = document.getElementById('barcodeBarsGroup');
        if (!group) return;
        group.innerHTML = '';

        let x = 15;
        const height = 55;
        const y = 5;

        // Start guard
        createBar(group, x, y, 3, height); x += 5;
        createBar(group, x, y, 1, height); x += 3;

        // Encode each character into bar patterns
        for (let i = 0; i < code.length; i++) {
            const charCode = code.charCodeAt(i);
            const w1 = (charCode % 4) + 1;
            const w2 = ((charCode >> 1) % 3) + 1;
            const w3 = ((charCode >> 2) % 4) + 1;

            createBar(group, x, y, w1, height); x += w1 + 2;
            createBar(group, x, y, w2, height); x += w2 + 2;
            createBar(group, x, y, w3, height); x += w3 + 3;
        }

        // End guard
        createBar(group, x, y, 2, height); x += 4;
        createBar(group, x, y, 3, height);
    }

    function createBar(parent, x, y, width, height) {
        const rect = document.createElementNS('http://www.w3.org/2000/svg', 'rect');
        rect.setAttribute('x', x);
        rect.setAttribute('y', y);
        rect.setAttribute('width', width);
        rect.setAttribute('height', height);
        parent.appendChild(rect);
    }

    generateBarcodeBars(barcodeCode);

    // 2. Copy Code to Clipboard
    const copyBtn = document.getElementById('copyBookingCodeBtn');
    if (copyBtn) {
        copyBtn.addEventListener('click', function() {
            navigator.clipboard.writeText(bookingCode).then(function() {
                const originalText = copyBtn.textContent;
                copyBtn.textContent = 'Kode Berhasil Disalin!';
                copyBtn.classList.add('bg-emerald-100', 'text-emerald-900', 'border-emerald-300');
                setTimeout(() => {
                    copyBtn.textContent = originalText;
                    copyBtn.classList.remove('bg-emerald-100', 'text-emerald-900', 'border-emerald-300');
                }, 2000);
            });
        });
    }

    // 3. Download Full Ticket Pass as High-Res PNG
    const downloadTicketBtn = document.getElementById('downloadTicketBtn');
    if (downloadTicketBtn) {
        downloadTicketBtn.addEventListener('click', function() {
            downloadFullTicketImage();
        });
    }

    function downloadFullTicketImage() {
        const canvas = document.createElement('canvas');
        const ctx = canvas.getContext('2d');
        const scale = 2; // Retina quality

        // Calculate dynamic height based on snack items
        const baseHeight = 780 + (snackList.length > 0 ? (snackList.length * 24) : 0);
        canvas.width = 650 * scale;
        canvas.height = baseHeight * scale;
        ctx.scale(scale, scale);

        // 1. Ticket Card Background
        ctx.fillStyle = '#FFFDF9';
        ctx.fillRect(0, 0, 650, baseHeight);
        ctx.strokeStyle = '#D3C2AB';
        ctx.lineWidth = 1;
        ctx.strokeRect(0, 0, 650, baseHeight);

        // 2. Header Burgundy
        ctx.fillStyle = '#350812';
        ctx.fillRect(0, 0, 650, 95);

        ctx.fillStyle = '#FAF6F0';
        ctx.font = 'bold 24px Georgia, serif';
        ctx.fillText('balihfilm', 40, 48);

        ctx.fillStyle = '#C49F6A';
        ctx.font = 'bold 11px sans-serif';
        ctx.fillText('OFFICIAL CINEMA PASS • E-TICKET', 40, 72);

        ctx.fillStyle = '#D3C2AB';
        ctx.font = '10px sans-serif';
        ctx.textAlign = 'right';
        ctx.fillText('KODE PEMESANAN', 610, 45);

        ctx.fillStyle = '#FAF6F0';
        ctx.font = 'bold 16px monospace';
        ctx.fillText(bookingCode, 610, 68);
        ctx.textAlign = 'left';

        // 3. Movie Title & Studio
        ctx.fillStyle = '#7E1B31';
        ctx.font = 'bold 11px sans-serif';
        ctx.fillText(movieGenre.toUpperCase() + ' • RATING ' + movieRating, 40, 135);

        ctx.fillStyle = '#350812';
        ctx.font = 'bold 22px Georgia, serif';
        ctx.fillText(movieTitle, 40, 168);

        ctx.fillStyle = '#4B0C1A';
        ctx.font = 'bold 13px sans-serif';
        ctx.fillText('Studio: ' + studioName, 40, 196);

        // 4. Date / Time / Seats Box
        ctx.fillStyle = '#FAF6F0';
        ctx.fillRect(40, 220, 570, 75);
        ctx.strokeStyle = '#E5D9C7';
        ctx.strokeRect(40, 220, 570, 75);

        ctx.fillStyle = '#7E1B31';
        ctx.font = '11px sans-serif';
        ctx.fillText('TANGGAL TAYANG', 60, 245);
        ctx.fillText('JAM TAYANG', 240, 245);
        ctx.fillText('KURSI DIPILIH', 420, 245);

        ctx.fillStyle = '#350812';
        ctx.font = 'bold 14px sans-serif';
        ctx.fillText(showDate, 60, 270);
        ctx.fillText(showTime, 240, 270);
        ctx.fillText(seatsString + ' (' + seatCount + ')', 420, 270);

        // 5. Customer & Payment Information
        let currentY = 325;
        ctx.fillStyle = '#350812';
        ctx.font = '12px sans-serif';
        ctx.fillText('Pemesan: ' + customerName + ' (' + customerPhone + ')', 40, currentY);
        currentY += 24;
        ctx.fillText('Total Pembayaran: ' + totalAmount + ' (Lunas - ' + paymentMethod + ')', 40, currentY);

        if (snackList.length > 0) {
            currentY += 28;
            ctx.fillStyle = '#4B0C1A';
            ctx.font = 'bold 12px sans-serif';
            ctx.fillText('Pesanan Snack & F&B:', 40, currentY);
            ctx.font = '12px sans-serif';
            snackList.forEach(snack => {
                currentY += 20;
                ctx.fillText('• ' + snack, 55, currentY);
            });
        }

        // 6. Perforated divider line
        currentY += 30;
        ctx.setLineDash([6, 6]);
        ctx.strokeStyle = '#D3C2AB';
        ctx.beginPath();
        ctx.moveTo(0, currentY);
        ctx.lineTo(650, currentY);
        ctx.stroke();
        ctx.setLineDash([]);

        // 7. Barcode Box
        currentY += 35;
        ctx.fillStyle = '#350812';
        ctx.font = 'bold 12px sans-serif';
        ctx.textAlign = 'center';
        ctx.fillText('PINDAI BARCODE DI PINTU MASUK BIOSKOP', 325, currentY);

        currentY += 25;
        // White barcode container
        ctx.fillStyle = '#ffffff';
        ctx.fillRect(125, currentY, 400, 110);
        ctx.strokeStyle = '#350812';
        ctx.lineWidth = 1.5;
        ctx.strokeRect(125, currentY, 400, 110);

        // Draw barcode bars inside container
        let barX = 145;
        const barY = currentY + 15;
        const bHeight = 55;
        ctx.fillStyle = '#20040A';

        // Draw start guard
        ctx.fillRect(barX, barY, 3, bHeight); barX += 5;
        ctx.fillRect(barX, barY, 1, bHeight); barX += 3;

        for (let i = 0; i < barcodeCode.length; i++) {
            const codeVal = barcodeCode.charCodeAt(i);
            const w1 = (codeVal % 4) + 1;
            const w2 = ((codeVal >> 1) % 3) + 1;
            const w3 = ((codeVal >> 2) % 4) + 1;

            ctx.fillRect(barX, barY, w1, bHeight); barX += w1 + 2;
            ctx.fillRect(barX, barY, w2, bHeight); barX += w2 + 2;
            ctx.fillRect(barX, barY, w3, bHeight); barX += w3 + 3;
        }

        ctx.fillRect(barX, barY, 2, bHeight); barX += 4;
        ctx.fillRect(barX, barY, 3, bHeight);

        // Text below barcode
        ctx.fillStyle = '#20040A';
        ctx.font = 'bold 13px monospace';
        ctx.fillText(barcodeCode, 325, currentY + 95);

        // 8. Footer Ribbon
        const footerY = baseHeight - 50;
        ctx.fillStyle = '#20040A';
        ctx.fillRect(0, footerY, 650, 50);
        ctx.fillStyle = '#FAF6F0';
        ctx.font = '11px sans-serif';
        ctx.fillText('balihfilm Cinema • Balih Central Mall Lt. 3 • WhatsApp Bantuan: 0815-2943-4240', 325, footerY + 30);

        // Export to PNG
        const link = document.createElement('a');
        link.download = 'tiket-balihfilm-' + bookingCode + '.png';
        link.href = canvas.toDataURL('image/png');
        link.click();
    }

    // 4. Download Barcode-Only Compact Card
    const downloadBarcodeOnlyBtn = document.getElementById('downloadBarcodeOnlyBtn');
    if (downloadBarcodeOnlyBtn) {
        downloadBarcodeOnlyBtn.addEventListener('click', function() {
            downloadBarcodeOnlyImage();
        });
    }

    function downloadBarcodeOnlyImage() {
        const canvas = document.createElement('canvas');
        const ctx = canvas.getContext('2d');
        const scale = 2;

        canvas.width = 440 * scale;
        canvas.height = 260 * scale;
        ctx.scale(scale, scale);

        // Background
        ctx.fillStyle = '#FFFDF9';
        ctx.fillRect(0, 0, 440, 260);
        ctx.strokeStyle = '#4B0C1A';
        ctx.lineWidth = 2;
        ctx.strokeRect(0, 0, 440, 260);

        // Header
        ctx.fillStyle = '#350812';
        ctx.fillRect(0, 0, 440, 45);
        ctx.fillStyle = '#FAF6F0';
        ctx.font = 'bold 16px Georgia, serif';
        ctx.fillText('balihfilm Cinema Pass', 20, 28);

        ctx.fillStyle = '#C49F6A';
        ctx.font = 'bold 12px monospace';
        ctx.textAlign = 'right';
        ctx.fillText(bookingCode, 420, 28);
        ctx.textAlign = 'left';

        // Movie & Seat line
        ctx.fillStyle = '#350812';
        ctx.font = 'bold 13px sans-serif';
        ctx.fillText(movieTitle + ' • ' + studioName, 20, 70);
        ctx.font = '12px sans-serif';
        ctx.fillStyle = '#7E1B31';
        ctx.fillText(showDate + ' ' + showTime + ' | Kursi: ' + seatsString, 20, 90);

        // Barcode Container
        ctx.fillStyle = '#ffffff';
        ctx.fillRect(20, 110, 400, 100);
        ctx.strokeStyle = '#D3C2AB';
        ctx.strokeRect(20, 110, 400, 100);

        // Draw Bars
        let barX = 40;
        const barY = 125;
        const bHeight = 50;
        ctx.fillStyle = '#20040A';

        ctx.fillRect(barX, barY, 3, bHeight); barX += 5;
        ctx.fillRect(barX, barY, 1, bHeight); barX += 3;

        for (let i = 0; i < barcodeCode.length; i++) {
            const codeVal = barcodeCode.charCodeAt(i);
            const w1 = (codeVal % 4) + 1;
            const w2 = ((codeVal >> 1) % 3) + 1;
            const w3 = ((codeVal >> 2) % 4) + 1;

            ctx.fillRect(barX, barY, w1, bHeight); barX += w1 + 2;
            ctx.fillRect(barX, barY, w2, bHeight); barX += w2 + 2;
            ctx.fillRect(barX, barY, w3, bHeight); barX += w3 + 3;
        }

        ctx.fillRect(barX, barY, 2, bHeight); barX += 4;
        ctx.fillRect(barX, barY, 3, bHeight);

        // Text below barcode
        ctx.font = 'bold 12px monospace';
        ctx.textAlign = 'center';
        ctx.fillText(barcodeCode, 220, 195);

        // Footer
        ctx.fillStyle = '#BAA386';
        ctx.font = '10px sans-serif';
        ctx.fillText('Tunjukkan barcode ini kepada petugas studio balihfilm', 220, 235);

        // Export
        const link = document.createElement('a');
        link.download = 'barcode-balihfilm-' + bookingCode + '.png';
        link.href = canvas.toDataURL('image/png');
        link.click();
    }
});
</script>
@endpush
