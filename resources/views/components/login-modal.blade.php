{{-- resources/views/components/login-modal.blade.php --}}

<x-modal name="login-modal" :show="false">
    <div class="p-6">
        <!-- Judul Modal -->
        <h2 class="text-lg font-semibold text-center">Pilih Jenis Login</h2>
        <p class="mt-4 text-center">Silakan pilih apakah Anda ingin login sebagai pencari kost atau pemilik kost.</p>

        <!-- Container untuk Tombol -->
        <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 gap-4">
            <!-- Tombol Login sebagai Pencari Kost -->
            <a href="/login" class="primary-bg text-white px-4 py-2 rounded-full hover:bg-[#2a8c4a] transition-colors text-center">
                Login sebagai Pencari Kost
            </a>

            <!-- Tombol Login sebagai Pemilik Kost -->
            <a href="/owner/login" class="primary-bg text-white px-4 py-2 rounded-full hover:bg-[#2a8c4a] transition-colors text-center">
                Login sebagai Pemilik Kost
            </a>
        </div>
    </div>
</x-modal>
