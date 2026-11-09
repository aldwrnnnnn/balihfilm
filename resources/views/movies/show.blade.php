@extends('layouts.app')

@section('title', $movie->title . ' | Jadwal & Pesan Tiket balihfilm')

@section('content')
<!-- Movie Detail Header / Backdrop -->
<div class="bg-[#20040A] text-[#FAF6F0] border-b border-[#4B0C1A] relative overflow-hidden">
    @if($movie->backdrop_url)
        <div class="absolute inset-0 opacity-20 bg-center bg-cover pointer-events-none" style="background-image: url('{{ $movie->backdrop_url }}');"></div>
    @endif
    <div class="absolute inset-0 bg-gradient-to-t from-[#20040A] via-[#20040A]/90 to-transparent"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12 relative z-10">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-8 items-start">
            
            <!-- Movie Poster -->
            <div class="md:col-span-4 lg:col-span-3">
                <div class="rounded-2xl overflow-hidden shadow-2xl border-2 border-[#641225] bg-[#350812] aspect-[2/3] relative max-w-xs mx-auto md:max-w-none">
                    <img src="{{ $movie->poster_url }}" 
                         alt="{{ $movie->title }}" 
                         class="w-full h-full object-cover">
                    <div class="absolute top-3 left-3">
                        <span class="px-2.5 py-1 rounded-md bg-[#20040A]/90 text-[#FAF6F0] border border-[#7E1B31] text-xs font-bold shadow">
                            {{ $movie->rating }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Movie Information -->
            <div class="md:col-span-8 lg:col-span-9 space-y-5">
                
                <div class="flex flex-wrap items-center gap-2.5 sm:gap-3">
                    <span class="px-3 py-1 rounded-full bg-[#4B0C1A] text-[#FAF6F0] text-xs font-semibold tracking-wide border border-[#7E1B31]">
                        {{ $movie->genre }}
                    </span>
                    <span class="text-xs text-[#D3C2AB] flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-[#C49F6A]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        {{ $movie->duration }} Menit
                    </span>
                    @if($movie->status === 'now_playing')
                        <span class="inline-flex items-center gap-1 text-xs text-emerald-400 font-medium">
                            <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                            Sedang Tayang di Bioskop
                        </span>
                    @else
                        <span class="text-xs text-[#C49F6A] font-semibold">
                            Segera Tayang (Mulai {{ $movie->release_date?->format('d M Y') }})
                        </span>
                    @endif
                </div>

                <h1 class="font-serif text-3xl sm:text-4xl lg:text-5xl font-extrabold text-[#FAF6F0] tracking-tight leading-tight">
                    {{ $movie->title }}
                </h1>

                <!-- Credits & Metadata -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs pt-2 pb-2 border-y border-[#350812]">
                    @if($movie->director)
                        <div>
                            <span class="text-[#BAA386] block mb-0.5">Sutradara:</span>
                            <span class="text-[#FAF6F0] font-medium text-sm">{{ $movie->director }}</span>
                        </div>
                    @endif
                    @if($movie->cast)
                        <div>
                            <span class="text-[#BAA386] block mb-0.5">Pemeran:</span>
                            <span class="text-[#FAF6F0] font-medium text-sm">{{ $movie->cast }}</span>
                        </div>
                    @endif
                </div>

                <!-- Synopsis -->
                <div>
                    <h3 class="font-serif text-base sm:text-lg font-bold text-[#FAF6F0] mb-2">Sinopsis</h3>
                    <p class="text-xs sm:text-sm text-[#D3C2AB] leading-relaxed max-w-3xl font-normal">
                        {{ $movie->synopsis }}
                    </p>
                </div>

                <!-- Base Price Note -->
                <div class="inline-flex flex-wrap items-center gap-2 sm:gap-3 p-3 rounded-xl bg-[#350812]/80 border border-[#641225] text-xs">
                    <span class="text-[#BAA386]">Harga Tiket:</span>
                    <span class="text-[#C49F6A] font-bold text-sm">Mulai Rp {{ number_format($movie->base_price, 0, ',', '.') }}</span>
                    <span class="text-[#D3C2AB] hidden sm:inline">&bull;</span>
                    <span class="text-[#D3C2AB]">Tersedia Studio Dolby Atmos & VIP Lounge</span>
                </div>

            </div>

        </div>

    </div>
</div>

<!-- Showtimes & Booking Section -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    @if($movie->status === 'now_playing')
        <div class="mb-10">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
                <div>
                    <h2 class="font-serif text-2xl sm:text-3xl font-bold text-[#350812]">
                        Jadwal Tayang & Pemilihan Tiket
                    </h2>
                    <p class="text-xs sm:text-sm text-[#4B0C1A]/80 mt-1">
                        Pilih tanggal dan jam tayang yang sesuai untuk memilih posisi kursi Anda.
                    </p>
                </div>
            </div>

            @if($groupedShowtimes->isEmpty())
                <div class="p-8 rounded-2xl bg-[#FFFDF9] border border-[#E5D9C7] text-center max-w-lg mx-auto">
                    <p class="text-sm text-[#350812] mb-3">Belum ada jadwal tayang aktif untuk film ini hari ini.</p>
                    <a href="{{ route('movies.index') }}" class="text-xs font-bold text-[#4B0C1A] hover:underline">
                        Lihat jadwal film lainnya
                    </a>
                </div>
            @else
                <!-- Interactive Date Selector Tabs -->
                <div class="flex items-center gap-2 overflow-x-auto pb-3 mb-6" id="dateTabs">
                    @foreach ($groupedShowtimes as $dateLabel => $showtimesList)
                        <button type="button" 
                                class="date-tab-btn px-4 py-2.5 rounded-xl border text-xs sm:text-sm font-semibold whitespace-nowrap transition-all shadow-sm active:scale-95 flex items-center gap-2 {{ $loop->first ? 'bg-[#4B0C1A] text-[#FAF6F0] border-[#4B0C1A]' : 'bg-[#FFFDF9] text-[#350812] border-[#E5D9C7] hover:border-[#4B0C1A]' }}"
                                data-target="date-content-{{ $loop->index }}">
                            <svg class="w-4 h-4 text-[#C49F6A]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            <span>{{ $dateLabel }}</span>
                        </button>
                    @endforeach
                </div>

                <!-- Showtimes Content Panels for each date -->
                <div class="space-y-6">
                    @foreach ($groupedShowtimes as $dateLabel => $showtimesList)
                        <div id="date-content-{{ $loop->index }}" class="date-content-panel {{ $loop->first ? '' : 'hidden' }}">
                            <div class="bg-[#FFFDF9] rounded-2xl border border-[#E5D9C7] p-6 shadow-sm">
                                
                                <!-- Date Sub-Header -->
                                <div class="flex items-center justify-between pb-4 mb-5 border-b border-[#F3EBE0]">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 rounded-lg bg-[#4B0C1A] text-[#FAF6F0] flex items-center justify-center font-bold text-xs">
                                            <svg class="w-4 h-4 text-[#C49F6A]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                        </div>
                                        <div>
                                            <h3 class="font-serif text-lg font-bold text-[#350812]">{{ $dateLabel }}</h3>
                                            <span class="text-xs text-[#BAA386]">Lokasi: balihfilm Central Studio</span>
                                        </div>
                                    </div>
                                    <span class="text-xs text-[#4B0C1A] font-semibold hidden sm:inline">
                                        {{ $showtimesList->count() }} Jadwal Tayang Tersedia
                                    </span>
                                </div>

                                <!-- Group by Studio -->
                                @php
                                    $studioGroups = $showtimesList->groupBy('studio.name');
                                @endphp

                                <div class="space-y-4">
                                    @foreach ($studioGroups as $studioName => $items)
                                        @php $sampleStudio = $items->first()->studio; @endphp
                                        <div class="p-4 rounded-xl bg-[#FAF6F0] border border-[#E5D9C7]">
                                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 mb-3">
                                                <div class="flex flex-wrap items-center gap-2">
                                                    <span class="font-serif font-bold text-[#350812] text-sm sm:text-base">
                                                        {{ $studioName }}
                                                    </span>
                                                    @if($sampleStudio->type === 'atmos')
                                                        <span class="px-2 py-0.5 rounded bg-[#4B0C1A] text-[#FAF6F0] text-[10px] font-bold">Dolby Atmos 7.1</span>
                                                    @elseif($sampleStudio->type === 'vip')
                                                        <span class="px-2 py-0.5 rounded bg-[#C49F6A] text-[#20040A] text-[10px] font-bold">VIP Sofa & Blanket</span>
                                                    @else
                                                        <span class="px-2 py-0.5 rounded bg-[#E5D9C7] text-[#350812] text-[10px] font-semibold">Reguler Classic</span>
                                                    @endif
                                                </div>
                                                <span class="text-xs font-semibold text-[#4B0C1A]">
                                                    Rp {{ number_format($items->first()->price, 0, ',', '.') }} / tiket
                                                </span>
                                            </div>

                                            <!-- Showtime Buttons -->
                                            <div class="flex flex-wrap gap-3">
                                                @foreach ($items as $st)
                                                    <a href="{{ route('bookings.create', $st->id) }}" 
                                                       class="group/st px-4 py-2.5 rounded-xl bg-[#FFFDF9] hover:bg-[#4B0C1A] border border-[#D3C2AB] hover:border-[#4B0C1A] transition-all flex items-center gap-2.5 shadow-sm active:scale-95">
                                                        <span class="font-bold text-sm text-[#350812] group-hover/st:text-[#FAF6F0] transition-colors">
                                                            {{ \Carbon\Carbon::parse($st->start_time)->format('H:i') }} WIB
                                                        </span>
                                                        <span class="text-[11px] text-[#7E1B31] group-hover/st:text-[#C49F6A] font-semibold transition-colors">
                                                            Pesan
                                                        </span>
                                                    </a>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    @else
        <!-- Upcoming Notice -->
        <div class="mb-10 p-8 rounded-3xl bg-[#FFFDF9] border border-[#E5D9C7] text-center max-w-2xl mx-auto shadow-sm">
            <div class="w-16 h-16 rounded-full bg-[#FAF6F0] border border-[#E5D9C7] text-[#C49F6A] flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <h2 class="font-serif text-2xl font-bold text-[#350812] mb-2">Film Ini Segera Tayang</h2>
            <p class="text-sm text-[#4B0C1A]/80 leading-relaxed mb-6">
                Film <strong>{{ $movie->title }}</strong> dijadwalkan tayang perdana di bioskop balihfilm mulai 
                <strong>{{ $movie->release_date?->translatedFormat('d F Y') ?? 'segera' }}</strong>. 
                Pemesanan tiket online akan dibuka beberapa hari sebelum tanggal rilis resmi.
            </p>
            <div class="flex justify-center gap-3">
                <a href="{{ route('movies.index', ['status' => 'now_playing']) }}" 
                   class="px-6 py-3 rounded-xl bg-[#4B0C1A] text-[#FAF6F0] font-semibold text-xs hover:bg-[#641225] transition-colors shadow">
                    Lihat Film yang Sedang Tayang Hari Ini
                </a>
            </div>
        </div>
    @endif

    <!-- Recommended Other Films -->
    @if($recommended->isNotEmpty())
        <div class="pt-8 border-t border-[#E5D9C7]">
            <h3 class="font-serif text-xl sm:text-2xl font-bold text-[#350812] mb-6">
                Rekomendasi Film Lainnya di balihfilm
            </h3>
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 sm:gap-6">
                @foreach ($recommended as $rec)
                    <a href="{{ route('movies.show', $rec->slug) }}" class="group bg-[#FFFDF9] rounded-xl border border-[#E5D9C7] overflow-hidden hover:border-[#4B0C1A] transition-all shadow-sm">
                        <div class="aspect-[2/3] overflow-hidden bg-[#20040A]">
                            <img src="{{ $rec->poster_url }}" alt="{{ $rec->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-200">
                        </div>
                        <div class="p-3">
                            <span class="text-[10px] text-[#7E1B31] font-semibold uppercase">{{ $rec->genre }}</span>
                            <h4 class="font-serif text-xs sm:text-sm font-bold text-[#350812] truncate mt-0.5 group-hover:text-[#641225]">
                                {{ $rec->title }}
                            </h4>
                            <span class="text-[11px] text-[#BAA386] block mt-1">Rp {{ number_format($rec->base_price, 0, ',', '.') }}</span>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    @endif

</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const tabs = document.querySelectorAll('.date-tab-btn');
    const panels = document.querySelectorAll('.date-content-panel');

    tabs.forEach(function(tab) {
        tab.addEventListener('click', function() {
            const targetId = this.getAttribute('data-target');

            // Toggle Tab Styles
            tabs.forEach(t => {
                t.classList.remove('bg-[#4B0C1A]', 'text-[#FAF6F0]', 'border-[#4B0C1A]');
                t.classList.add('bg-[#FFFDF9]', 'text-[#350812]', 'border-[#E5D9C7]');
            });
            this.classList.remove('bg-[#FFFDF9]', 'text-[#350812]', 'border-[#E5D9C7]');
            this.classList.add('bg-[#4B0C1A]', 'text-[#FAF6F0]', 'border-[#4B0C1A]');

            // Show Target Panel
            panels.forEach(panel => {
                if (panel.id === targetId) {
                    panel.classList.remove('hidden');
                } else {
                    panel.classList.add('hidden');
                }
            });
        });
    });
});
</script>
@endpush
