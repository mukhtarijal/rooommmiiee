<x-app-layout>
    <div class="min-h-screen bg-gray-50">
        <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
            <h1 class="text-2xl font-bold text-gray-900 mb-8">Daftar Pengajuan Sewa</h1>

            @if (session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            @if (session('error'))
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
                    <p>{{ session('error') }}</p>
                </div>
            @endif

            @if ($sewas->isEmpty())
                <div class="bg-white p-6 rounded-lg shadow-md text-center">
                    <p class="text-gray-600">Anda belum mengajukan sewa.</p>
                    <a href="{{ route('kost.index') }}"
                       class="mt-4 inline-block px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                        Cari Kost
                    </a>
                </div>
            @else
                <div class="space-y-6">
                    @foreach ($sewas as $sewa)
                        <div class="bg-white rounded-lg shadow-md overflow-hidden">
                            <div class="p-6">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h2 class="text-xl font-semibold text-gray-900">{{ $sewa->kost->name }}</h2>
                                        <p class="text-sm text-gray-500">{{ $sewa->kost->address }}</p>
                                    </div>
                                    @php
                                        $statusClasses = match ($sewa->status) {
                                            'pending' => 'bg-yellow-100 text-yellow-800',
                                            'approved' => 'bg-green-100 text-green-800',
                                            'cancelled' => 'bg-red-100 text-red-800',
                                            'payment_verified' => 'bg-blue-100 text-blue-800',
                                            'active' => 'bg-green-200 text-green-900',
                                            default => 'bg-gray-100 text-gray-800',
                                        };
                                    @endphp


                                    <span class="px-3 py-1 text-sm font-semibold rounded-full {{ $statusClasses }}">
                                        {{ ucfirst($sewa->status) }}
                                    </span>
                                </div>

                                <div class="mt-4 space-y-2">
                                    <div class="flex justify-between">
                                        <span class="text-sm text-gray-600">Durasi Sewa:</span>
                                        <span class="text-sm text-gray-900">
                                            @php
                                                $durationText = '';
                                                switch ($sewa->duration) {
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
                                                }
                                            @endphp
                                            {{ $durationText }}
                                        </span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-sm text-gray-600">Total Harga:</span>
                                        <span
                                            class="text-sm text-gray-900">Rp {{ number_format($sewa->price, 0, ',', '.') }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-sm text-gray-600">Tanggal Mulai:</span>
                                        <span
                                            class="text-sm text-gray-900">{{ \Carbon\Carbon::parse($sewa->start_date)->format('d M Y') }}</span>
                                    </div>
                                </div>

                                @if ($sewa->status === 'approved' && !$sewa->payment_proof)
                                    <div class="mt-6">
                                        <!-- Teks "Segera lakukan pembayaran" -->
                                        <div class="mb-4 p-4 bg-yellow-50 border-l-4 border-yellow-400 text-yellow-700">
                                            <p class="text-sm"><strong>Segera Lakukan Pembayaran</strong></p>
                                        </div>

                                        <!-- Tombol "Unggah Bukti Pembayaran" -->
                                        <a href="{{ route('sewa.upload', $sewa->id) }}" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                                            Unggah Bukti Pembayaran
                                        </a>
                                    </div>
                                @endif

                                @if ($sewa->payment_proof && in_array($sewa->status, ['payment_verified', 'active', 'expired']))
                                    <div class="mt-6">
                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            Bukti Pembayaran
                                        </label>
                                        <div class="bg-gray-50 p-4 rounded-lg">
                                            @if (Str::endsWith($sewa->payment_proof, '.pdf'))
                                                <!-- Jika file PDF -->
                                                <div class="flex items-center space-x-2">
                                                    <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                                    </svg>
                                                    <a href="{{ asset('storage/' . $sewa->payment_proof) }}" target="_blank" class="text-sm text-green-600 hover:underline">
                                                        Lihat Bukti Pembayaran (PDF)
                                                    </a>
                                                </div>
                                            @else
                                                <div class="flex justify-center">
                                                    <a href="{{ asset('storage/' . $sewa->payment_proof) }}" target="_blank" download>
                                                        <img src="{{ asset('storage/' . $sewa->payment_proof) }}" alt="Bukti Pembayaran" class="max-w-[100px] max-h-[100px] w-20 h-25 object-cover rounded-lg hover:opacity-80 transition-opacity">
                                                    </a>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                                @if (in_array($sewa->status, ['active', 'expired']) && !$sewa->kost->reviews->where('tenant_id', Auth::id())->first())
                                    <div class="mt-6">
                                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Beri Review dan Rating</h3>
                                        <form action="{{ route('review.store') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="kost_id" value="{{ $sewa->kost->id }}">
                                            <input type="hidden" name="sewa_id" value="{{ $sewa->id }}">

                                            <div class="mb-4">
                                                <label for="rating" class="block text-sm font-medium text-gray-700">Rating</label>
                                                <select name="rating" id="rating" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                                                    <option value="1">1 - Sangat Buruk</option>
                                                    <option value="2">2 - Buruk</option>
                                                    <option value="3">3 - Cukup</option>
                                                    <option value="4">4 - Baik</option>
                                                    <option value="5">5 - Sangat Baik</option>
                                                </select>
                                            </div>

                                            <div class="mb-4">
                                                <label for="review" class="block text-sm font-medium text-gray-700">Review</label>
                                                <textarea name="review" id="review" rows="3" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required></textarea>
                                            </div>

                                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                                                Kirim Review
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
