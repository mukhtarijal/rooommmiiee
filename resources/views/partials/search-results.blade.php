{{-- resources/views/partials/search-results.blade.php --}}
@if ($searchResults->isNotEmpty())
    <div class="mt-8">
        <h2 class="text-2xl font-bold mb-4">Hasil Pencarian untuk "{{ $searchQuery }}"</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($searchResults as $kost)
                <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition-all duration-300 overflow-hidden border border-gray-100">
                    {{-- Image Container --}}
                    <div class="relative" style="aspect-ratio: 16 / 9;">
                        @if ($kost->photos->isNotEmpty())
                            <img
                                src="{{ asset('storage/' . $kost->photos->first()->photo[0]) }}"
                                alt="{{ $kost->name }}"
                                class="w-full h-full object-cover"
                                loading="lazy"
                            >
                        @else
                            <div class="w-full h-full bg-gray-100 flex items-center justify-center">
                                <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                        @endif
                    </div>

                    {{-- Content Container --}}
                    <div class="p-4">
                        <h3 class="text-lg font-semibold text-gray-900 mb-2 line-clamp-1">{{ $kost->name }}</h3>
                        <div class="space-y-2 mb-4">
                            {{-- Facilities --}}
                            <div class="flex items-start text-gray-600 text-sm">
                                <svg class="w-5 h-5 text-gray-400 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                                <p class="line-clamp-1">{{ $kost->limitedFacilities ?? 'Tidak ada informasi fasilitas' }}</p>
                            </div>

                            {{-- Price --}}
                            <div class="flex items-center text-gray-900">
                                <svg class="w-5 h-5 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                            class="block w-full text-center px-4 py-2 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors"
                        >
                            Lihat Detail
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@else
    <div class="mt-8">
        <p class="text-gray-600">Tidak ada hasil pencarian untuk "{{ $searchQuery }}".</p>
    </div>
@endif
