<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Pesan Tiket Bioskop Online') | balihfilm</title>
    <meta name="description" content="Pemesanan tiket bioskop online balihfilm mudah, cepat, pilih kursi favorit, pesan makanan dan download barcode e-tiket langsung.">
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

    <!-- Open Graph / Social Sharing -->
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="balihfilm Cinema">
    <meta property="og:title" content="@yield('title', 'Pesan Tiket Bioskop Online | balihfilm')">
    <meta property="og:description" content="Pesan tiket bioskop online balihfilm tanpa antre. Pilih kursi favorit, pesan paket popcorn, download barcode e-tiket instan.">

    <!-- Fonts: Cinzel & Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@600;700;800;900&family=Plus+Jakarta+Sans:wght@400;500;600;700&family=Space+Mono:wght@700&display=swap" rel="stylesheet">

    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')
</head>
<body class="min-h-screen flex flex-col bg-[#FAF6F0] text-[#2B1D20] font-sans antialiased selection:bg-[#4B0C1A] selection:text-[#FAF6F0]">
    
    <!-- Main Navigation Header -->
    <header class="no-print sticky top-0 z-40 bg-[#350812] border-b border-[#4B0C1A] shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                <!-- Cinema Brand Logo -->
                <a href="{{ route('movies.index') }}" class="flex items-center gap-3 group">
                    <div class="w-12 h-12 rounded-lg bg-[#4B0C1A] border border-[#7E1B31] flex items-center justify-center text-[#FAF6F0] shadow-sm group-hover:border-[#C49F6A] transition-colors">
                        <svg class="w-6 h-6 text-[#C49F6A]" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M4 4h16a2 2 0 012 2v12a2 2 0 01-2 2H4a2 2 0 01-2-2V6a2 2 0 012-2zm0 2v3h2V6H4zm4 0v3h8V6H8zm10 0v3h2V6h-2zM4 11v3h2v-3H4zm16 0v3h2v-3h-2zM4 16v2h2v-2H4zm16 0v2h2v-2h-2zM8 11h8v7H8v-7z"/>
                        </svg>
                    </div>
                    <div>
                        <div class="font-serif text-2xl font-bold tracking-wider text-[#FAF6F0] leading-none group-hover:text-[#F3EBE0] transition-colors">
                            balih<span class="text-[#C49F6A]">film</span>
                        </div>
                        <div class="text-[10px] tracking-widest uppercase text-[#D3C2AB] mt-1 font-medium">
                            Premiere Cinema &bull; Dolby Atmos
                        </div>
                    </div>
                </a>

                <!-- Desktop Navigation Links -->
                <nav class="hidden md:flex items-center gap-1 lg:gap-2">
                    <a href="{{ route('movies.index', ['status' => 'all']) }}" 
                       class="px-4 py-2 rounded-md text-sm font-medium transition-colors {{ request('status') === 'all' || (!request()->has('status') && request()->routeIs('movies.index')) ? 'bg-[#4B0C1A] text-[#FAF6F0]' : 'text-[#FAF6F0]/90 hover:text-white hover:bg-[#4B0C1A]/50' }}">
                        Semua Film
                    </a>
                    <a href="{{ route('movies.index', ['status' => 'now_playing']) }}" 
                       class="px-4 py-2 rounded-md text-sm font-medium transition-colors {{ request('status') === 'now_playing' ? 'bg-[#4B0C1A] text-[#FAF6F0]' : 'text-[#FAF6F0]/90 hover:text-white hover:bg-[#4B0C1A]/50' }}">
                        Sedang Tayang
                    </a>
                    <a href="{{ route('movies.index', ['status' => 'upcoming']) }}" 
                       class="px-4 py-2 rounded-md text-sm font-medium transition-colors {{ request('status') === 'upcoming' ? 'bg-[#4B0C1A] text-[#FAF6F0]' : 'text-[#FAF6F0]/90 hover:text-white hover:bg-[#4B0C1A]/50' }}">
                        Akan Datang
                    </a>
                </nav>

                <!-- Action Button & Mobile Hamburger -->
                <div class="flex items-center gap-2 sm:gap-3">
                    <a href="{{ route('bookings.lookup') }}" 
                       class="inline-flex items-center gap-2 px-3.5 py-2.5 rounded-lg bg-[#FAF6F0] text-[#350812] hover:bg-[#F3EBE0] text-xs sm:text-sm font-semibold transition-all shadow-sm active:scale-95">
                        <svg class="w-4 h-4 text-[#4B0C1A]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
                        </svg>
                        <span class="hidden sm:inline">Cek Barcode Tiket</span>
                        <span class="sm:hidden">Cek Tiket</span>
                    </a>

                    <!-- Mobile Hamburger Button with Label -->
                    <button type="button" 
                            id="mobileMenuToggle"
                            aria-expanded="false"
                            aria-label="Buka menu navigasi"
                            class="md:hidden flex items-center gap-1.5 px-3 py-2 rounded-lg bg-[#4B0C1A] text-[#FAF6F0] border border-[#7E1B31] text-xs font-semibold hover:bg-[#641225] transition-colors focus:outline-none focus:ring-2 focus:ring-[#C49F6A]">
                        <span>Menu</span>
                        <svg id="hamburgerIcon" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                        <svg id="closeIcon" class="w-4 h-4 hidden" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Navigation Menu Drawer -->
        <div id="mobileMenu" class="hidden md:hidden bg-[#20040A] border-t border-[#4B0C1A] px-4 py-4 space-y-2">
            <a href="{{ route('movies.index', ['status' => 'all']) }}" 
               class="block px-3 py-2.5 rounded-lg text-sm font-semibold transition-colors {{ request('status') === 'all' || (!request()->has('status') && request()->routeIs('movies.index')) ? 'bg-[#4B0C1A] text-[#FAF6F0]' : 'text-[#FAF6F0]/90 hover:bg-[#350812]' }}">
                🎬 Semua Film
            </a>
            <a href="{{ route('movies.index', ['status' => 'now_playing']) }}" 
               class="block px-3 py-2.5 rounded-lg text-sm font-semibold transition-colors {{ request('status') === 'now_playing' ? 'bg-[#4B0C1A] text-[#FAF6F0]' : 'text-[#FAF6F0]/90 hover:bg-[#350812]' }}">
                🍿 Sedang Tayang (Now Playing)
            </a>
            <a href="{{ route('movies.index', ['status' => 'upcoming']) }}" 
               class="block px-3 py-2.5 rounded-lg text-sm font-semibold transition-colors {{ request('status') === 'upcoming' ? 'bg-[#4B0C1A] text-[#FAF6F0]' : 'text-[#FAF6F0]/90 hover:bg-[#350812]' }}">
                ✨ Akan Datang (Coming Soon)
            </a>
            <a href="{{ route('bookings.lookup') }}" 
               class="block px-3 py-2.5 rounded-lg text-sm font-semibold text-[#C49F6A] hover:bg-[#350812] transition-colors border-t border-[#350812] mt-2 pt-3">
                🔍 Cek & Download Barcode Tiket
            </a>
        </div>
    </header>

    <!-- Notification Alerts -->
    @if(session('success'))
        <div class="no-print max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
            <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-900 flex items-start gap-3 shadow-sm">
                <svg class="w-5 h-5 text-emerald-600 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <div class="text-sm font-medium">{{ session('success') }}</div>
            </div>
        </div>
    @endif

    @if($errors->any())
        <div class="no-print max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
            <div class="p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-900 flex items-start gap-3 shadow-sm">
                <svg class="w-5 h-5 text-rose-600 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <div class="text-sm">
                    <div class="font-semibold mb-1">Periksa kembali data pemesanan Anda:</div>
                    <ul class="list-disc list-inside space-y-0.5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    <!-- Main Content Slot -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="no-print bg-[#20040A] text-[#FAF6F0] border-t border-[#350812] mt-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <!-- Brand Info -->
                <div class="md:col-span-2">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 rounded-lg bg-[#4B0C1A] border border-[#7E1B31] flex items-center justify-center text-[#FAF6F0]">
                            <svg class="w-5 h-5 text-[#C49F6A]" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M4 4h16a2 2 0 012 2v12a2 2 0 01-2 2H4a2 2 0 01-2-2V6a2 2 0 012-2zm0 2v3h2V6H4zm4 0v3h8V6H8zm10 0v3h2V6h-2zM4 11v3h2v-3H4zm16 0v3h2v-3h-2zM4 16v2h2v-2H4zm16 0v2h2v-2h-2zM8 11h8v7H8v-7z"/>
                            </svg>
                        </div>
                        <span class="font-serif text-2xl font-bold tracking-wider text-[#FAF6F0]">balih<span class="text-[#C49F6A]">film</span></span>
                    </div>
                    <p class="text-[#D3C2AB] text-sm leading-relaxed max-w-md">
                        Bioskop modern dengan kenyamanan premium, tata suara Dolby Atmos berkualitas tinggi, proyektor laser jernih, dan layanan pemesanan tiket online tanpa antre.
                    </p>
                    <div class="mt-4 flex flex-wrap items-center gap-2 text-xs text-[#BAA386]">
                        <span class="px-2.5 py-1 rounded bg-[#350812] border border-[#4B0C1A] text-[#FAF6F0]">Studio 1 Dolby Atmos</span>
                        <span class="px-2.5 py-1 rounded bg-[#350812] border border-[#4B0C1A] text-[#FAF6F0]">Studio 2 Classic</span>
                        <span class="px-2.5 py-1 rounded bg-[#350812] border border-[#4B0C1A] text-[#FAF6F0]">Studio 3 VIP Lounge</span>
                    </div>
                </div>

                <!-- Navigation Quick Links -->
                <div>
                    <h4 class="font-serif text-[#FAF6F0] font-semibold mb-4 text-base tracking-wide">Navigasi Bioskop</h4>
                    <ul class="space-y-2 text-sm text-[#D3C2AB]">
                        <li><a href="{{ route('movies.index', ['status' => 'all']) }}" class="hover:text-white transition-colors">Daftar Semua Film</a></li>
                        <li><a href="{{ route('movies.index', ['status' => 'now_playing']) }}" class="hover:text-white transition-colors">Jadwal Sedang Tayang</a></li>
                        <li><a href="{{ route('movies.index', ['status' => 'upcoming']) }}" class="hover:text-white transition-colors">Film Akan Datang</a></li>
                        <li><a href="{{ route('bookings.lookup') }}" class="hover:text-white transition-colors">Download Barcode Tiket</a></li>
                    </ul>
                </div>

                <!-- Contact & Location -->
                <div>
                    <h4 class="font-serif text-[#FAF6F0] font-semibold mb-4 text-base tracking-wide">Layanan Penonton</h4>
                    <div class="space-y-2.5 text-sm text-[#D3C2AB]">
                        <div class="flex items-start gap-2">
                            <span class="text-[#C49F6A]">&bull;</span>
                            <span>Balih Central Mall Lt. 3, Abiansemal, Badung, Bali</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="text-[#C49F6A]">&bull;</span>
                            <span>Buka Setiap Hari: 10:00 - 23:00 WIB</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="text-[#C49F6A]">&bull;</span>
                            <a href="https://wa.me/6281529434240" target="_blank" class="hover:text-white transition-colors">
                                WhatsApp Bantuan: 0815-2943-4240
                            </a>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="text-[#C49F6A]">&bull;</span>
                            <a href="mailto:tiket@balihfilm.id" class="hover:text-white transition-colors">
                                Email: tiket@balihfilm.id
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-12 pt-6 border-t border-[#350812] flex flex-col md:flex-row justify-between items-center text-xs text-[#BAA386] gap-4">
                <div class="text-center md:text-left">
                    &copy; {{ date('Y') }} <span class="font-serif font-bold text-[#FAF6F0]">balih<span class="text-[#C49F6A]">film</span></span>. Dibuat dan dikembangkan oleh 
                    <a href="https://github.com/aldwrnnnnn" target="_blank" rel="noopener noreferrer" class="font-semibold text-[#FAF6F0] hover:text-[#C49F6A] underline decoration-[#C49F6A]/50 transition-colors">
                        I Gede Aldi Irawan
                    </a>. Seluruh hak cipta dilindungi.
                </div>
                <div class="flex flex-wrap items-center justify-center gap-3">
                    <a href="https://github.com/aldwrnnnnn/balihfilm" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded bg-[#350812] border border-[#4B0C1A] text-[#D3C2AB] hover:text-white hover:border-[#C49F6A] transition-colors">
                        <svg class="w-3.5 h-3.5 text-[#C49F6A]" fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.53 1.032 1.53 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" clip-rule="evenodd"/>
                        </svg>
                        <span>@aldwrnnnnn</span>
                    </a>
                    <span>&bull;</span>
                    <span>Tunjukkan Barcode di Pintu Studio</span>
                </div>
            </div>
        </div>
    </footer>

    <!-- Mobile Menu Script -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const toggleBtn = document.getElementById('mobileMenuToggle');
        const menu = document.getElementById('mobileMenu');
        const hamburgerIcon = document.getElementById('hamburgerIcon');
        const closeIcon = document.getElementById('closeIcon');

        if (toggleBtn && menu) {
            toggleBtn.addEventListener('click', function() {
                const isOpen = !menu.classList.contains('hidden');
                if (isOpen) {
                    menu.classList.add('hidden');
                    toggleBtn.setAttribute('aria-expanded', 'false');
                    hamburgerIcon.classList.remove('hidden');
                    closeIcon.classList.add('hidden');
                } else {
                    menu.classList.remove('hidden');
                    toggleBtn.setAttribute('aria-expanded', 'true');
                    hamburgerIcon.classList.add('hidden');
                    closeIcon.classList.remove('hidden');
                }
            });
        }
    });
    </script>

    @stack('scripts')
</body>
</html>
