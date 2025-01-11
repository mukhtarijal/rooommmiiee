<x-app-layout>
    <div class="min-h-screen bg-gray-50">
        <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
            <h1 class="text-2xl font-bold text-gray-900 mb-8">Pusat Bantuan</h1>

            @if ($helps->isEmpty())
                <div class="bg-white p-6 rounded-lg shadow-md text-center">
                    <p class="text-gray-600">Tidak ada data bantuan tersedia.</p>
                </div>
            @else
                <div class="space-y-4">
                    @foreach ($helps as $help)
                        <div class="bg-white rounded-lg shadow-md overflow-hidden">
                            <!-- Judul Bantuan -->
                            <button class="w-full text-left p-6 focus:outline-none" onclick="toggleDescription('{{ $help->id }}')">
                                <h2 class="text-xl font-semibold text-gray-900">{{ $help->title }}</h2>
                            </button>

                            <!-- Deskripsi Bantuan (Awalnya Disembunyikan) -->
                            <div id="description-{{ $help->id }}" class="hidden px-6 pb-6">
                                <p class="text-gray-700">{{ $help->description }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    <!-- JavaScript untuk Toggle Deskripsi -->
    <script>
        function toggleDescription(id) {
            const description = document.getElementById(`description-${id}`);
            description.classList.toggle('hidden');
        }
    </script>
</x-app-layout>
