@extends('layouts.layout')


@section('content')
<div class="main bg-white-800 ">
    <div class="grid place-items-center ">
        @auth
       <h1 class=" text-4xl text-cyan-600 pt-14"> {{__('Welcome')}} {{auth()->user()->firstname}}</h1>
       @else
       <h1 class=" text-4xl text-cyan-600 pt-14"> {{__('Welcome')}}</h1>
       @endauth
            <span class="text-cyan-600">______________________________________________</span>
        <h3 class="text-lg text-cyan-600 pt-3">{{__('The best site to create wishlists for babies!')}}</h3>

        <div class="flex justify-between mt-5 ">
            <a href="{{ route('overview') }}" class=" bg-slate-500rounded-2xl pr-5">
                <img src="/img/list.jpg" class=" rounded-t-2xl object-contain h-28 w-13">
                <p class="rounded-b-2xl text-sm p-2 border-2 border-t-0 border-cyan-600  text-cyan-600">{{__('Make your babylist here!')}}</p>
            </a>

            <a href="{{ route('buyList') }}" class=" bg-slate-500rounded-2xl   ">
                <img src="/img/buy-from-list.webp" class="rounded-t-2xl object-contain h-28 w-13 ">
                <p class="rounded-b-2xl text-sm p-2 border-2 border-t-0 border-cyan-600 text-cyan-600">{{__('Buy gifts!')}}</p>
            </a>
        </div>
    </div>

</div>



@endsection
