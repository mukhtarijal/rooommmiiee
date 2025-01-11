{{-- resources/views/partials/kost-list.blade.php --}}

<div class="max-w-7xl mx-auto pt-12 px-4 sm:px-6 lg:px-8">
    {{-- Header Section with Title and Controls --}}
    <div class="flex flex-col sm:flex-row justify-between items-center mb-4">
        <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-2 sm:mb-1">
            {{ $title ?? 'Rekomendasi Kost Terbaik' }}
        </h2>
        <div class="flex items-center space-x-4">
            <div class="hidden sm:flex items-center space-x-2">
                <button id="prev-kost" class="p-2 rounded-full hover:bg-gray-100 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>
                <button id="next-kost" class="p-2 rounded-full hover:bg-gray-100 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
            </div>
            <a href="{{ match($list) {
                        'premium' => route('kost.premium'),
                        'same-city' => route('kost.same-city'),
                        default => route('kost.index'),
                    }
                }}"
               class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors">
                Lihat Semua
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </a>
        </div>
    </div>


    {{-- Kost Cards Container --}}
    <div class="relative">
        <div class="swiper-container">
            <div class="swiper-wrapper">
                @foreach ($kosts as $kost)
                    <div class="swiper-slide p-2"> {{-- Kurangi padding untuk mengurangi ruang antar-card --}}
                        <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition-all duration-300 overflow-hidden border border-gray-100 w-72"> {{-- Atur lebar card --}}
                            {{-- Image Container --}}
                            <div class="relative" style="aspect-ratio: 16 / 9;"> {{-- Pertahankan rasio gambar --}}
                                @if ($kost->photos->isNotEmpty())
                                    @php
                                        $photos = $kost->photos->first()->photo;
                                        $firstPhoto = is_array($photos) && !empty($photos) ? $photos[0] : null;
                                    @endphp
                                    @if ($firstPhoto)
                                        <img
                                            src="{{ asset('storage/' . $firstPhoto) }}"
                                            alt="{{ $kost->name }}"
                                            class="w-full h-full object-cover"
                                            loading="lazy"
                                        >
                                    @else
                                        <div class="w-full h-full bg-gray-100 flex items-center justify-center">
                                            <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                    @endif
                                @endif

                                {{-- Gender Badge --}}
                                <div class="absolute top-2 left-2">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $kost->gender === 'L' ? 'bg-blue-100 text-blue-800' : 'bg-pink-100 text-pink-800' }}">
                                    {{ $kost->gender === 'L' ? 'Laki-laki' : 'Perempuan' }}
                                </span>
                                </div>
                            </div>

                            {{-- Content Container --}}
                            <div class="p-3"> {{-- Kurangi padding --}}
                                {{-- Nama Kost --}}
                                <h3 class="text-base font-semibold text-gray-900 mb-1 line-clamp-1">{{ $kost->name }}</h3>

                                {{-- Facilities, Available Rooms, dan Price --}}
                                <div class="space-y-1 mb-2"> {{-- Kurangi margin --}}
                                    {{-- Facilities --}}
                                    <div class="flex items-start text-gray-600 text-xs"> {{-- Perkecil ukuran font --}}
                                        <svg class="w-4 h-4 text-gray-400 mr-1 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                        </svg>
                                        <p class="line-clamp-1">{{ $kost->limitedFacilities ?? 'Tidak ada informasi fasilitas' }}</p>
                                    </div>

                                    {{-- Available Rooms --}}
                                    <div class="flex items-center text-gray-600 text-xs"> {{-- Perkecil ukuran font --}}
                                        <svg class="w-4 h-4 text-gray-400 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01" />
                                        </svg>
                                        <span>{{ $kost->available_rooms }} Kamar Tersedia</span>
                                    </div>

                                    {{-- Price --}}
                                    <div class="flex items-center text-gray-900 text-xs"> {{-- Perkecil ukuran font --}}
                                        <svg class="w-4 h-4 text-gray-400 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <span class="font-semibold">
                                        @if ($kost->durations->isNotEmpty())
                                                Rp {{ number_format($kost->durations->first()->price, 0, ',', '.') }}/bulan
                                            @else
                                                Harga tidak tersedia
                                            @endif
                                    </span>
                                    </div>
                                </div>

                                {{-- Detail Button --}}
                                <a
                                    href="{{ route('kost.detail', $kost->slug) }}"
                                    class="block w-full text-center px-3 py-1.5 border border-transparent rounded-lg shadow-sm text-xs font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors"
                                >
                                    Lihat Detail
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const swiper = new Swiper('.swiper-container', {
                slidesPerView: 1,
                spaceBetween: 16,
                navigation: {
                    nextEl: '#next-kost',
                    prevEl: '#prev-kost',
                },
                breakpoints: {
                    640: {
                        slidesPerView: 2,
                    },
                    768: {
                        slidesPerView: 3,
                    },
                    1024: {
                        slidesPerView: 4,
                    },
                },
            });
        });
    </script>
@endpush
