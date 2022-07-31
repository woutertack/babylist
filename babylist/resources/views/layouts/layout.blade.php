<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Babylist</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
    
    </head>
    <body class="min-h-screen bg-gray-100">
    <div class="header bg-lightblue  pl-10 flex justify-between pb-1 ">
            <a href="{{ url('/')}}">
                <img class="h-12 w-12 ml-2" src="/img/headerbaby.webp">
            </a>

            <h1 class="text-white pt-1 m-auto text-center font-serif text-xl ">Babygifts</h1>





            <div class="my-auto ">
            @if (Route::has('login'))
                <div class=" pr-3 ">
                    @auth
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <a href="{{ route('logout') }}" class="py-2 px-2  text-xs bg-white hover:bg-indigo-700 hover:text-white focus:ring-indigo-500 focus:ring-offset-indigo-200 text-indigo-500  transition ease-in duration-200 text-center shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2  rounded-lg"
                                    onclick="event.preventDefault();
                                    this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </a>
                        </form>
                        
                        @else
                        <a class="py-2 px-2  text-xs bg-white hover:bg-indigo-700 hover:text-white focus:ring-indigo-500 focus:ring-offset-indigo-200 text-indigo-500  transition ease-in duration-200 text-center shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2  rounded-lg" href="{{ route('login') }}">{{__('Login')}}</a>

                        @if (Route::has('register'))
                            <a class="py-2 px-2  text-xs bg-indigo-600 hover:bg-indigo-900 focus:ring-indigo-500 focus:ring-offset-indigo-200 text-white w-full transition ease-in duration-200 text-center font-semibold shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2  rounded-lg"href="{{ route('register') }}">{{__('Register')}}</a>
                        @endif
                    @endauth
                </div>
            @endif
            </div>
    </div>
    
        @yield('content')
        
        <!-- <div class="absolute bottom-0 w-screen">
                
                
                <footer class="h-12 m-auto pb-5 pt-3  text-xs text-center bg-lightblue ">© 2022 Copyright - Babylist - Wouter Tack</footer>
        </div> -->

    </body>
</html>
