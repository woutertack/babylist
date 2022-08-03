@extends('layouts.layout')


@section('content')





<div class="flex flex-col max-w-xs m-auto sm:justify-center items-center pt-5 mt-10 sm:pt-0 rounded-3xl ">
        <div class="w-full sm:max-w-md px-6 py-2 bg-white shadow-md rounded-xl">
            <div class="flex items-center justify-center mt-4">
                <h2 class="font-bold text-2xl ">{{__('Your wishlist')}}</h2>
            </div>

            <div class=" flex justify-end">
                <a href=" {{ route('make-list')}}" class="py-2 px-4 mt-8 mb-3 bg-indigo-600 hover:bg-indigo-700 focus:ring-indigo-500 focus:ring-offset-indigo-200 text-white w-full transition ease-in duration-200 text-center text-base font-semibold shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2  rounded-lg  "> {{__('Make new wishlist')}}</a>
            </div>
            @foreach ($wishlists as $wishlist )
            <div class="flex flex-col sm:justify-center items-center pt-6 mt-5 mb-5 rounded-xl">
                <div class="w-full sm:max-w-md px-6 py-4 bg-indigo-100 shadow-md rounded-xl">
                    <!-- Titel wenslijst -->
                    <div class="flex items-center justify-between mt-2">
                        <h4 class="font-bold text-xl uppercase">{{ $wishlist->name }}</h4>
                        <form action="{{ route('deleteList' , $wishlist->id) }}" method="POST">
                            @csrf
                            @method("delete")
                            <button type="submit" class="pr-3  text-xl">X</button>
                        </form>
                    </div>
                    <div class="flex justify-between mt-2">
                        <!-- Info wenslijst-->
                        <div class="justify-start">
                            <p>Baby: {{ $wishlist->babyName }}</p>
                            <p>Code: {{$wishlist->code}}
                        </div>
                    </div>
                    <div class="mt-5 mb-2">
                        <a href="{{ route('listdetail' ,$wishlist->id)}}" class="text-xs m-5 py-2 px-4 mt-8 bg-indigo-500 hover:bg-indigo-700 focus:ring-indigo-500 focus:ring-offset-indigo-200 text-white w-full transition ease-in duration-200 text-center font-semibold shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2  rounded-lg ">{{__('Watch or change articles')}}</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
@endsection