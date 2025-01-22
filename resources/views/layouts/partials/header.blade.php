<header class="fixed w-full">
    <nav class="bg-white border-gray-200 py-2.5 dark:bg-gray-900">
        <div class="flex flex-wrap items-center justify-between max-w-screen-xl px-4 mx-auto">
            <a href="#" class="flex items-center">
                <img src="{{ asset('images/logo.png') }}" class="h-6 mr-3 sm:h-9" alt="Landwind Logo" />
                <span
                    class="self-center text-xl font-semibold whitespace-nowrap dark:text-white">{{ config('app.name', '') }}</span>
            </a>
            <div class="items-center justify-between hidden w-full lg:flex lg:w-auto" id="mobile-menu-2">
                <div class="flex flex-col mt-4 font-medium lg:flex-row lg:space-x-8 lg:mt-0">
                    <x-nav-link href="{{ route('home') }}" :active="request()->routeIs('home')">
                        Home
                    </x-nav-link>
                    <x-nav-link href="{{ route('about') }}" :active="request()->routeIs('about')">
                        About
                    </x-nav-link>
                    <x-nav-link href="{{ route('lowongan.index') }}" :active="request()->routeIs('lowongan.index')">
                        Lowongan
                    </x-nav-link>
                </div>
            </div>
        </div>
    </nav>
</header>
