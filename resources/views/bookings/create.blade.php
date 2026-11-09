@extends('layouts.app')

@section('title', 'Pilih Kursi & Pesan Tiket: ' . $movie->title . ' | balihfilm')

@section('content')
<!-- Booking Header Bar -->
<div class="bg-[#20040A] text-[#FAF6F0] border-b border-[#4B0C1A] py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            
            <div class="flex items-center gap-4">
                <div class="w-14 h-20 rounded-xl overflow-hidden shrink-0 border border-[#7E1B31] bg-[#350812]">
                    <img src="{{ $movie->poster_url }}" alt="{{ $movie->title }}" class="w-full h-full object-cover">
                </div>
                <div>
                    <span class="text-[11px] text-[#C49F6A] font-bold uppercase tracking-wider">
                        {{ $studio->name }} &bull; {{ $movie->rating }}
                    </span>
                    <h1 class="font-serif text-xl sm:text-2xl font-bold text-[#FAF6F0] leading-tight">
                        {{ $movie->title }}
                    </h1>
                    <div class="text-xs text-[#D3C2AB] mt-1 flex flex-wrap items-center gap-2 sm:gap-3">
                        <span>
                            📅 {{ \Carbon\Carbon::parse($showtime->show_date)->translatedFormat('l, d F Y') }}
                        </span>
                        <span>&bull;</span>
                        <span class="font-semibold text-white">
                            ⏰ {{ \Carbon\Carbon::parse($showtime->start_time)->format('H:i') }} WIB
                        </span>
                        <span>&bull;</span>
                        <span>Rp {{ number_format($showtime->price, 0, ',', '.') }}/kursi</span>
                    </div>
                </div>
            </div>

            <div class="flex items-center gap-2 self-start md:self-auto">
                <a href="{{ route('movies.show', $movie->slug) }}" 
                   class="px-3.5 py-2 rounded-xl bg-[#350812] hover:bg-[#4B0C1A] border border-[#641225] text-xs font-semibold text-[#D3C2AB] hover:text-white transition-colors">
                    Ganti Jam Tayang
                </a>
            </div>

        </div>
    </div>
</div>

