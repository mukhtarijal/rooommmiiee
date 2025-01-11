{{-- resources/views/welcome.blade.php --}}

<x-app-layout>
    {{--    <x-slot name="header">--}}
    {{--        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">--}}
    {{--            {{ __('Dashboard') }}--}}
    {{--        </h2>--}}
    {{--    </x-slot>--}}
    <!-- Hero Section -->
    @include('partials.hero')

    <!-- Section Kost Premium -->
    @include('partials.kost-list', [
        'kosts' => $premiumKosts,
        'title' => $premiumTitle,
        'list' => $premiumList,
    ])

    <!-- Section Kost di Sekitarmu -->
    @include('partials.kost-list', [
        'kosts' => $sameCityKosts,
        'title' => $sameCityTitle,
        'list' => $sameCityList,
    ])

    <!-- Section Kost Biasa -->
    @include('partials.kost-list', [
        'kosts' => $allKosts,
        'title' => $allTitle,
        'list' => $allList,
    ])

    <!-- Tentang Kami Section -->
    @include('partials.about')

    <!-- Fitur Section -->
    @include('partials.features')
</x-app-layout>
