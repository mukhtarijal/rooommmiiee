{{-- resources/views/partials/about-features.blade.php --}}
<section class="bg-gray-50 mt-10">
    {{-- About Section with Image --}}
    <div class="max-w-6xl mx-auto py-20 px-4">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center mb-24">
            <div class="relative">
                <img src="{{ asset('home1.jpg') }}" alt="Roomie Kos" class="w-full h-[500px] object-cover rounded-2xl shadow-lg">
                <div class="absolute inset-0 bg-gradient-to-t from-black/30 to-transparent rounded-2xl"></div>
            </div>
            <div class="text-left">
                <span class="text-primary-600 font-medium text-sm tracking-wider uppercase">Tentang Kami</span>
                <h2 class="text-4xl font-bold text-gray-900 mt-4 mb-6">Kenapa Memilih Roomie?</h2>
                <p class="text-gray-600 text-lg leading-relaxed mb-8">
                    Roomie hadir khusus untuk memenuhi kebutuhan pencarian kos di wilayah Kota Padang. Kami fokus menyediakan
                    berbagai pilihan kos di lokasi strategis dalam kota ini, memastikan pengguna dapat menemukan tempat tinggal yang
                    nyaman, sesuai preferensi, dan dalam anggaran yang terjangkau.
                </p>
                <div class="space-y-4">
                    {{-- Feature Points --}}
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-primary-100 rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                        <span class="text-gray-700">Verifikasi kos terpercaya</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-primary-100 rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <span class="text-gray-700">Harga transparan tanpa biaya tersembunyi</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-primary-100 rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                        <span class="text-gray-700">Lokasi strategis di seluruh Kota Padang</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Features Section with Image --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div class="order-2 lg:order-1">
                <h2 class="text-3xl font-bold text-gray-900 mb-6">Solusi Terbaik untuk Pencarian Kos</h2>
                <div class="space-y-8">
                    <div class="bg-white p-6 rounded-xl shadow-sm hover:shadow-md transition-shadow duration-300">
                        <h3 class="text-xl font-semibold text-primary-600 mb-3">Cepat & Efisien</h3>
                        <p class="text-gray-600">Dengan Roomie, temukan kos sesuai lokasi, fasilitas, dan budgetmu hanya dalam hitungan menit.</p>
                    </div>
                    <div class="bg-white p-6 rounded-xl shadow-sm hover:shadow-md transition-shadow duration-300">
                        <h3 class="text-xl font-semibold text-primary-600 mb-3">Pilihan Beragam</h3>
                        <p class="text-gray-600">Roomie menyediakan berbagai pilihan kos yang berlokasi di area strategis, dilengkapi dengan fasilitas unggulan.</p>
                    </div>
                    <div class="bg-white p-6 rounded-xl shadow-sm hover:shadow-md transition-shadow duration-300">
                        <h3 class="text-xl font-semibold text-primary-600 mb-3">Terpercaya</h3>
                        <p class="text-gray-600">Platform ini memungkinkanmu terhubung langsung dengan pemilik kos tanpa melalui perantara.</p>
                    </div>
                </div>
            </div>
            <div class="relative order-1 lg:order-2">
                <img src="{{ asset('home4.jpg') }}" alt="Fitur Roomie" class="w-full h-[400px] object-cover rounded-2xl shadow-lg">
                <div class="absolute inset-0 bg-gradient-to-t from-black/30 to-transparent rounded-2xl"></div>
            </div>
        </div>
    </div>
</section>
