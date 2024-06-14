<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>CineMagic</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts AND CSS Fileds -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100 dark:bg-gray-800">

        <!-- Navigation Menu -->
        <nav class="bg-white dark:bg-gray-900 border-b border-gray-100 dark:border-gray-800">
            <!-- Navigation Menu Full Container -->
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <!-- Logo + Menu Items + Hamburger -->
                <div class="relative flex flex-col sm:flex-row px-6 sm:px-0 grow justify-between">
                    <!-- Logo -->
                    <div class="shrink-0 -ms-4">
                        <a href="{{ route('home.show') }}">
                            <div class="h-16 w-40 bg-cover bg-[url('../img/politecnico_h.svg')] dark:bg-[url('../img/politecnico_h_white.svg')]"></div>
                        </a>
                    </div>

                    <!-- Menu Items -->
                    <div id="menu-container" class="grow flex flex-col sm:flex-row items-stretch
                    invisible h-0 sm:visible sm:h-auto z-10">
                        <!-- Menu Item: Movies -->
                        <x-menus.menu-item
                            content="Movies"
                            href="{{ route('movies.index') }}"
                        />

                        <x-menus.menu-item
                        content="Screenings"
                        href="{{ route('screenings.index') }}"
                        />

                        @auth
                        <!-- Menu Item: Theaters -->
                        <x-menus.menu-item
                            content="Theaters"
                            selectable="1"
                            href="{{ route('theater.index') }}"
                            selected="{{ Route::currentRouteName() == 'theater.index'}}"
                            />

                        <!-- Menu Item: Administração -->
                        <x-menus.submenu
                            selectable="0"
                            uniqueName="submenu_others"
                            content="Administration">
                                @can('viewAny', App\Models\Student::class)
                                <x-menus.submenu-item
                                    content="Students"
                                    selectable="0"
                                    href="{{ route('students.index') }}" />
                                @endcan
                                <x-menus.submenu-item
                                    content="Genres"
                                    selectable="0"
                                    href="#" />
                                <x-menus.submenu-item
                                    content="Theaters"
                                    selectable="0"
                                    href="#"/>
                                <x-menus.submenu-item
                                    content="Customers"
                                    href="#"/>
                                <x-menus.submenu-item
                                    content="Movies"
                                    href="#"/>
                                <x-menus.submenu-item
                                    content="Purchases"
                                    href="#"/>
                                <x-menus.submenu-item
                                    content="Statistics"
                                    href="#"/>
                        </x-menus.submenu>
                        @endauth

                        <div class="grow"></div>

                        @auth
                        <x-menus.submenu
                            selectable="0"
                            uniqueName="submenu_user"
                            >
                            <x-slot:content>
                                <div class="pe-1">
                                    @if (Auth::user()->photo_filename)
                                      <img src="/storage/photos/{{ Auth::user()->photo_filename}}" class="w-11 h-11 min-w-11 min-h-11 rounded-full">
                                    @else
                                       <img src=" {{Vite::asset('resources/img/photos/default.png')}}" class="w-11 h-11 min-w-11 min-h-11 rounded-full">
                                    @endif
                                </div>
                                {{-- ATENÇÃO - ALTERAR FORMULA DE CALCULO DAS LARGURAS MÁXIMAS QUANDO O MENU FOR ALTERADO --}}
                                <div class="ps-1 sm:max-w-[calc(100vw-39rem)] md:max-w-[calc(100vw-41rem)] lg:max-w-[calc(100vw-46rem)] xl:max-w-[34rem] truncate">
                                    {{ Auth::user()->name }}
                                </div>
                            </x-slot>
                            <x-menus.submenu-item
                                content="User Management"
                                selectable="0"
                                href="{{ route('users.index') }}"/>
                            <x-menus.submenu-item
                                content="Profile"
                                selectable="0"
                                href="{{ route('profile.edit') }}"/>
                            <hr>
                            <form id="form_to_logout_from_menu" method="POST" action="{{ route('logout') }}" class="hidden">
                                @csrf
                            </form>
                            <a class="px-3 py-4 border-b-2 border-transparent
                                        text-sm font-medium leading-5 inline-flex h-auto
                                        text-gray-500 dark:text-gray-400
                                        hover:text-gray-700 dark:hover:text-gray-300
                                        hover:bg-gray-100 dark:hover:bg-gray-800
                                        focus:outline-none
                                        focus:text-gray-700 dark:focus:text-gray-300
                                        focus:bg-gray-100 dark:focus:bg-gray-800"
                                    href="#"
                                    onclick="event.preventDefault();
                                    document.getElementById('form_to_logout_from_menu').submit();">
                                Log Out
                            </a>
                        </x-menus.submenu>
                        @else
                        <!-- Menu Item: Login -->
                        <x-menus.menu-item
                            content="Login"
                            selectable="1"
                            href="{{ route('login') }}"
                            selected="{{ Route::currentRouteName() == 'login'}}"
                            />
                        @endauth
                    </div>
                    <!-- Hamburger -->
                    <div class="absolute right-0 top-0 flex sm:hidden pt-3 pe-3 text-black dark:text-gray-50">
                        <button id="hamburger_btn">
                            <svg class="h-8 w-8" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                <path id="hamburger_btn_open" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                                <path class="invisible" id="hamburger_btn_close" stroke-linecap="round"
                                stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Page Heading -->
        <header class="bg-white dark:bg-gray-900 shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <h4 class="mb-1 text-base text-gray-500 dark:text-gray-400 leading-tight">
                    Department of Computer Engineering
                </h4>
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    @yield('header-title')
                </h2>
            </div>
        </header>

        <main>
            <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
                @if (session('alert-msg'))
                    <x-alert type="{{ session('alert-type') ?? 'info' }}">
                        {!! session('alert-msg') !!}
                    </x-alert>
                @endif
                @if (!$errors->isEmpty())
                        <x-alert type="warning" message="Operation failed because there are validation errors!"/>
                @endif
                @yield('main')
            </div>
        </main>
    </div>
