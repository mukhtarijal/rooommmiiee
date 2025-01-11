<x-app-layout>
    <div class="min-h-screen bg-gray-50">
        <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
            <h1 class="text-2xl font-bold text-gray-900 mb-8">Daftar Artikel</h1>

            @if ($articles->isEmpty())
                <div class="bg-white p-6 rounded-lg shadow-md text-center">
                    <p class="text-gray-600">Tidak ada artikel tersedia.</p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($articles as $article)
                        <a href="{{ route('articles.show', $article->slug) }}" class="block bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                            <!-- Foto Artikel -->
                            @if ($article->photo)
                                <img src="{{ asset('storage/' . $article->photo) }}" alt="{{ $article->title }}" class="w-full h-40 object-cover">
                            @else
                                <div class="w-full h-40 bg-gray-200 flex items-center justify-center">
                                    <span class="text-gray-500">Tidak ada foto</span>
                                </div>
                            @endif

                            <!-- Konten Card -->
                            <div class="p-4">
                                <h2 class="text-lg font-semibold text-gray-900 mb-2">{{ $article->title }}</h2>
                                <p class="text-xs text-gray-500 mb-2">{{ $article->created_at->format('d M Y') }}</p>
                                <div class="text-sm text-gray-700 line-clamp-3">
                                    {!! Str::limit(strip_tags($article->content), 100) !!}
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
