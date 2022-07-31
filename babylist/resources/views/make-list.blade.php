@extends('layouts.layout')


@section('content')

<div class="flex flex-col max-w-xs m-auto sm:justify-center items-center pt-5 mt-10 sm:pt-0 rounded-2xl">
        <div class="w-full sm:max-w-md px-6 py-4 bg-white shadow-md border-2 sm:rounded-lg">
            <div class="flex items-center justify-center mt-4 pb-4">
                <h2 class="font-bold text-xl uppercase">{{__('New wishlist')}}</h2>
            </div>
            <form method="POST" action="{{ route('newListPOST') }}" class="py-10">
                @csrf
                <!-- Name wishlist -->
                <div>
                    <label for="name" class="text-black text-sm">{{__('Name wishlist')}}</label>

                    <x-input id="name" class="block mt-1 w-full rounded-md drop-shadow-md    "  type="text" name="name" :value="old('name')" required autofocus />
                </div>

                <!-- Baby name -->
                <div class="mt-4">
                    <label for="babyname" class="text-black text-sm">{{__('Name Baby')}}</label>

                    <x-input id="babyname" class="block mt-1 w-full  rounded-md drop-shadow-md"  type="text" name="babyname" :value="old('babyname')" required autofocus />
                </div>

                <div class="mt-4">
                    <label for="code" class="text-black text-sm">{{__('Secret code (to share with friends)')}}</label>

                    <x-input id="code" class="block mt-1 w-full  rounded-md drop-shadow-md"  type="password" name="code" :value="old('code')" required autofocus />
                </div>

                <div class="mt-4 flex justify-center">
                    <button type="submit" class="py-2 px-4 mt-8 bg-indigo-600 hover:bg-indigo-700 focus:ring-indigo-500 focus:ring-offset-indigo-200 text-white w-full transition ease-in duration-200 text-center text-base font-semibold shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2  rounded-lg ">
                        {{ __('Create') }}
                    </button>
                </div>
            </form>
        </div>
    </div>



@endsection