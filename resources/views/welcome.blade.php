{{-- resources/views/welcome.blade.php --}}

<x-app-layout>

    <!-- Hero Section -->
    @include('partials.hero')

    <!-- Daftar Kos dengan Swiper -->
    @include('partials.kost-list', ['kosts' => $kosts, 'title' => $title, 'list' => $list])

    <!-- Tentang Kami Section -->
    @include('partials.about')

</x-app-layout>
