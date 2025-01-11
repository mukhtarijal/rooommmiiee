<x-app-layout>
    <div class="min-h-screen bg-gray-50">
        <div class="max-w-4xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                <!-- Header -->
                <div class="bg-gradient-to-r from-green-600 to-green-700 px-8 py-6">
                    <h1 class="text-2xl font-bold text-white">
                        Unggah Bukti Pembayaran
                    </h1>
                    <p class="text-green-100 mt-2">
                        {{ $sewa->kost->name }}
                    </p>
                </div>

                <!-- Form Upload -->
                <div class="px-8 py-6">
                    <form action="{{ route('sewa.upload.submit', $sewa->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="space-y-6">
                            <!-- Informasi Sewa -->
                            <div class="bg-gray-50 rounded-lg p-4">
                                <div class="space-y-2">
                                    <div class="flex justify-between items-center">
                                        <span class="text-sm text-gray-600">Durasi Sewa:</span>
                                        <span class="text-sm text-gray-900">
                                            @php
                                                $durationText = match ($sewa->duration) {
                                                    'daily' => 'Perhari',
                                                    'weekly' => 'Perminggu',
                                                    'monthly' => 'Perbulan',
                                                    '3_monthly' => 'Per Tiga Bulan',
                                                    '6_monthly' => 'Per Enam Bulan',
                                                    'yearly' => 'Pertahun',
                                                    default => ucfirst(str_replace('_', ' ', $sewa->duration)),
                                                };
                                            @endphp
                                            {{ $durationText }}
                                        </span>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <span class="text-sm text-gray-600">Total Pembayaran:</span>
                                        <span class="text-sm text-gray-900">Rp {{ number_format($sewa->price, 0, ',', '.') }}</span>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <span class="text-sm text-gray-600">Tanggal Mulai:</span>
                                        <span class="text-sm text-gray-900">{{ \Carbon\Carbon::parse($sewa->start_date)->format('d M Y') }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Daftar Metode Pembayaran (Hanya Informasi) -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Metode Pembayaran yang Tersedia
                                </label>
                                <div class="bg-gray-50 rounded-lg p-4 space-y-4">
                                    @foreach ($paymentMethods as $method)
                                        <div class="flex justify-between items-center">
                                            <!-- Nama Metode Pembayaran (dari tabel payment_methods) -->
                                            <span class="text-sm text-gray-600">
                                                {{ $method->paymentMethod->name }} <!-- Akses relasi paymentMethod -->
                                            </span>
                                            <!-- Nomor Rekening dan Nama Akun (dari tabel roomie_payment_methods) -->
                                            <!-- Nomor Rekening dan Nama Akun (dari tabel roomie_payment_methods) -->
                                            <span class="text-sm text-gray-900">
                                                <!-- Nomor Rekening (Bold) -->
                                                <span class="font-bold">{{ $method->account_number }}</span>

                                                                                            <!-- Jarak antara nomor dan nama -->
                                                <span class="mx-1"></span>

                                                                                            <!-- Nama Akun (jika ada) -->
                                                @if ($method->account_name)
                                                                                                ({{ $method->account_name }})
                                                                                            @endif
                                            </span>
                                        </div>
                                    @endforeach
                                </div>
                                <p class="mt-2 text-sm text-gray-500">
                                    Silakan transfer ke salah satu metode pembayaran di atas, lalu unggah bukti pembayaran di bawah ini.
                                </p>
                            </div>

                            <!-- Input File -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Unggah Bukti Pembayaran
                                </label>
                                <input type="file" name="payment_proof" accept=".jpg,.jpeg,.png,.pdf" required
                                       class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                                @error('payment_proof')
                                <span class="text-sm text-red-500">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Tombol Submit -->
                            <div class="flex justify-end">
                                <button type="submit"
                                        class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                                    Unggah
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
