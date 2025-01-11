<!-- resources/views/filament/forms/components/payment-instructions.blade.php -->
<div class="p-6 bg-gray-50 rounded-lg shadow-sm">
    <h3 class="text-xl font-semibold mb-4 text-gray-800">Instruksi Pembayaran</h3>
    <p class="mb-4 text-gray-600">Silakan selesaikan pembayaran Anda untuk mengaktifkan iklan:</p>

    <!-- Jumlah yang Harus Dibayar -->
    <div class="mb-6 p-4 bg-white rounded-lg shadow">
        <p class="text-lg font-medium text-gray-700">
            <strong>Jumlah yang Harus Dibayar:</strong>
            <span class="text-blue-600">Rp {{ number_format($this->data['price'], 0, ',', '.') }}</span>
        </p>
    </div>

    <!-- Daftar Metode Pembayaran -->
    <div class="mb-6 mt-3">
        <h4 class="text-lg font-medium mb-2 text-gray-800">Metode Pembayaran:</h4>
        <ul class="space-y-3">
            @foreach ($paymentMethods as $method)
                <li class="p-4 bg-white rounded-lg shadow">
                    <p class="text-gray-700">
                        <strong>{{ $method->paymentMethod->name }}</strong>
                    </p>
                    <p class="text-sm text-gray-600">No. Rekening: {{ $method->account_number }}</p>
                    <p class="text-sm text-gray-600">Atas Nama: {{ $method->account_name ?? 'Roomie' }}</p>
                </li>
            @endforeach
        </ul>
    </div>

    <!-- Catatan Penting -->
    <div class="mt-6 p-4 bg-yellow-50 rounded-lg border border-yellow-200">
        <p class="text-sm text-yellow-700">
            <strong>Catatan:</strong>
        </p>
        <ul class="list-disc list-inside text-sm text-yellow-700 space-y-1">
            <li>Setelah melakukan pembayaran, harap unggah bukti pembayaran di halaman detail iklan.</li>
            <li>Iklan Anda akan ditinjau dan diaktifkan setelah pembayaran diverifikasi.</li>
            <li>Jika Anda sudah melakukan pembayaran dan mengunggah bukti pembayaran, abaikan instruksi ini.</li>
        </ul>
    </div>
</div>