</body>

<!-- Footer -->
<footer class="bg-white dark:bg-gray-900 border-t border-gray-200 dark:border-gray-700 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col sm:flex-row justify-between items-center mb-6">
            <div class="text-sm text-gray-600 dark:text-gray-400">
                © 2024 CineMagic. All rights reserved.
            </div>
            <div class="flex mt-4 sm:mt-0">
                <a href="https://www.facebook.com" target="_blank" class="text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200 mx-2">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.879v-6.987H7.898V12h2.54V9.797c0-2.507 1.493-3.89 3.77-3.89 1.094 0 2.239.195 2.239.195v2.46h-1.261c-1.243 0-1.63.772-1.63 1.562V12h2.773l-.443 2.892h-2.33V21.88C18.343 21.128 22 16.99 22 12z"/>
                    </svg>
                </a>
                <a href="https://www.twitter.com" target="_blank" class="text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200 mx-2">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M23.954 4.569c-.885.392-1.83.656-2.825.775 1.014-.611 1.794-1.574 2.163-2.723-.95.564-2.005.974-3.127 1.195-.897-.959-2.178-1.559-3.594-1.559-2.717 0-4.92 2.203-4.92 4.917 0 .386.045.762.127 1.124C7.69 8.095 4.067 6.13 1.64 3.161c-.423.725-.666 1.562-.666 2.475 0 1.71.87 3.213 2.188 4.099-.807-.026-1.566-.248-2.23-.616v.061c0 2.385 1.697 4.374 3.946 4.827-.413.111-.85.171-1.296.171-.315 0-.623-.03-.923-.086.631 1.953 2.459 3.377 4.63 3.417-1.693 1.326-3.826 2.116-6.142 2.116-.399 0-.79-.023-1.175-.067 2.19 1.394 4.768 2.207 7.548 2.207 9.054 0 14-7.496 14-13.986 0-.213 0-.425-.015-.637.961-.695 1.8-1.562 2.46-2.549z"/>
                    </svg>
                </a>
                <a href="https://www.instagram.com" target="_blank" class="text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200 mx-2">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2.163c3.204 0 3.584.012 4.849.07 1.366.062 2.633.34 3.608 1.317.975.977 1.254 2.244 1.317 3.609.058 1.265.069 1.645.069 4.849 0 3.204-.012 3.584-.07 4.849-.062 1.366-.34 2.633-1.317 3.608-.977.975-2.244 1.254-3.609 1.317-1.265.058-1.645.069-4.849.069-3.204 0-3.584-.012-4.849-.07-1.366-.062-2.633-.34-3.609-1.317-.975-.975-1.254-2.244-1.317-3.609-.058-1.265-.069-1.645-.069-4.849 0-3.204.012-3.584.07-4.849.062-1.366.34-2.633 1.317-3.608.975-.975 2.244-1.254 3.609-1.317 1.265-.058 1.645-.069 4.849-.069zm0-2.163C8.736 0 8.332.015 7.052.073 5.623.135 4.283.436 3.116 1.603.943 3.776.646 5.961.573 7.917.512 9.197.5 9.602.5 12c0 2.398.012 2.803.073 4.083.073 1.956.37 4.141 2.543 6.314 2.173 2.173 4.358 2.47 6.314 2.543 1.28.061 1.684.073 4.083.073 2.398 0 2.803-.012 4.083-.073 1.956-.073 4.141-.37 6.314-2.543 2.173-2.173 2.47-4.358 2.543-6.314.061-1.28.073-1.684.073-4.083 0-2.398-.012-2.803-.073-4.083-.073-1.956-.37-4.141-2.543-6.314C16.141.437 13.956.14 12 .073 10.72.012 10.316 0 8.516 0z"/>
                        <path d="M12 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.162 6.162 6.162 6.162-2.759 6.162-6.162-2.759-6.162-6.162-6.162zm0 10.162c-2.21 0-4-1.79-4-4s1.79-4 4-4 4 1.79 4 4-1.79 4-4 4zm6.406-11.845a1.44 1.44 0 11-2.88 0 1.44 1.44 0 012.88 0z"/>
                    </svg>
                </a>
            </div>
        </div>
        <div class="text-sm text-gray-600 dark:text-gray-400 text-center mb-6">
            Contact us at: <a href="mailto:info@cinemagic.com" class="text-gray-800 dark:text-gray-200 hover:underline">info@cinemagic.com</a>
        </div>
        <div class="text-sm text-gray-600 dark:text-gray-400 text-center">
            Location: 1234 Cinema Lane, Movie City, Film State, 56789
        </div>
    </div>
</footer>


</html>
