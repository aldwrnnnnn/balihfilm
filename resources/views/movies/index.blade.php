@extends('layouts.app')

@section('title', 'Daftar Film Sedang Tayang & Akan Datang | balihfilm')

@section('content')
<!-- Hero Cinema Spotlight Section -->
<section class="bg-gradient-to-b from-[#20040A] via-[#350812] to-[#4B0C1A] text-[#FAF6F0] py-10 sm:py-14 border-b border-[#641225] relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
            
            <!-- Left Headline -->
            <div class="lg:col-span-7 space-y-4">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-[#FAF6F0]/10 border border-[#C49F6A]/30 text-xs font-semibold tracking-wider uppercase text-[#F3EBE0]">
                    <span class="w-1.5 h-1.5 rounded-full bg-[#C49F6A]"></span>
                    Bioskop Pilihan Keluarga & Sinema Mania
                </div>
                <h1 class="font-serif text-3xl sm:text-4xl lg:text-5xl font-extrabold tracking-tight text-[#FAF6F0] leading-tight">
                    Pengalaman Nonton Terbaik di <span class="text-[#C49F6A]">balihfilm</span>
                </h1>
                <p class="text-[#D3C2AB] text-sm sm:text-base max-w-xl font-normal leading-relaxed">
                    Pesan tiket bioskop secara instan, tentukan posisi tempat duduk favoritmu di layar lebar, dan pesan paket popcorn lezat tanpa perlu antre di kasir.
                </p>

                <!-- Search Form with Filter Preservation -->
                <form action="{{ route('movies.index') }}" method="GET" class="pt-2 flex flex-col sm:flex-row gap-2 max-w-lg">
                    @if(request('status'))
                        <input type="hidden" name="status" value="{{ request('status') }}">
                    @endif
                    @if(request('genre'))
                        <input type="hidden" name="genre" value="{{ request('genre') }}">
                    @endif

                    <div class="relative flex-grow">
                        <label for="searchInput" class="sr-only">Cari film</label>
                        <input type="text" 
                               id="searchInput"
                               name="q" 
                               value="{{ request('q') }}"
                               placeholder="Cari judul film, sutradara, atau aktor..."
                               class="w-full pl-10 pr-4 py-3 rounded-xl bg-[#20040A]/80 border border-[#7E1B31] text-sm text-[#FAF6F0] placeholder-[#BAA386] focus:outline-none focus:border-[#C49F6A] focus:ring-1 focus:ring-[#C49F6A] transition-all">
                        <svg class="w-4 h-4 text-[#BAA386] absolute left-3.5 top-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                    <button type="submit" class="px-6 py-3 rounded-xl bg-[#FAF6F0] text-[#350812] hover:bg-[#F3EBE0] font-semibold text-sm transition-all shadow active:scale-95 shrink-0 flex items-center justify-center gap-1.5">
                        <svg class="w-4 h-4 text-[#4B0C1A]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        <span>Cari Film</span>
                    </button>
                </form>

                <!-- Quick info badges -->
                <div class="flex flex-wrap gap-4 pt-2 text-xs text-[#D3C2AB]">
                    <div class="flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-[#C49F6A]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span>Pilih Kursi Interaktif</span>
                    </div>
                    <div class="flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-[#C49F6A]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span>Pesan Makanan & Minuman</span>
                    </div>
                    <div class="flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-[#C49F6A]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span>Barcode E-Tiket Instan</span>
                    </div>
                </div>
            </div>

            <!-- Right Featured Highlight Card -->
            @if($nowPlaying->isNotEmpty())
                @php $spotlight = $nowPlaying->first(); @endphp
                <div class="lg:col-span-5">
                    <div class="bg-[#20040A] rounded-2xl border border-[#641225] p-4 sm:p-5 shadow-2xl relative">
                        <div class="flex items-center justify-between mb-3 text-xs">
                            <span class="px-2.5 py-0.5 rounded-full bg-[#7E1B31] text-[#FAF6F0] font-semibold uppercase tracking-wider">
                                Film Unggulan Hari Ini
                            </span>
                            <span class="text-[#D3C2AB]">{{ $spotlight->duration }} Menit &bull; Rating {{ $spotlight->rating }}</span>
                        </div>
                        
                        <div class="relative rounded-xl overflow-hidden aspect-[16/9] mb-4">
                            <img src="{{ $spotlight->backdrop_url ?? $spotlight->poster_url }}" 
                                 alt="{{ $spotlight->title }}" 
                                 class="w-full h-full object-cover">
                            <div class="absolute inset-0 bg-gradient-to-t from-[#20040A] via-transparent to-transparent"></div>
                            <div class="absolute bottom-3 left-3 right-3 flex items-end justify-between">
                                <span class="text-xs px-2 py-1 rounded bg-[#4B0C1A]/90 text-[#FAF6F0] font-medium backdrop-blur-sm">
                                    {{ $spotlight->genre }}
                                </span>
                            </div>
                        </div>

                        <h3 class="font-serif text-xl font-bold text-[#FAF6F0] mb-1">
                            {{ $spotlight->title }}
                        </h3>
                        <p class="text-xs text-[#D3C2AB] line-clamp-2 mb-4 leading-relaxed">
                            {{ $spotlight->synopsis }}
                        </p>

                        <div class="flex items-center justify-between pt-3 border-t border-[#350812]">
                            <div>
                                <span class="text-[11px] text-[#BAA386] block">Mulai Dari</span>
                                <span class="text-base font-bold text-[#C49F6A]">Rp {{ number_format($spotlight->base_price, 0, ',', '.') }}</span>
                            </div>
                            <a href="{{ route('movies.show', $spotlight->slug) }}" 
                               class="px-5 py-2.5 rounded-xl bg-[#4B0C1A] hover:bg-[#641225] border border-[#7E1B31] text-[#FAF6F0] font-semibold text-xs transition-all shadow flex items-center justify-center active:scale-95">
                                <span>Pesan Tiket Sekarang</span>
                            </a>
                        </div>
                    </div>
                </div>
            @endif

        </div>
    </div>
</section>

<!-- Filter Navigation Bar -->
<section class="sticky top-20 z-30 bg-[#FAF6F0] border-b border-[#E5D9C7] py-3.5 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-3">
            
            <!-- Status Tabs -->
            <div class="flex items-center gap-2 overflow-x-auto pb-1 md:pb-0">
                <a href="{{ route('movies.index', array_merge(request()->query(), ['status' => 'all'])) }}" 
                   class="px-4 py-2 rounded-xl text-xs sm:text-sm font-semibold whitespace-nowrap transition-colors {{ request('status', 'all') === 'all' ? 'bg-[#4B0C1A] text-[#FAF6F0]' : 'bg-[#F3EBE0] text-[#4B0C1A] hover:bg-[#E5D9C7]' }}">
                    Semua Film ({{ $movies->count() }})
                </a>
                <a href="{{ route('movies.index', array_merge(request()->query(), ['status' => 'now_playing'])) }}" 
                   class="px-4 py-2 rounded-xl text-xs sm:text-sm font-semibold whitespace-nowrap transition-colors {{ request('status') === 'now_playing' ? 'bg-[#4B0C1A] text-[#FAF6F0]' : 'bg-[#F3EBE0] text-[#4B0C1A] hover:bg-[#E5D9C7]' }}">
                    Sedang Tayang
                </a>
                <a href="{{ route('movies.index', array_merge(request()->query(), ['status' => 'upcoming'])) }}" 
                   class="px-4 py-2 rounded-xl text-xs sm:text-sm font-semibold whitespace-nowrap transition-colors {{ request('status') === 'upcoming' ? 'bg-[#4B0C1A] text-[#FAF6F0]' : 'bg-[#F3EBE0] text-[#4B0C1A] hover:bg-[#E5D9C7]' }}">
                    Akan Datang
                </a>
            </div>

            <!-- Genre Quick Filter -->
            <div class="flex items-center gap-1.5 overflow-x-auto text-xs pb-1 md:pb-0">
                <span class="text-[#BAA386] font-medium hidden lg:inline mr-1">Genre:</span>
                @foreach (['Aksi', 'Sci-Fi', 'Komedi', 'Horor', 'Drama', 'Animasi'] as $g)
                    <a href="{{ route('movies.index', array_merge(request()->query(), ['genre' => request('genre') === $g ? null : $g])) }}" 
                       class="px-3 py-1.5 rounded-lg border text-xs font-medium whitespace-nowrap transition-colors {{ request('genre') === $g ? 'bg-[#350812] text-[#FAF6F0] border-[#350812]' : 'bg-[#FFFDF9] text-[#4B0C1A] border-[#E5D9C7] hover:border-[#4B0C1A]' }}">
                        {{ $g }}
                    </a>
                @endforeach
                @if(request('genre') || request('q'))
                    <a href="{{ route('movies.index') }}" class="text-[#7E1B31] hover:underline font-semibold text-xs ml-2 whitespace-nowrap">
                        Reset Filter &times;
                    </a>
                @endif
            </div>

        </div>
    </div>
</section>

<!-- Movie Cards Grid Section -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    @if($searchQuery)
        <div class="mb-6 p-4 rounded-xl bg-[#F3EBE0] border border-[#E5D9C7] flex justify-between items-center text-sm">
            <span>Menampilkan hasil pencarian: <strong>"{{ $searchQuery }}"</strong></span>
            <a href="{{ route('movies.index') }}" class="text-[#4B0C1A] font-semibold hover:underline">Hapus Pencarian &times;</a>
        </div>
    @endif

    @if($movies->isEmpty())
        <div class="text-center py-16 bg-[#FFFDF9] rounded-2xl border border-[#E5D9C7] p-8 max-w-lg mx-auto">
            <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-[#F3EBE0] flex items-center justify-center text-[#4B0C1A]">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4v16M17 4v16M3 8h4m10 0h4M3 12h18M3 16h4m10 0h4M4 20h16a1 1 0 001-1V5a1 1 0 00-1-1H4a1 1 0 00-1 1v14a1 1 0 001 1z"/>
                </svg>
            </div>
            <h3 class="font-serif text-xl font-bold text-[#350812] mb-2">Film Tidak Ditemukan</h3>
            <p class="text-sm text-[#4B0C1A]/80 mb-6">
                Tidak ada film yang cocok dengan filter atau kata kunci Anda saat ini.
            </p>
            <a href="{{ route('movies.index') }}" class="inline-block px-5 py-2.5 rounded-xl bg-[#4B0C1A] text-[#FAF6F0] font-semibold text-sm hover:bg-[#641225] transition-colors">
                Lihat Semua Film
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 sm:gap-8">
            @foreach ($movies as $movie)
                <div class="group bg-[#FFFDF9] rounded-2xl border border-[#E5D9C7] hover:border-[#4B0C1A]/50 overflow-hidden shadow-sm hover:shadow-md transition-all duration-200 flex flex-col">
                    
                    <!-- Poster Wrapper -->
                    <div class="relative aspect-[2/3] overflow-hidden bg-[#20040A]">
                        <img src="{{ $movie->poster_url }}" 
                             alt="{{ $movie->title }}" 
                             loading="lazy"
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                        
                        <!-- Top Badges -->
                        <div class="absolute top-3 left-3 right-3 flex justify-between items-start">
                            <span class="px-2 py-0.5 rounded-md bg-[#20040A]/85 backdrop-blur-sm text-[#FAF6F0] border border-[#7E1B31] text-[11px] font-bold">
                                {{ $movie->rating }}
                            </span>

                            @if($movie->status === 'now_playing')
                                <span class="px-2.5 py-0.5 rounded-md bg-[#4B0C1A] text-[#FAF6F0] text-[11px] font-semibold flex items-center gap-1 shadow">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                                    Tayang
                                </span>
                            @else
                                <span class="px-2.5 py-0.5 rounded-md bg-[#C49F6A] text-[#20040A] text-[11px] font-bold shadow">
                                    Segera
                                </span>
                            @endif
                        </div>

                        <!-- Duration overlay -->
                        <div class="absolute bottom-3 left-3 bg-[#20040A]/85 backdrop-blur-sm px-2 py-0.5 rounded text-[11px] text-[#FAF6F0] font-medium">
                            {{ $movie->duration }} Menit
                        </div>
                    </div>

                    <!-- Card Body -->
                    <div class="p-5 flex flex-col flex-grow justify-between">
                        <div>
                            <div class="text-[11px] font-semibold text-[#7E1B31] uppercase tracking-wider mb-1">
                                {{ $movie->genre }}
                            </div>
                            <h2 class="font-serif text-lg font-bold text-[#350812] group-hover:text-[#641225] transition-colors leading-snug line-clamp-1 mb-3">
                                <a href="{{ route('movies.show', $movie->slug) }}">
                                    {{ $movie->title }}
                                </a>
                            </h2>
                        </div>

                        <!-- Card Footer / CTA -->
                        <div class="pt-4 border-t border-[#F3EBE0]">
                            <div class="flex items-center justify-between mb-3 text-xs">
                                <span class="text-[#BAA386]">Tiket Mulai:</span>
                                <span class="font-bold text-[#4B0C1A] text-sm">
                                    Rp {{ number_format($movie->base_price, 0, ',', '.') }}
                                </span>
                            </div>

                            @if($movie->status === 'now_playing')
                                <a href="{{ route('movies.show', $movie->slug) }}" 
                                   class="w-full py-2.5 px-4 rounded-xl bg-[#4B0C1A] hover:bg-[#641225] text-[#FAF6F0] font-semibold text-xs transition-colors flex items-center justify-center shadow-sm active:scale-95">
                                    <span>Pilih Jadwal & Kursi</span>
                                </a>
                            @else
                                <a href="{{ route('movies.show', $movie->slug) }}" 
                                   class="w-full py-2.5 px-4 rounded-xl bg-[#F3EBE0] hover:bg-[#E5D9C7] text-[#4B0C1A] font-semibold text-xs transition-colors flex items-center justify-center border border-[#E5D9C7] active:scale-95">
                                    <span>Lihat Sinopsis Film</span>
                                </a>
                            @endif
                        </div>

                    </div>

                </div>
            @endforeach
        </div>
    @endif

</section>

<!-- Cinema Steps & Features Guide -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="rounded-3xl bg-[#FFFDF9] border border-[#E5D9C7] p-6 sm:p-10 shadow-sm">
        <div class="text-center max-w-xl mx-auto mb-8 sm:mb-10">
            <h2 class="font-serif text-2xl sm:text-3xl font-bold text-[#350812] mb-2">
                Pesan Tiket Bioskop Tanpa Ribet
            </h2>
            <p class="text-sm text-[#4B0C1A]/80">
                Kemudahan menikmati film favorit di balihfilm dalam tiga langkah praktis.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 sm:gap-8">
            <!-- Step 1 -->
            <div class="p-6 rounded-2xl bg-[#FAF6F0] border border-[#E5D9C7] text-center space-y-3">
                <div class="w-12 h-12 rounded-xl bg-[#4B0C1A] text-[#FAF6F0] flex items-center justify-center mx-auto font-serif text-xl font-bold shadow-sm">
                    1
                </div>
                <h3 class="font-serif text-lg font-bold text-[#350812]">Pilih Film & Jadwal</h3>
                <p class="text-xs text-[#2B1D20]/80 leading-relaxed">
                    Lihat daftar film yang tayang hari ini atau pekan ini, tentukan jam tayang dan studio yang Anda kehendaki.
                </p>
            </div>

            <!-- Step 2 -->
            <div class="p-6 rounded-2xl bg-[#FAF6F0] border border-[#E5D9C7] text-center space-y-3">
                <div class="w-12 h-12 rounded-xl bg-[#4B0C1A] text-[#FAF6F0] flex items-center justify-center mx-auto font-serif text-xl font-bold shadow-sm">
                    2
                </div>
                <h3 class="font-serif text-lg font-bold text-[#350812]">Tentukan Kursi & Snack</h3>
                <p class="text-xs text-[#2B1D20]/80 leading-relaxed">
                    Pilih posisi tempat duduk langsung pada denah interaktif studio dan tambahkan popcorn atau minuman segar favorit Anda.
                </p>
            </div>

            <!-- Step 3 -->
            <div class="p-6 rounded-2xl bg-[#FAF6F0] border border-[#E5D9C7] text-center space-y-3">
                <div class="w-12 h-12 rounded-xl bg-[#4B0C1A] text-[#FAF6F0] flex items-center justify-center mx-auto font-serif text-xl font-bold shadow-sm">
                    3
                </div>
                <h3 class="font-serif text-lg font-bold text-[#350812]">Download Barcode Tiket</h3>
                <p class="text-xs text-[#2B1D20]/80 leading-relaxed">
                    Bayar aman dengan QRIS atau Virtual Account, download barcode tiket Anda dan scan di pintu masuk bioskop tanpa perlu antre tiket fisik.
                </p>
            </div>
        </div>
    </div>
</section>
@endsection
