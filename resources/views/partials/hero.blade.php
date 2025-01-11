{{-- resources/views/partials/hero.blade.php --}}
<div class="relative min-h-[600px] flex items-center justify-center bg-cover bg-center bg-fixed overflow-hidden"
     style="background-image: linear-gradient(rgba(0, 0, 0, 0.65), rgba(0, 0, 0, 0.65)), url('{{ asset('home7.jpg') }}');">
    {{-- Subtle gradient overlay for better text readability --}}
    <div class="absolute inset-0 bg-gradient-to-b from-black/30 via-black/20 to-black/30"></div>

    <div class="relative max-w-5xl mx-auto text-center text-white px-6 py-20">
        @auth
            <span class="inline-block px-6 py-2.5 bg-black/30 backdrop-blur-sm rounded-full text-sm font-medium mb-8">
                ✨ Selamat Datang Kembali
            </span>
            <h1 class="text-5xl md:text-6xl font-bold mb-6 leading-tight tracking-tight">
                Hai, {{ auth()->user()->name }}!
                <span class="block text-2xl md:text-3xl font-normal mt-4 text-white/90">
                    Mau cari kos dimana hari besok?
                </span>
            </h1>
        @else
            <span class="inline-block px-6 py-2.5 bg-black/30 backdrop-blur-sm rounded-full text-sm font-medium mb-8">
                🏠 Platform Pencarian Kos #1 di Mana??
            </span>
            <h1 class="text-5xl md:text-6xl font-bold mb-8 leading-tight tracking-tight">
                Temukan Kos Impianmu
                <span class="block text-2xl md:text-3xl font-normal mt-4 text-white/90">
                    Dengan Mudah dan Cepat Bersama Roomie
                </span>
            </h1>

            {{-- Tombol "Cari Kost" --}}
            <a href="{{ route('kost.index') }}"
               class="inline-block px-8 py-3.5 bg-white text-gray-900 font-semibold rounded-full hover:bg-gray-100 hover:shadow-lg transition-all duration-300 transform hover:scale-105">
                Cari Kost Sekarang
            </a>
        @endauth
    </div>
</div>
