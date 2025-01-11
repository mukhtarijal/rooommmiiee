<x-app-layout>
    <div class="min-h-screen bg-gray-50">
        <div class="max-w-4xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                <!-- Header -->
                <div class="bg-gradient-to-r from-green-600 to-green-700 px-8 py-6">
                    <h1 class="text-2xl font-bold text-white">
                        Formulir Pengajuan Sewa Kost
                    </h1>
                    <p class="text-green-100 mt-2">
                        {{ $kost->name }}
                    </p>
                </div>

                <!-- Progress Bar -->
                <div class="px-8 pt-6"
                     x-data="{
                        step: 1,
                        duration: '',
                        price: null,
                        promoCode: '',
                        finalPrice: null,
                        startDate: '',
                        durations: {{ json_encode($durations) }},
                        promoCodes: {{ json_encode($promoCodes) }},
                        updateFinalPrice() {
                            this.finalPrice = this.price;
                            if (this.promoCode) {
                                const promo = this.promoCodes.find(p => p.promo_code === this.promoCode);
                                if (promo) {
                                    if (promo.promo_type === 'percentage') {
                                        this.finalPrice = this.price - (this.price * (promo.promo_value / 100));
                                    } else if (promo.promo_type === 'fixed') {
                                        this.finalPrice = this.price - promo.promo_value;
                                    }
                                }
                            }
                        },
                        submitForm() {
                            if (!this.duration || !this.startDate || this.finalPrice === null) {
                                alert('Mohon lengkapi semua data yang diperlukan');
                                return;
                            }
                            document.getElementById('duration').value = this.duration;
                            document.getElementById('price').value = this.finalPrice;
                            document.getElementById('promo_code').value = this.promoCode;
                            document.getElementById('start_date').value = this.startDate;
                            document.getElementById('sewaForm').submit();
                        }
                    }">
                    <div class="relative">
                        <div class="absolute left-0 top-1/2 w-full h-1 bg-gray-200 -translate-y-1/2"></div>
                        <div class="relative flex justify-between">
                            <div class="flex flex-col items-center">
                                <div class="w-10 h-10 rounded-full border-2 flex items-center justify-center"
                                     :class="step >= 1 ? 'border-green-600 bg-green-600 text-white' : 'border-gray-300 bg-white'">
                                    1
                                </div>
                                <span class="mt-2 text-sm font-medium" :class="step >= 1 ? 'text-green-600' : 'text-gray-500'">
                                    Durasi
                                </span>
                            </div>
                            <div class="flex flex-col items-center">
                                <div class="w-10 h-10 rounded-full border-2 flex items-center justify-center"
                                     :class="step >= 2 ? 'border-green-600 bg-green-600 text-white' : 'border-gray-300 bg-white'">
                                    2
                                </div>
                                <span class="mt-2 text-sm font-medium" :class="step >= 2 ? 'text-green-600' : 'text-gray-500'">
                                    Promo
                                </span>
                            </div>
                            <div class="flex flex-col items-center">
                                <div class="w-10 h-10 rounded-full border-2 flex items-center justify-center"
                                     :class="step >= 3 ? 'border-green-600 bg-green-600 text-white' : 'border-gray-300 bg-white'">
                                    3
                                </div>
                                <span class="mt-2 text-sm font-medium" :class="step >= 3 ? 'text-green-600' : 'text-gray-500'">
                                    Tanggal
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 pb-8">
                        <!-- Step 1: Durasi -->
                        <div x-show="step === 1" class="space-y-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Pilih Durasi Sewa
                                </label>
                                <select x-model="duration" @change="price = durations[duration]; updateFinalPrice()"
                                        class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                                    <option value="">-- Pilih Durasi Sewa --</option>
                                    @foreach ($durations as $type => $price)
                                        @php
                                            $durationText = '';
                                            switch ($type) {
                                                case 'daily':
                                                    $durationText = 'Perhari';
                                                    break;
                                                case 'weekly':
                                                    $durationText = 'Perminggu';
                                                    break;
                                                case 'monthly':
                                                    $durationText = 'Perbulan';
                                                    break;
                                                case '3_monthly':
                                                    $durationText = 'Per Tiga Bulan';
                                                    break;
                                                case '6_monthly':
                                                    $durationText = 'Per Enam Bulan';
                                                    break;
                                                case 'yearly':
                                                    $durationText = 'Pertahun';
                                                    break;
                                                default:
                                                    $durationText = ucfirst(str_replace('_', ' ', $type));
                                                    break;
                                            }
                                        @endphp
                                        <option value="{{ $type }}">
                                            {{ $durationText }} - Rp {{ number_format($price, 0, ',', '.') }}
                                        </option>
                                    @endforeach
                                </select>
                                <span x-show="step === 1 && !duration" class="text-sm text-red-500">Durasi sewa harus dipilih.</span>
                            </div>

                            <div class="bg-gray-50 rounded-lg p-4">
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-gray-600">Total Biaya:</span>
                                    <span class="text-lg font-semibold text-gray-900">
                    Rp <span x-text="price ? new Intl.NumberFormat('id-ID').format(price) : '0'"></span>
                </span>
                                </div>
                            </div>

                            <div class="flex justify-end">
                                <button @click="step = 2" :disabled="!duration"
                                        class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors disabled:opacity-50 disabled:cursor-not-allowed">
                                    Lanjutkan
                                </button>
                            </div>
                        </div>

                        <!-- Step 2: Promo -->
                        <div x-show="step === 2" class="space-y-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Kode Promo (Opsional)
                                </label>
                                <select x-model="promoCode" @change="updateFinalPrice()"
                                        class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                                    <option value="">-- Pilih Kode Promo --</option>
                                    @foreach ($promoCodes as $promo)
                                        <option value="{{ $promo->promo_code }}">{{ $promo->promo_code }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="bg-gray-50 rounded-lg p-4 space-y-2">
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-gray-600">Harga Awal:</span>
                                    <span class="text-gray-900">
                    Rp <span x-text="price ? new Intl.NumberFormat('id-ID').format(price) : '0'"></span>
                </span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-gray-600">Harga Setelah Promo:</span>
                                    <span class="text-lg font-semibold text-green-600">
                    Rp <span x-text="finalPrice ? new Intl.NumberFormat('id-ID').format(finalPrice) : '0'"></span>
                </span>
                                </div>
                            </div>

                            <div class="flex justify-between">
                                <button @click="step = 1"
                                        class="px-6 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
                                    Kembali
                                </button>
                                <button @click="step = 3"
                                        class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                                    Lanjutkan
                                </button>
                            </div>
                        </div>

                        <!-- Step 3: Tanggal -->
                        <div x-show="step === 3" class="space-y-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Tanggal Mulai Sewa
                                </label>
                                <input type="date" x-model="startDate" min="{{ date('Y-m-d') }}"
                                       class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                                <span x-show="step === 3 && !startDate" class="text-sm text-red-500">Tanggal mulai sewa harus diisi.</span>
                            </div>

                            <div class="bg-gray-50 rounded-lg p-4">
                                <div class="space-y-2">
                                    <div class="flex justify-between items-center">
                                        <span class="text-sm text-gray-600">Durasi Sewa:</span>
                                        <span class="text-gray-900" x-text="duration ? duration.replace('_', ' ') : '-'"></span>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <span class="text-sm text-gray-600">Total Pembayaran:</span>
                                        <span class="text-lg font-semibold text-green-600">
                        Rp <span x-text="finalPrice ? new Intl.NumberFormat('id-ID').format(finalPrice) : '0'"></span>
                    </span>
                                    </div>
                                </div>
                            </div>

                            <div class="flex justify-between">
                                <button @click="step = 2"
                                        class="px-6 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
                                    Kembali
                                </button>
                                <button @click="submitForm()" :disabled="!startDate || !duration || !price"
                                        class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors disabled:opacity-50 disabled:cursor-not-allowed">
                                    Ajukan Sewa
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Hidden Form -->
    <form id="sewaForm" action="{{ route('sewa.store', $kost->id) }}" method="POST" class="hidden">
        @csrf
        <input type="hidden" id="duration" name="duration">
        <input type="hidden" id="price" name="price">
        <input type="hidden" id="promo_code" name="promo_code">
        <input type="hidden" id="start_date" name="start_date">
    </form>

    <!-- Success Alert -->
    <!-- Modal Alert -->
    <div x-data="{ showAlert: {{ session('show_alert') ? 'true' : 'false' }} }" x-init="if (showAlert) { setTimeout(() => showAlert = false, 3000); }">
        <!-- Overlay -->
        <div x-show="showAlert" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
            <!-- Modal Content -->
            <div class="bg-white rounded-lg shadow-lg p-6 w-11/12 max-w-md">
                <div class="text-center">
                    <!-- Icon Sukses -->
                    <svg class="mx-auto h-12 w-12 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <!-- Pesan Sukses -->
                    <h3 class="mt-4 text-lg font-medium text-gray-900">{{ session('success') }}</h3>
                    <!-- Tombol OK -->
                    <div class="mt-6">
                        <button @click="showAlert = false; window.location.href = '{{ route('sewa.index') }}'"
                                class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                            OK
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
