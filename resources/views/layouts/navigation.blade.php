<nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700 sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <!-- Left Side -->
            <div class="flex items-center">
                <!-- Logo -->
                <div class="shrink-0">
                    <a href="{{ route('dashboard') }}" class="flex items-center">
                        <span class="text-2xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-green-400 to-blue-500">
                            Roomie
                        </span>
                    </a>
                </div>
            </div>

            <!-- Center/Right Navigation -->
            <div class="hidden sm:flex sm:items-center sm:ml-auto">
                <div class="flex space-x-8 items-center">
                    @auth
                        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')"
                                    class="text-sm font-medium transition-colors">
                            {{ __('Dashboard') }}
                        </x-nav-link>
                        <x-nav-link :href="route('kost.index')" :active="request()->routeIs('kost.index')"
                                    class="text-sm font-medium transition-colors">
                            {{ __('Cari Kos') }}
                        </x-nav-link>
                        <x-nav-link :href="route('sewa.index')" :active="request()->routeIs('sewa.index')"
                                    class="text-sm font-medium transition-colors">
                            {{ __('Riwayat Sewa') }}
                        </x-nav-link>
                        <x-nav-link :href="route('chat')" :active="request()->routeIs('chat')"
                                    class="text-sm font-medium transition-colors">
                            {{ __('Chat') }}
                        </x-nav-link>
                    @else
                        <x-nav-link :href="route('kost.index')" :active="request()->routeIs('kost.index')"
                                    class="text-sm font-medium transition-colors">
                            {{ __('Cari Kos') }}
                        </x-nav-link>
                    @endauth

                    <x-nav-link :href="route('help-center.index')" :active="request()->routeIs('help-center.index')"
                                class="text-sm font-medium transition-colors">
                        {{ __('Pusat Bantuan') }}
                    </x-nav-link>
                    <x-nav-link :href="route('articles.index')" :active="request()->routeIs('articles.index')"
                                class="text-sm font-medium transition-colors">
                        {{ __('Artikel') }}
                    </x-nav-link>

                    @guest
                        <button onclick="openLoginModal()"
                                class="inline-flex items-center px-4 py-2 border border-transparent rounded-md text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors">
                            Login
                        </button>
                    @endguest

                    @auth
                        <div class="ml-3 relative">
                            <x-dropdown align="right" width="48">
                                <x-slot name="trigger">
                                    <button class="inline-flex items-center px-3 py-2 border border-gray-200 rounded-md text-sm font-medium text-gray-700 bg-white hover:text-gray-900 focus:outline-none transition ease-in-out duration-150">
                                        <span class="mr-2">{{ Auth::user()->name }}</span>
                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </x-slot>

                                <x-slot name="content">
                                    <x-dropdown-link :href="route('profile.edit')" class="text-sm">
                                        {{ __('Profile') }}
                                    </x-dropdown-link>

                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <x-dropdown-link :href="route('logout')"
                                                         onclick="event.preventDefault(); this.closest('form').submit();"
                                                         class="text-sm">
                                            {{ __('Log Out') }}
                                        </x-dropdown-link>
                                    </form>
                                </x-slot>
                            </x-dropdown>
                        </div>
                    @endauth
                </div>
            </div>

            <!-- Mobile menu button -->
            <div class="flex items-center sm:hidden">
                <button @click="open = ! open"
                        class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex"
                              stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden"
                              stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            @auth
                <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')"
                                       class="block px-4 py-2 text-base font-medium">
                    {{ __('Dashboard') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('kost.index')" :active="request()->routeIs('kost.index')"
                                       class="block px-4 py-2 text-base font-medium">
                    {{ __('Cari Kos') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('sewa.index')" :active="request()->routeIs('sewa.index')"
                                       class="block px-4 py-2 text-base font-medium">
                    {{ __('Riwayat Sewa') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('chat')" :active="request()->routeIs('chat')"
                                       class="block px-4 py-2 text-base font-medium">
                    {{ __('Chat') }}
                </x-responsive-nav-link>
            @else
                <x-responsive-nav-link :href="route('kost.index')" :active="request()->routeIs('kost.index')"
                                       class="block px-4 py-2 text-base font-medium">
                    {{ __('Cari Kos') }}
                </x-responsive-nav-link>
            @endauth

            <x-responsive-nav-link :href="route('help-center.index')" :active="request()->routeIs('help-center.index')"
                                   class="block px-4 py-2 text-base font-medium">
                {{ __('Pusat Bantuan') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('articles.index')" :active="request()->routeIs('articles.index')"
                                   class="block px-4 py-2 text-base font-medium">
                {{ __('Artikel') }}
            </x-responsive-nav-link>

            @guest
                <div class="pt-4 pb-3 border-t border-gray-200">
                    <div class="mt-3 space-y-1">
                        <button onclick="openLoginModal()"
                                class="block w-full px-4 py-2 text-left text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">
                            Login
                        </button>
                    </div>
                </div>
            @endguest
        </div>

        @auth
            <div class="pt-4 pb-3 border-t border-gray-200">
                <div class="flex items-center px-4">
                    <div class="ml-3">
                        <div class="text-base font-medium text-gray-800">{{ Auth::user()->name }}</div>
                        <div class="text-sm font-medium text-gray-500">{{ Auth::user()->email }}</div>
                    </div>
                </div>

                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('profile.edit')"
                                           class="block px-4 py-2 text-base font-medium">
                        {{ __('Profile') }}
                    </x-responsive-nav-link>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-responsive-nav-link :href="route('logout')"
                                               onclick="event.preventDefault(); this.closest('form').submit();"
                                               class="block px-4 py-2 text-base font-medium">
                            {{ __('Log Out') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
            </div>
        @endauth
    </div>
</nav>
