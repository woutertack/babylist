@extends('layouts.layout')


@section('content')

<div class="flex flex-col max-w-xs m-auto sm:justify-center items-center pt-5 mt-10 sm:pt-0 rounded-3xl ">
        <div class="w-full sm:max-w-md px-6 py-4 bg-white shadow-md rounded-xl">
            <div class="flex items-center justify-center mt-4">
                <h2 class="font-bold text-lg">{{__('Give access code wishlist')}}</h2>
            </div>
            @if (session('error'))
                <div>{{ session('error') }}</div>
            @endif
            <form method="POST" action="{{ route('accessList')}}" class="py-10">
                @csrf
                <!-- Code Wishlist -->
                <div>
                    <label for="code" class="text-black">Code</label>
                    <x-input id="code" class="block mt-1 w-full  rounded-md drop-shadow-md"  type="text" name="code" required autofocus />
                </div>
                <div class="mt-4 flex justify-center">
                    <button type="submit" class="py-2 px-4 mt-8 bg-indigo-600 hover:bg-indigo-700 focus:ring-indigo-500 focus:ring-offset-indigo-200 text-white w-full transition ease-in duration-200 text-center text-base font-semibold shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2  rounded-lg ">{{__('Next')}}</button>
                </div>
            </form>
        </div>
    </div>




@endsection
