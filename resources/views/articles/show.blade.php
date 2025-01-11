<x-app-layout>
    <div class="min-h-screen bg-gray-50">
        <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
            <a href="{{ route('articles.index') }}" class="text-sm text-blue-600 hover:underline mb-4 inline-block">
                &larr; Kembali ke Daftar Artikel
            </a>

            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <!-- Foto Artikel -->
                @if ($article->photo)
                    <img src="{{ asset('storage/' . $article->photo) }}" alt="{{ $article->title }}" class="w-full h-64 object-cover">
                @else
                    <div class="w-full h-64 bg-gray-200 flex items-center justify-center">
                        <span class="text-gray-500">Tidak ada foto</span>
                    </div>
                @endif

                <!-- Konten Artikel -->
                <div class="p-6">
                    <h1 class="text-2xl font-bold text-gray-900 mb-4">{{ $article->title }}</h1>
                    <p class="text-sm text-gray-500 mb-4">{{ $article->created_at->format('d M Y') }}</p>
                    <div class="text-gray-700 prose">
                        {!! $article->content !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
