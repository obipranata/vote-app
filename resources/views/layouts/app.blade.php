<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Obito Voting App</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Live wire --->
        @livewireStyles

    </head>
    <body class="font-sans bg-gray-background text-gray-900 text-sm">
        <header class="flex flex-col md:flex-row items-center justify-between px-8 py-4">
            <a href="/"><img src="{{asset('img/logo.svg')}}" alt="logo"></a>
            <div class="flex items-center mt-2 md:mt-0">
                @if (Route::has('login'))
                    <div class="px-6 py-4">
                        @auth
                            <div class="flex item-center space-x-4">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
    
                                    <a href="{{route('logout')}}"
                                            onclick="event.preventDefault();
                                                        this.closest('form').submit();">
                                        {{ __('Log Out') }}
                                    </a>
                                </form>
                                <div x-data="{isOpen: false}" class="relative">
                                    <button @click="isOpen = !isOpen">
                                        <svg class="h-8 w-8 text-gray-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                                        </svg>
                                        <div class="absolute rounded-full bg-red text-white text-xxs w-6 h-6 flex justify-center items-center border-2 -top-1 -rigth-1">
                                            8
                                        </div>
                                    </button>
                                    <ul 
                                        x-cloak
                                        x-show.transition.origin.top="isOpen" 
                                        @click.away="isOpen=false" 
                                        @keydown.escape.window="isOpen = false"
                                        class="absolute w-76 md:w-96 text-left bg-white text-gray-700 text-sm shadow-dialog rounded-xl max-h-128 overflow-y-auto z-10 -right-28 md:-right-12"
                                        {{-- style="right:-46px" --}}
                                    >
                                            <li>
                                                <a 
                                                    href="#" 
                                                    @click.prevent="
                                                        isOpen=false
                                                        $dispatch('custom-show-edit-modal')
                                                    "
                                                    class="flex hover:bg-gray-100 transition duration-150 ease-in px-5 py-3"
                                                >
                                                    <img src="https://i.pravatar.cc/60?u=8" alt="avatar" class="w-10 h-10 rounded-xl">
                                                    <div class="ml-4">
                                                        <div class="line-clamp-6">
                                                            <span class="font-semibold">obipranata</span>
                                                            commented on
                                                            <span class="font-semibold">This is my idea</span>:
                                                            <span>"Lorem ipsum dolor sit amet consectetur adipisicing elit. Nam laboriosam quibusdam, perspiciatis labore amet accusantium modi nihil ipsum aliquid illo? Lorem ipsum dolor sit amet consectetur adipisicing elit. Veritatis accusamus obcaecati aliquid quae nulla consectetur.</span>
                                                        </div>
                                                        <div class="text-xs text-gray-500 mt-2">1 hour ago</div>
                                                    </div>
                                                </a>
                                            </li>

                                            <div class="border-t border-gray-300 text-center">
                                                <button
                                                    class="w-full block font-semibold hover:bg-gray-100 transition duration-150 ease-in px-5 py-4"
                                                >
                                                    Mark all as read
                                                </button>
                                            </div>
                                    </ul>
                                </div>
                            </div>
                        @else
                            <a href="{{ route('login') }}" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Log in</a>

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="ml-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Register</a>
                            @endif
                        @endauth
                    </div>
                @endif
                <a href="#">
                    <img src="https://i.pravatar.cc/60?u=4" alt="avatar" class="w-10 h-10 rounded-full">
                </a>
            </div>
        </header>

        <main class="container mx-auto max-w-custom flex flex-col md:flex-row">
            <div class="w-70 mx-auto md:mx-0 md:mr-5"> 
                <div 
                    class="bg-white md:sticky md:top-8 border-2 border-blue rounded-xl mt-16"
                    style="
                        border-image-source: linear-gradient(to bottom, rgba(50, 138, 241, 0.22), rgba(99, 123, 255, 0));
                        border-image-slice: 1;
                        background-image: linear-gradient(to bottom, #ffffff, #ffffff),
                        linear-gradient(to bottom, rgba(50, 138, 241, 0.22), rgba(99, 123, 255, 0));
                        background-origin:border-box;
                        background-clip:content-box, border-box;
                    "
                >
                    <div class="text-center px-6 py-2 pt-6">  
                        <h3 class="font-semibold text-base">Add an idea</h3>
                        <p class="text-xs mt-4">
                            @auth
                                Let us know what you would like and we'll take a look over!
                            @else
                                Please login to create an idea.
                            @endauth
                        </p>
                    </div>

                    @auth
                        {{-- @livewire('create-idea') --}}
                        <livewire:create-idea />
                    @else
                        <div class="my-6 text-center">
                            <a 
                                href="{{route('login')}}"
                                class="inline-block justify-center w-1/2 h-11 text-xs bg-blue text-white font-semibold rounded-xl border border-blue hover:bg-blue-hover transition duration-150 ease-in px-6 py-3"
                            >
                                Login
                            </a>
                            <a 
                                href="{{route('register')}}"
                                class="inline-block justify-center w-1/2 h-11 text-xs bg-gray-200 font-semibold rounded-xl border border-gray-200 hover:border-gray-400 transition duration-150 ease-in px-6 py-3 mt-4"
                            >
                                Sign Up
                            </a>
                        </div>
                    @endauth
                </div>
            </div>
            <div class="w-full px-2 md:px-0 md:w-175">
                <livewire:status-filters />
                <div class="mt-8">
                    {{$slot}}
                </div>
            </div>
        </main>

        @if (session('success_message'))
            <x-notification-success
                :redirect="true"
                message-to-display="{{session('success_message')}}"
            />
        @endif
        @livewireScripts
    </body>
</html>
