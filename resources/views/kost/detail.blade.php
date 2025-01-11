<x-app-layout>
    <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <!-- Header Section with Title and Quick Actions -->
        <div class="flex justify-between items-center mb-6">
            <div class="flex items-center space-x-4">
                <h1 class="text-3xl font-bold text-gray-900">{{ $kost->name }}</h1>
            </div>
        </div>

        <!-- Main Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column - Photos and Info -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Image Slider -->
                <div class="relative rounded-xl overflow-hidden shadow-lg">
                    <div class="swiper-container" style="aspect-ratio: 16 / 9;">
                        <div class="swiper-wrapper">
                            @foreach ($kost->photos as $photo)
                                @if (is_array($photo->photo))
                                    @foreach ($photo->photo as $image)
                                        <div class="swiper-slide">
                                            <img src="{{ asset('storage/' . $image) }}" alt="Kost Photo" class="w-full h-full object-cover">
                                        </div>
                                    @endforeach
                                @else
                                    <div class="swiper-slide">
                                        <img src="{{ asset('storage/' . $photo->photo) }}" alt="Kost Photo" class="w-full h-full object-cover">
                                    </div>
                                @endif
                            @endforeach
                        </div>
                        <div class="swiper-button-next text-white"></div>
                        <div class="swiper-button-prev text-white"></div>
                    </div>
                </div>

                <!-- Basic Information -->
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Informasi Kost</h2>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="flex items-center space-x-2">
                            <svg class="w-5 h-5 text-gray-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            <span class="text-gray-700">{{ $kost->gender === 'L' ? 'Kost Putra' : 'Kost Putri' }}</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <svg class="w-5 h-5 text-gray-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                            <span class="text-gray-700">Berdiri: {{ $kost->year_established }}</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <svg class="w-5 h-5 text-gray-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"/>
                            </svg>
                            <span class="text-gray-700">{{ $kost->room_size }} m²</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <svg class="w-5 h-5 text-gray-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <span class="text-gray-700">{{ $kost->address }}, {{ $kost->city->name }}</span>
                        </div>
                    </div>
                </div>

                <!-- Facilities -->
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Fasilitas</h2>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                        @foreach ($kost->facilities as $facility)
                            <div class="flex items-center space-x-2">
                                @if ($facility->icon)
                                    <img src="{{ asset('storage/' . $facility->icon) }}" alt="{{ $facility->name }}" class="w-5 h-5 flex-shrink-0">
                                @else
                                    <svg class="w-5 h-5 text-[#36bf5a] flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                @endif
                                <span class="text-gray-700">{{ $facility->name }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Rules -->
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Aturan Kost</h2>
                    <div class="space-y-3">
                        @foreach ($kost->rules as $rule)
                            <div class="flex items-center space-x-2">
                                <svg class="w-5 h-5 text-red-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span class="text-gray-700">{{ $rule->rule }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Right Column - Pricing and Action -->
            <div class="lg:col-span-1">
                <div class="sticky top-8 space-y-6">
                    <!-- Pricing Card -->
                    <div class="bg-white rounded-xl shadow-lg p-6">
                        <div class="mb-4">
                            <div class="flex items-center mb-2">
                                <span class="text-lg font-semibold text-gray-700">Rating:</span>
                                <div class="ml-2 flex items-center">
                                    @for ($i = 1; $i <= 5; $i++)
                                        @if ($i <= $averageRating)
                                            <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.364 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.196-1.538-1.118l1.518-4.674a1 1 0 00-.364-1.118L2.33 9.121c-.783-.57-.38-1.81.588-1.81h4.915a1 1 0 00.95-.69l1.519-4.674z"/>
                                            </svg>
                                        @else
                                            <svg class="w-5 h-5 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.364 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.196-1.538-1.118l1.518-4.674a1 1 0 00-.364-1.118L2.33 9.121c-.783-.57-.38-1.81.588-1.81h4.915a1 1 0 00.95-.69l1.519-4.674z"/>
                                            </svg>
                                        @endif
                                    @endfor
                                </div>
                            </div>
                            <p class="text-sm text-gray-500">{{ $kost->reviews->count() }} ulasan</p>
                        </div>

                        <div class="border-t pt-4">
                            <p class="text-gray-700"><strong>Kamar Tersedia:</strong> {{ $kost->available_rooms }}</p>
                            <p class="text-gray-700"><strong>Kapasitas:</strong> {{ $kost->capacity }} orang</p>
                        </div>

                        <!-- Tombol Ajukan Sewa -->
                        <a href="{{ route('sewa.create', $kost->id) }}" class="block w-full text-center mt-6 px-6 py-3 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors">
                            Ajukan Sewa
                        </a>

                    </div>
                </div>
            </div>
        </div>

        <!-- Reviews Section -->
        <div class="mt-8 bg-white rounded-xl shadow-lg p-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-6">Ulasan</h2>
            <div class="space-y-6">
                @foreach ($kost->reviews as $review)
                    <div class="border-b last:border-b-0 pb-6 last:pb-0">
                        <div class="flex items-center mb-3">
                            <div class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center">
                                <span class="text-xl font-semibold text-gray-600">{{ substr($review->tenant->name, 0, 1) }}</span>
                            </div>
                            <div class="ml-4">
                                <p class="font-semibold text-gray-900">{{ $review->tenant->name }}</p>
                                <div class="flex items-center mt-1">
                                    @for ($i = 1; $i <= 5; $i++)
                                        @if ($i <= $review->rating)
                                            <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.364 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.196-1.538-1.118l1.518-4.674a1 1 0 00-.364-1.118L2.33 9.121c-.783-.57-.38-1.81.588-1.81h4.915a1 1 0 00.95-.69l1.519-4.674z"/>
                                            </svg>
                                        @else
                                            <svg class="w-4 h-4 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.364 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.196-1.538-1.118l1.518-4.674a1 1 0 00-.364-1.118L2.33 9.121c-.783-.57-.38-1.81.588-1.81h4.915a1 1 0 00.95-.69l1.519-4.674z"/>
                                            </svg>
                                        @endif
                                    @endfor
                                </div>
                            </div>
                        </div>
                        <p class="text-gray-700 ml-14">{{ $review->review }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    @push('styles')
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/8.4.7/swiper-bundle.min.css">
    @endpush

    @push('scripts')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/8.4.7/swiper-bundle.min.js"></script>
        <script>
            // Kode untuk Swiper
            document.addEventListener('DOMContentLoaded', function() {
                const swiper = new Swiper('.swiper-container', {
                    loop: true,
                    navigation: {
                        nextEl: '.swiper-button-next',
                        prevEl: '.swiper-button-prev',
                    },
                    autoplay: {
                        delay: 5000,
                        disableOnInteraction: false,
                    },
                    effect: 'fade',
                    fadeEffect: {
                        crossFade: true
                    }
                });
            });
        </script>
    @endpush
</x-app-layout>
