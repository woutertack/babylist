@extends('layouts.layout')


@section('content')

<div class="flex flex-col max-w-xs m-auto sm:justify-center items-center pt-5 mt-10 sm:pt-0 rounded-3xl">
    <a href="{{ route('scraper')}}" class="text-xs  py-2 px-4  bg-white hover:bg-indigo-700 hover:text-white focus:ring-indigo-500 focus:ring-offset-indigo-200 text-indigo-600 w-full transition ease-in duration-200 text-center font-semibold shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2  rounded-lg ">{{__('Go back')}}</a>
                    @foreach ($articles as $article )
                    <div class="w-full sm:max-w-md px-6 py-4 mt-6 bg-gray-200 shadow-md sm:rounded-lg">
                        <!-- Titel Article -->
                        <div class="flex items-center justify-start mt-2">
                            <h4 class="font-bold text-xl uppercase">{{$article->title}}</h4>
                        </div>
                        <div class="flex justify-between mt-2">
                            <!-- Info wenslijst-->
                            <div class="justify-start">
                                <p>{{__('Price')}}:€ {{$article->price}} </p>
                               

                            </div>
                            <!-- Image wenslijst-->
                            <div class="mr-5 w-20 h-15">
                                <img src="{{$article->image}}" alt="img">
                            </div>
                        </div>
                        
                    </div>
                    @endforeach
                </div>
@endsection



