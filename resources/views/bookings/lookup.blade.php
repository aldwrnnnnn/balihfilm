@extends('layouts.app')

@section('title', 'Cek & Download Barcode Tiket | balihfilm')

@section('content')
<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-16">
    
    <div class="text-center mb-8">
        <div class="w-14 h-14 rounded-2xl bg-[#4B0C1A] text-[#FAF6F0] flex items-center justify-center mx-auto mb-4 border border-[#7E1B31] shadow-sm">
            <svg class="w-7 h-7 text-[#C49F6A]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
            </svg>
        </div>
        <h1 class="font-serif text-2xl sm:text-3xl font-bold text-[#350812]">
            Cek & Download Barcode Tiket
        </h1>
        <p class="text-xs sm:text-sm text-[#4B0C1A]/80 mt-1 max-w-md mx-auto">
            Masukkan Kode Booking, nomor WhatsApp, atau email Anda yang digunakan saat memesan tiket bioskop balihfilm.
        </p>
    </div>

    <!-- Search Box Card -->
    <div class="bg-[#FFFDF9] rounded-3xl border border-[#E5D9C7] p-6 sm:p-8 shadow-sm">
        
        <form action="{{ route('bookings.lookup') }}" method="GET" class="space-y-4">
            <div>
                <label for="code" class="block text-xs font-semibold text-[#350812] mb-1.5">
                    Kode Booking / WhatsApp / Email
                </label>
                <div class="relative">
                    <input type="text" 
                           name="code" 
                           id="code" 
                           value="{{ request('code') }}"
                           required
                           placeholder="Contoh: BF-202610-7412 atau 081234567890"
                           class="w-full pl-10 pr-4 py-3.5 rounded-xl bg-[#FAF6F0] border border-[#D3C2AB] text-sm text-[#2B1D20] placeholder-[#BAA386] focus:outline-none focus:border-[#4B0C1A] focus:ring-1 focus:ring-[#4B0C1A] transition-colors font-mono">
                    <svg class="w-5 h-5 text-[#BAA386] absolute left-3 top-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
            </div>

            <button type="submit" 
                    class="w-full py-3.5 px-6 rounded-xl bg-[#4B0C1A] hover:bg-[#641225] text-[#FAF6F0] font-bold text-sm transition-all shadow flex items-center justify-center gap-2 active:scale-95">
                <span>Cari Tiket Saya</span>
            </button>
        </form>

        @if(isset($matchingBookings) && $matchingBookings->count() > 1)
            <div class="mt-6 space-y-3">
                <div class="p-3 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-900 text-xs font-semibold">
                    Ditemukan {{ $matchingBookings->count() }} tiket untuk "{{ $searchedCode }}". Silakan pilih tiket yang ingin dilihat:
                </div>
                <div class="space-y-2">
                    @foreach ($matchingBookings as $b)
                        <a href="{{ route('bookings.show', $b->booking_code) }}" 
                           class="p-4 rounded-2xl bg-[#FAF6F0] border border-[#E5D9C7] hover:border-[#4B0C1A] hover:bg-[#F3EBE0] transition-all flex items-center justify-between gap-3 group block">
                            <div>
                                <div class="font-bold text-sm text-[#350812] group-hover:text-[#4B0C1A]">
                                    {{ $b->showtime?->movie?->title ?? 'Film balihfilm' }}
                                </div>
                                <div class="text-xs text-[#2B1D20]/75 mt-0.5">
                                    {{ $b->showtime?->studio?->name ?? 'Studio' }} &bull; 
                                    {{ \Carbon\Carbon::parse($b->showtime?->show_date)->translatedFormat('d M Y') }} - 
                                    {{ \Carbon\Carbon::parse($b->showtime?->start_time)->format('H:i') }} WIB
                                </div>
                                <div class="text-[11px] font-mono text-[#7E1B31] mt-1">
                                    Kursi: {{ implode(', ', $b->seats) }} &bull; Kode: {{ $b->booking_code }}
                                </div>
                            </div>
                            <span class="px-3 py-1.5 rounded-lg bg-[#4B0C1A] text-[#FAF6F0] text-xs font-semibold group-hover:bg-[#641225] shrink-0">
                                Buka Tiket &rarr;
                            </span>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif

        @if($notFound)
            <div class="mt-6 p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-900 text-xs">
                <div class="font-bold mb-1">Tiket Tidak Ditemukan</div>
                <p>
                    Tidak ditemukan pemesanan tiket dengan kata kunci <strong>"{{ $searchedCode }}"</strong>. Pastikan kode booking atau nomor handphone Anda telah sesuai.
                </p>
            </div>
        @endif

        <div class="mt-6 pt-6 border-t border-[#F3EBE0] text-center space-y-2">
            <span class="text-xs text-[#BAA386] block">Butuh bantuan mencari tiket Anda?</span>
            <div class="text-xs text-[#4B0C1A] font-semibold">
                Hubungi WhatsApp Bantuan balihfilm: <a href="https://wa.me/6281529434240" target="_blank" class="underline">0815-2943-4240</a>
            </div>
        </div>

    </div>

</div>
@endsection