<!-- Main Booking Form Container -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <form action="{{ route('bookings.store') }}" method="POST" id="bookingForm">
        @csrf
        <input type="hidden" name="showtime_id" value="{{ $showtime->id }}">
        
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            
            <!-- Left Column: Seat Map + Concessions + Customer Data (8 cols) -->
            <div class="lg:col-span-8 space-y-8">
                
                <!-- Step 1: Seat Selection Card -->
                <div class="bg-[#FFFDF9] rounded-2xl border border-[#E5D9C7] p-6 sm:p-8 shadow-sm">
                    
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 mb-6 pb-4 border-b border-[#F3EBE0]">
                        <div>
                            <div class="flex items-center gap-2">
                                <span class="w-6 h-6 rounded-full bg-[#4B0C1A] text-[#FAF6F0] flex items-center justify-center font-bold text-xs">
                                    1
                                </span>
                                <h2 class="font-serif text-xl font-bold text-[#350812]">
                                    Pilih Tempat Duduk
                                </h2>
                            </div>
                            <p class="text-xs text-[#2B1D20]/75 mt-1">
                                Klik kursi yang masih tersedia untuk memilih. Maksimal 8 kursi per pemesanan.
                            </p>
                        </div>

                        <!-- Legend -->
                        <div class="flex items-center gap-4 text-xs font-medium pt-2 sm:pt-0">
                            <div class="flex items-center gap-1.5">
                                <span class="w-4 h-4 rounded bg-[#FAF6F0] border border-[#BAA386]"></span>
                                <span class="text-[#350812]">Tersedia</span>
                            </div>
                            <div class="flex items-center gap-1.5">
                                <span class="w-4 h-4 rounded bg-[#4B0C1A] border border-[#4B0C1A]"></span>
                                <span class="text-[#350812]">Pilihan Anda</span>
                            </div>
                            <div class="flex items-center gap-1.5">
                                <span class="w-4 h-4 rounded bg-[#D3C2AB] border border-[#BAA386] opacity-60"></span>
                                <span class="text-[#7E1B31]/70">Sudah Terisi</span>
                            </div>
                        </div>
                    </div>

                    <!-- Seat Error Notice if any -->
                    @if($errors->has('seats'))
                        <div class="mb-6 p-4 rounded-xl bg-rose-50 border border-rose-300 text-rose-900 text-xs font-medium flex items-start gap-2.5">
                            <svg class="w-4 h-4 text-rose-600 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span>{{ $errors->first('seats') }}</span>
                        </div>
                    @endif

                    <!-- Cinema Screen Visual Representation -->
                    <div class="max-w-xl mx-auto my-8 text-center">
                        <div class="cinema-screen h-3 mb-2 bg-[#E5D9C7]"></div>
                        <span class="text-[11px] font-bold uppercase tracking-widest text-[#BAA386]">
                            &bull; LAYAR BIOSKOP &bull;
                        </span>
                    </div>

                    <!-- Seat Layout Grid -->
                    <div class="overflow-x-auto pb-4">
                        <div class="min-w-[480px] max-w-lg mx-auto space-y-3">
                            @foreach ($rowLabels as $row)
                                <div class="flex items-center justify-center gap-2">
                                    
                                    <!-- Left Row Label -->
                                    <span class="w-6 text-center font-serif font-bold text-sm text-[#4B0C1A]">
                                        {{ $row }}
                                    </span>

                                    <!-- Seats in this row -->
                                    <div class="flex items-center gap-1.5 sm:gap-2">
                                        @for ($col = 1; $col <= $totalCols; $col++)
                                            @php
                                                $seatId = $row . $col;
                                                $isBooked = in_array($seatId, $bookedSeats);
                                                $isOldChecked = in_array($seatId, old('seats', []));
                                                $isAisleGap = ($col === (int) ceil($totalCols / 2));
                                            @endphp

                                            <label class="cursor-pointer relative select-none">
                                                @if($isBooked)
                                                    <input type="checkbox" disabled class="hidden peer" aria-label="Kursi {{ $seatId }}, sudah terisi">
                                                    <div class="w-8 h-8 sm:w-9 sm:h-9 rounded-lg bg-[#D3C2AB]/50 border border-[#BAA386]/40 text-[#7E1B31]/50 flex items-center justify-center text-xs font-semibold cursor-not-allowed" title="Kursi {{ $seatId }} sudah dipesan">
                                                        &times;
                                                    </div>
                                                @else
                                                    <input type="checkbox" 
                                                           name="seats[]" 
                                                           value="{{ $seatId }}" 
                                                           id="seat-{{ $seatId }}"
                                                           class="seat-checkbox sr-only peer"
                                                           aria-label="Kursi {{ $seatId }}"
                                                           data-seat="{{ $seatId }}"
                                                           {{ $isOldChecked ? 'checked' : '' }}>
                                                    <div class="w-8 h-8 sm:w-9 sm:h-9 rounded-lg bg-[#FAF6F0] hover:bg-[#F3EBE0] border border-[#BAA386] text-[#350812] font-semibold text-xs flex items-center justify-center transition-all peer-checked:bg-[#4B0C1A] peer-checked:text-[#FAF6F0] peer-checked:border-[#20040A] peer-checked:scale-95 shadow-sm active:scale-90 peer-focus-visible:ring-2 peer-focus-visible:ring-[#C49F6A]">
                                                        {{ $col }}
                                                    </div>
                                                @endif
                                            </label>

                                            <!-- Aisle Space -->
                                            @if($isAisleGap)
                                                <div class="w-4 sm:w-6 text-center text-[10px] text-[#BAA386]"></div>
                                            @endif
                                        @endfor
                                    </div>

                                    <!-- Right Row Label -->
                                    <span class="w-6 text-center font-serif font-bold text-sm text-[#4B0C1A]">
                                        {{ $row }}
                                    </span>

                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Seat Selection Feedback Alert -->
                    <div id="seatNotice" class="mt-4 p-3 rounded-xl bg-[#FAF6F0] border border-[#E5D9C7] text-xs text-[#350812] flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <span class="font-medium">Kursi Terpilih:</span>
                            <span id="selectedSeatsText" class="font-bold text-[#4B0C1A]">Belum ada kursi dipilih</span>
                        </div>
                        <span id="selectedSeatsCountBadge" class="px-2 py-0.5 rounded bg-[#4B0C1A] text-[#FAF6F0] text-[11px] font-bold hidden">
                            0 Kursi
                        </span>
                    </div>

                </div>

                <!-- Step 2: Food & Beverages (Concessions) Card -->
                <div class="bg-[#FFFDF9] rounded-2xl border border-[#E5D9C7] p-6 sm:p-8 shadow-sm">
                    
                    <div class="mb-6 pb-4 border-b border-[#F3EBE0]">
                        <div class="flex items-center gap-2">
                            <span class="w-6 h-6 rounded-full bg-[#4B0C1A] text-[#FAF6F0] flex items-center justify-center font-bold text-xs">
                                2
                            </span>
                            <h2 class="font-serif text-xl font-bold text-[#350812]">
                                Tambah Makanan & Minuman (F&B)
                            </h2>
                        </div>
                        <p class="text-xs text-[#2B1D20]/75 mt-1">
                            Pilih camilan popcorn hangat, nachos, dan minuman segar untuk dinikmati saat menonton (Opsional).
                        </p>
                    </div>

                    <div class="space-y-6">
                        @foreach ($concessions as $category => $items)
                            <div>
                                <h3 class="font-serif text-sm font-bold text-[#4B0C1A] uppercase tracking-wider mb-3 flex items-center gap-2">
                                    @if($category === 'popcorn')
                                        🍿 Popcorn Bioskop
                                    @elseif($category === 'snack')
                                        🍟 Camilan & Snack
                                    @elseif($category === 'beverage')
                                        🥤 Minuman Dingin & Hangat
                                    @elseif($category === 'combo')
                                        ✨ Paket Hemat Combo Nonton
                                    @else
                                        {{ ucfirst($category) }}
                                    @endif
                                </h3>

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    @foreach ($items as $item)
                                        @php
                                            $oldQty = (int) old('concessions.' . $item->id, 0);
                                        @endphp
                                        <div class="p-3.5 rounded-xl bg-[#FAF6F0] border border-[#E5D9C7] flex items-center justify-between gap-3 hover:border-[#BAA386] transition-colors">
                                            
                                            <div class="flex items-center gap-3">
                                                <div class="w-14 h-14 rounded-xl overflow-hidden shrink-0 bg-[#E5D9C7] flex items-center justify-center relative shadow-sm">
                                                    <span class="text-2xl select-none" aria-hidden="true">
                                                        @if($item->category === 'popcorn') 🍿
                                                        @elseif($item->category === 'beverage') 🥤
                                                        @elseif($item->category === 'snack') 🍟
                                                        @elseif($item->category === 'combo') ✨
                                                        @else 🍽️
                                                        @endif
                                                    </span>
                                                    @if($item->image_url)
                                                        <img src="{{ $item->image_url }}" 
                                                             alt="{{ $item->name }}" 
                                                             loading="lazy"
                                                             class="absolute inset-0 w-full h-full object-cover transition-opacity duration-200"
                                                             onerror="this.style.display='none';">
                                                    @endif
                                                </div>
                                                <div>
                                                    <div class="font-bold text-xs sm:text-sm text-[#350812] leading-snug">
                                                        {{ $item->name }}
                                                    </div>
                                                    <div class="text-[11px] text-[#2B1D20]/70 line-clamp-1 mt-0.5">
                                                        {{ $item->description }}
                                                    </div>
                                                    <div class="text-xs font-bold text-[#4B0C1A] mt-1">
                                                        Rp {{ number_format($item->price, 0, ',', '.') }}
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Touch-Friendly Quantity Controls (min 40px tap target) -->
                                            <div class="flex items-center gap-1.5 shrink-0">
                                                <button type="button" 
                                                        aria-label="Kurangi {{ $item->name }}"
                                                        class="w-10 h-10 sm:w-9 sm:h-9 rounded-xl bg-[#FFFDF9] border border-[#D3C2AB] text-[#350812] font-bold text-base flex items-center justify-center hover:bg-[#F3EBE0] active:scale-95 transition-all qty-minus-btn"
                                                        data-id="{{ $item->id }}"
                                                        data-name="{{ $item->name }}"
                                                        data-price="{{ $item->price }}">
                                                    -
                                                </button>
                                                
                                                <span id="qty-display-{{ $item->id }}" class="w-7 text-center font-bold text-xs sm:text-sm text-[#350812]">
                                                    {{ $oldQty }}
                                                </span>
                                                <input type="hidden" 
                                                       name="concessions[{{ $item->id }}]" 
                                                       id="concession-input-{{ $item->id }}" 
                                                       value="{{ $oldQty }}"
                                                       class="concession-quantity"
                                                       data-id="{{ $item->id }}"
                                                       data-name="{{ $item->name }}"
                                                       data-price="{{ $item->price }}">

                                                <button type="button" 
                                                        aria-label="Tambah {{ $item->name }}"
                                                        class="w-10 h-10 sm:w-9 sm:h-9 rounded-xl bg-[#4B0C1A] text-[#FAF6F0] font-bold text-base flex items-center justify-center hover:bg-[#641225] active:scale-95 transition-all qty-plus-btn"
                                                        data-id="{{ $item->id }}"
                                                        data-name="{{ $item->name }}"
                                                        data-price="{{ $item->price }}">
                                                    +
                                                </button>
                                            </div>

                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>

                </div>

                <!-- Step 3: Customer Information & Payment -->
                <div class="bg-[#FFFDF9] rounded-2xl border border-[#E5D9C7] p-6 sm:p-8 shadow-sm">
                    
                    <div class="mb-6 pb-4 border-b border-[#F3EBE0]">
                        <div class="flex items-center gap-2">
                            <span class="w-6 h-6 rounded-full bg-[#4B0C1A] text-[#FAF6F0] flex items-center justify-center font-bold text-xs">
                                3
                            </span>
                            <h2 class="font-serif text-xl font-bold text-[#350812]">
                                Data Pemesan & Pembayaran
                            </h2>
                        </div>
                        <p class="text-xs text-[#2B1D20]/75 mt-1">
                            Barcode tiket bioskop akan diterbitkan langsung dan dikirimkan ke email Anda.
                        </p>
                    </div>

                    <div class="space-y-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label for="customer_name" class="block text-xs font-semibold text-[#350812] mb-1.5">
                                    Nama Lengkap <span class="text-rose-600">*</span>
                                </label>
                                <input type="text" 
                                       id="customer_name" 
                                       name="customer_name" 
                                       value="{{ old('customer_name') }}"
                                       required
                                       placeholder="Nama sesuai KTP / ID"
                                       class="w-full px-3.5 py-2.5 rounded-xl bg-[#FAF6F0] border border-[#D3C2AB] text-sm text-[#2B1D20] placeholder-[#BAA386] focus:outline-none focus:border-[#4B0C1A] focus:ring-1 focus:ring-[#4B0C1A] transition-colors">
                            </div>

                            <div>
                                <label for="customer_phone" class="block text-xs font-semibold text-[#350812] mb-1.5">
                                    Nomor WhatsApp / HP <span class="text-rose-600">*</span>
                                </label>
                                <input type="tel" 
                                       id="customer_phone" 
                                       name="customer_phone" 
                                       value="{{ old('customer_phone') }}"
                                       required
                                       placeholder="Contoh: 081234567890"
                                       class="w-full px-3.5 py-2.5 rounded-xl bg-[#FAF6F0] border border-[#D3C2AB] text-sm text-[#2B1D20] placeholder-[#BAA386] focus:outline-none focus:border-[#4B0C1A] focus:ring-1 focus:ring-[#4B0C1A] transition-colors">
                            </div>
                        </div>

                        <div>
                            <label for="customer_email" class="block text-xs font-semibold text-[#350812] mb-1.5">
                                Alamat Email <span class="text-rose-600">*</span>
                            </label>
                            <input type="email" 
                                   id="customer_email" 
                                   name="customer_email" 
                                   value="{{ old('customer_email') }}"
                                   required
                                   placeholder="nama@email.com (untuk arsip e-tiket)"
                                   class="w-full px-3.5 py-2.5 rounded-xl bg-[#FAF6F0] border border-[#D3C2AB] text-sm text-[#2B1D20] placeholder-[#BAA386] focus:outline-none focus:border-[#4B0C1A] focus:ring-1 focus:ring-[#4B0C1A] transition-colors">
                        </div>

                        <!-- Payment Method Selector -->
                        <div class="pt-3">
                            <label class="block text-xs font-semibold text-[#350812] mb-2">
                                Pilih Metode Pembayaran <span class="text-rose-600">*</span>
                            </label>

                            @php
                                $selectedPayment = old('payment_method', 'QRIS');
                            @endphp

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                
                                <label class="p-3.5 rounded-xl border border-[#D3C2AB] bg-[#FAF6F0] hover:bg-[#F3EBE0] cursor-pointer flex items-center gap-3 transition-colors has-[:checked]:border-[#4B0C1A] has-[:checked]:bg-[#4B0C1A]/5">
                                    <input type="radio" name="payment_method" value="QRIS" {{ $selectedPayment === 'QRIS' ? 'checked' : '' }} class="text-[#4B0C1A] focus:ring-[#4B0C1A]">
                                    <div>
                                        <div class="text-xs font-bold text-[#350812]">QRIS (Instan & Bebas Biaya)</div>
                                        <div class="text-[10px] text-[#2B1D20]/70">Scan GoPay, OVO, Dana, BCA, Livin</div>
                                    </div>
                                </label>

                                <label class="p-3.5 rounded-xl border border-[#D3C2AB] bg-[#FAF6F0] hover:bg-[#F3EBE0] cursor-pointer flex items-center gap-3 transition-colors has-[:checked]:border-[#4B0C1A] has-[:checked]:bg-[#4B0C1A]/5">
                                    <input type="radio" name="payment_method" value="BCA Virtual Account" {{ $selectedPayment === 'BCA Virtual Account' ? 'checked' : '' }} class="text-[#4B0C1A] focus:ring-[#4B0C1A]">
                                    <div>
                                        <div class="text-xs font-bold text-[#350812]">BCA Virtual Account</div>
                                        <div class="text-[10px] text-[#2B1D20]/70">Verifikasi otomatis 24 Jam</div>
                                    </div>
                                </label>

                                <label class="p-3.5 rounded-xl border border-[#D3C2AB] bg-[#FAF6F0] hover:bg-[#F3EBE0] cursor-pointer flex items-center gap-3 transition-colors has-[:checked]:border-[#4B0C1A] has-[:checked]:bg-[#4B0C1A]/5">
                                    <input type="radio" name="payment_method" value="Mandiri Virtual Account" {{ $selectedPayment === 'Mandiri Virtual Account' ? 'checked' : '' }} class="text-[#4B0C1A] focus:ring-[#4B0C1A]">
                                    <div>
                                        <div class="text-xs font-bold text-[#350812]">Mandiri Virtual Account</div>
                                        <div class="text-[10px] text-[#2B1D20]/70">Livin by Mandiri & ATM</div>
                                    </div>
                                </label>

                                <label class="p-3.5 rounded-xl border border-[#D3C2AB] bg-[#FAF6F0] hover:bg-[#F3EBE0] cursor-pointer flex items-center gap-3 transition-colors has-[:checked]:border-[#4B0C1A] has-[:checked]:bg-[#4B0C1A]/5">
                                    <input type="radio" name="payment_method" value="Tunai di Bioskop" {{ $selectedPayment === 'Tunai di Bioskop' ? 'checked' : '' }} class="text-[#4B0C1A] focus:ring-[#4B0C1A]">
                                    <div>
                                        <div class="text-xs font-bold text-[#350812]">Bayar di Kasir Bioskop</div>
                                        <div class="text-[10px] text-[#2B1D20]/70">Bayar saat check-in di loket</div>
                                    </div>
                                </label>

                            </div>
                        </div>

                    </div>

                </div>

            </div>

            <!-- Right Column: Sticky Summary & Checkout (4 cols) -->
            <div class="lg:col-span-4 sticky top-28 space-y-6">
                
                <div class="bg-[#FFFDF9] rounded-2xl border border-[#E5D9C7] p-6 shadow-md">
                    
                    <h3 class="font-serif text-lg font-bold text-[#350812] pb-3 mb-4 border-b border-[#F3EBE0]">
                        Ringkasan Pemesanan
                    </h3>

                    <!-- Movie & Showtime Info -->
                    <div class="space-y-2 text-xs pb-4 border-b border-[#F3EBE0]">
                        <div class="font-bold text-sm text-[#4B0C1A]">{{ $movie->title }}</div>
                        <div class="text-[#2B1D20]/80">
                            {{ $studio->name }} &bull; {{ $movie->rating }}
                        </div>
                        <div class="text-[#2B1D20]/80">
                            {{ \Carbon\Carbon::parse($showtime->show_date)->translatedFormat('l, d M Y') }} &bull; {{ \Carbon\Carbon::parse($showtime->start_time)->format('H:i') }} WIB
                        </div>
                    </div>

                    <!-- Selected Seats Breakdown -->
                    <div class="py-4 border-b border-[#F3EBE0] space-y-2">
                        <div class="flex justify-between items-center text-xs">
                            <span class="text-[#2B1D20]/80">Kursi Dipilih:</span>
                            <span id="summarySeatsList" class="font-bold text-[#350812]">Belum ada</span>
                        </div>
                        <div class="flex justify-between items-center text-xs">
                            <span class="text-[#2B1D20]/80">
                                Subtotal Tiket (<span id="summarySeatQty">0</span> &times; Rp {{ number_format($showtime->price, 0, ',', '.') }}):
                            </span>
                            <span id="summaryTicketSubtotal" class="font-bold text-[#350812]">
                                Rp 0
                            </span>
                        </div>
                    </div>

                    <!-- Snacks Breakdown -->
                    <div class="py-4 border-b border-[#F3EBE0] space-y-2">
                        <div class="flex justify-between items-center text-xs">
                            <span class="text-[#2B1D20]/80">Makanan & Minuman:</span>
                            <span id="summarySnackSubtotal" class="font-bold text-[#350812]">Rp 0</span>
                        </div>
                        <!-- List of selected snacks -->
                        <div id="summarySnacksList" class="text-[11px] text-[#2B1D20]/70 space-y-1">
                            <div class="italic text-[#BAA386]">Belum ada pesanan snack</div>
                        </div>
                    </div>

                    <!-- Grand Total -->
                    <div class="py-4 space-y-1">
                        <div class="flex justify-between items-center">
                            <span class="font-serif font-bold text-sm text-[#350812]">Total Pembayaran:</span>
                            <span id="summaryGrandTotal" class="font-serif font-extrabold text-xl text-[#4B0C1A]">
                                Rp 0
                            </span>
                        </div>
                        <div class="text-[11px] text-[#BAA386]">
                            Termasuk pajak & biaya pemesanan bioskop
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" 
                            id="submitBookingBtn" 
                            disabled
                            class="w-full mt-4 py-3.5 px-6 rounded-xl bg-[#4B0C1A] text-[#FAF6F0] font-bold text-sm transition-all shadow-md flex items-center justify-center gap-2 hover:bg-[#641225] disabled:opacity-50 disabled:cursor-not-allowed active:scale-95">
                        <span>Konfirmasi & Dapatkan Barcode</span>
                    </button>

                    <p class="text-[11px] text-center text-[#2B1D20]/60 mt-3 leading-relaxed">
                        Dengan menekan tombol, Anda menyetujui jadwal dan posisi kursi yang dipilih. Barcode akan langsung dapat diunduh.
                    </p>

                </div>

            </div>

        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ticketPrice = {{ $showtime->price }};
    const maxSeats = 8;

    // Elements
    const seatCheckboxes = document.querySelectorAll('.seat-checkbox');
    const selectedSeatsText = document.getElementById('selectedSeatsText');
    const selectedSeatsCountBadge = document.getElementById('selectedSeatsCountBadge');
    const summarySeatsList = document.getElementById('summarySeatsList');
    const summarySeatQty = document.getElementById('summarySeatQty');
    const summaryTicketSubtotal = document.getElementById('summaryTicketSubtotal');
    const summarySnackSubtotal = document.getElementById('summarySnackSubtotal');
    const summarySnacksList = document.getElementById('summarySnacksList');
    const summaryGrandTotal = document.getElementById('summaryGrandTotal');
    const submitBookingBtn = document.getElementById('submitBookingBtn');

    // Concession buttons
    const plusButtons = document.querySelectorAll('.qty-plus-btn');
    const minusButtons = document.querySelectorAll('.qty-minus-btn');

    // Format Rupiah helper
    function formatRupiah(number) {
        return 'Rp ' + new Intl.NumberFormat('id-ID').format(number);
    }

    // 1. Seat Selection Handler
    seatCheckboxes.forEach(function(checkbox) {
        checkbox.addEventListener('change', function() {
            const checkedSeats = Array.from(seatCheckboxes).filter(cb => cb.checked);
            
            if (checkedSeats.length > maxSeats) {
                this.checked = false;
                alert('Maksimal pemesanan adalah ' + maxSeats + ' kursi per transaksi.');
                return;
            }

            updateSummary();
        });
    });

    // 2. Concession Quantity Handlers
    plusButtons.forEach(function(btn) {
        btn.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            const input = document.getElementById('concession-input-' + id);
            const display = document.getElementById('qty-display-' + id);
            let val = parseInt(input.value) || 0;
            if (val < 20) {
                val += 1;
                input.value = val;
                display.textContent = val;
                updateSummary();
            }
        });
    });

    minusButtons.forEach(function(btn) {
        btn.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            const input = document.getElementById('concession-input-' + id);
            const display = document.getElementById('qty-display-' + id);
            let val = parseInt(input.value) || 0;
            if (val > 0) {
                val -= 1;
                input.value = val;
                display.textContent = val;
                updateSummary();
            }
        });
    });

    // 3. Central Calculation & UI Update Function
    function updateSummary() {
        // Collect checked seats
        const checkedSeats = Array.from(seatCheckboxes)
            .filter(cb => cb.checked)
            .map(cb => cb.getAttribute('data-seat'));

        const seatCount = checkedSeats.length;
        const ticketTotal = seatCount * ticketPrice;

        // Update Seats Text & Badges
        if (seatCount > 0) {
            selectedSeatsText.textContent = checkedSeats.join(', ');
            selectedSeatsCountBadge.textContent = seatCount + ' Kursi';
            selectedSeatsCountBadge.classList.remove('hidden');
            summarySeatsList.textContent = checkedSeats.join(', ');
            summarySeatQty.textContent = seatCount;
            submitBookingBtn.disabled = false;
        } else {
            selectedSeatsText.textContent = 'Belum ada kursi dipilih';
            selectedSeatsCountBadge.classList.add('hidden');
            summarySeatsList.textContent = 'Belum ada';
            summarySeatQty.textContent = '0';
            submitBookingBtn.disabled = true;
        }

        summaryTicketSubtotal.textContent = formatRupiah(ticketTotal);

        // Collect Snacks
        const concessionInputs = document.querySelectorAll('.concession-quantity');
        let snackTotal = 0;
        let snackItemsHtml = '';
        let hasSnacks = false;

        concessionInputs.forEach(function(input) {
            const qty = parseInt(input.value) || 0;
            if (qty > 0) {
                hasSnacks = true;
                const name = input.getAttribute('data-name');
                const price = parseFloat(input.getAttribute('data-price')) || 0;
                const subtotal = qty * price;
                snackTotal += subtotal;

                snackItemsHtml += `
                    <div class="flex justify-between items-center text-[11px]">
                        <span>${qty}x ${name}</span>
                        <span class="font-medium text-[#350812]">${formatRupiah(subtotal)}</span>
                    </div>
                `;
            }
        });

        if (hasSnacks) {
            summarySnacksList.innerHTML = snackItemsHtml;
        } else {
            summarySnacksList.innerHTML = '<div class="italic text-[#BAA386]">Belum ada pesanan snack</div>';
        }

        summarySnackSubtotal.textContent = formatRupiah(snackTotal);

        // Grand Total
        const grandTotal = ticketTotal + snackTotal;
        summaryGrandTotal.textContent = formatRupiah(grandTotal);
    }

    // 4. Double-Submit Prevention
    const bookingForm = document.getElementById('bookingForm');
    if (bookingForm) {
        bookingForm.addEventListener('submit', function(e) {
            if (submitBookingBtn.disabled) {
                e.preventDefault();
                return;
            }
            // Temporarily visually show progress and prevent rapid double-clicks
            setTimeout(function() {
                submitBookingBtn.disabled = true;
                submitBookingBtn.innerHTML = `
                    <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-[#FAF6F0]" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span>Memproses E-Tiket...</span>
                `;
            }, 50);
        });
    }

    // Run initial update on load to handle old() values if user was redirected back with errors
    updateSummary();
});
</script>
@endpush
