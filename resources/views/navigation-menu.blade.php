<nav x-data="{ open: false }" class="bg-white border-gray-200 dark:bg-gray-900">
    <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
        <a href="{{ route('dashboard') }}" class="flex items-center">
            <img src="{{ Storage::url('logo.png') }}" class="h-8 mr-3" alt="Flowbite Logo" />
            <span class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white">
                {{ config('app.name', 'Laravel') }}
            </span>
        </a>
        <div class="flex items-center md:order-2">
            <button type="button"
                class="flex mr-3 text-sm bg-gray-800 rounded-full md:mr-0 focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600"
                id="user-menu-button" aria-expanded="false" data-dropdown-toggle="user-dropdown"
                data-dropdown-placement="bottom">
                <span class="sr-only">Open user menu</span>
                <img class="w-8 h-8 rounded-full" src="{{ Auth::user()->profile_photo_url }}"
                    alt="{{ Auth::user()->name }}">
            </button>
            <!-- Dropdown menu -->
            <div class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded-lg shadow dark:bg-gray-700 dark:divide-gray-600"
                id="user-dropdown">
                <div class="px-4 py-3">
                    <span class="block text-sm text-gray-900 dark:text-white">{{ Auth::user()->name }}</span>
                    <span
                        class="block text-sm  text-gray-500 truncate dark:text-gray-400">{{ Auth::user()->email }}</span>
                </div>
                <ul class="py-2" aria-labelledby="user-menu-button">
                    <li>
                        <a href="{{ route('profile.show') }}"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">
                            {{ __('Profile') }}
                        </a>
                    </li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}" x-data>
                            @csrf

                            <a href="{{ route('logout') }}"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white"
                                @click.prevent="$root.submit();">
                                {{ __('Log Out') }}
                            </a>
                        </form>
                    </li>
                </ul>
            </div>
            <button data-collapse-toggle="mobile-menu-2" type="button"
                class="inline-flex items-center p-2 ml-1 text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
                aria-controls="mobile-menu-2" aria-expanded="false">
                <span class="sr-only">Open main menu</span>
                <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd"
                        d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                        clip-rule="evenodd"></path>
                </svg>
            </button>
        </div>
        <div class="items-center justify-between hidden w-full md:flex md:w-auto md:order-1" id="mobile-menu-2">
            <ul
                class="flex flex-col font-medium p-4 md:p-0 mt-4 border border-gray-100 rounded-lg bg-gray-50 md:flex-row md:space-x-8 md:mt-0 md:border-0 md:bg-white dark:bg-gray-800 md:dark:bg-gray-900 dark:border-gray-700">
                <li>
                    <x-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                </li>
                <li>
                    <x-nav-link href="{{ route('page.user') }}" :active="request()->routeIs('page.user')">
                        {{ __('User') }}
                    </x-nav-link>
                </li>
                <li>
                    <x-nav-link href="{{ route('page.department') }}" :active="request()->routeIs('page.department')">
                        {{ __('Department') }}
                    </x-nav-link>
                </li>
                <li>
                    <x-nav-link href="{{ route('page.category') }}" :active="request()->routeIs('page.category')">
                        {{ __('Category') }}
                    </x-nav-link>
                </li>
                <li>
                    <x-nav-link href="{{ route('page.area') }}" :active="request()->routeIs('page.area')">
                        {{ __('Area') }}
                    </x-nav-link>
                </li>
                <li>
                    <x-nav-link href="{{ route('page.level') }}" :active="request()->routeIs('page.level')">
                        {{ __('Level') }}
                    </x-nav-link>
                </li>
                <li>
                    <x-nav-link href="{{ route('page.sublevel') }}" :active="request()->routeIs('page.sublevel')">
                        {{ __('Sublevel') }}
                    </x-nav-link>
                </li>
                <li>
                    <x-nav-link href="{{ route('page.school') }}" :active="request()->routeIs('page.school')">
                        {{ __('School') }}
                    </x-nav-link>
                </li>
            </ul>
        </div>
    </div>
</nav>
