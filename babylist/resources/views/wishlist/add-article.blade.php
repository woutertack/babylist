@extends('layouts.layout')


@section('content')



    <div class="flex justify-center">
        <div class="mb-3 xl:w-96 mt-3">
            <form method="get" >
                <input
                    name="search"
                    type="search"
                    class=" mt-1 w-full  flex justify-center rounded-md border-white-500"
                    id="exampleSearch"
                    placeholder="{{__('Search an article')}}">
            </form>
        </div>
    </div>

    <div class="flex flex-col max-w-xs m-auto sm:justify-center items-center  mt-7 sm:pt-0 rounded-3xl">
        @foreach ( $articles as $article )
        <div class="rounded overflow-hidden shadow-lg mb-4">
            <img class="w-full h-100 object-contain" src="{{$article->src}}" alt="{{$article->title}}">
            <div class="flex justify-center pt-2">
              <div class="font-bold text-sm ">{{$article->title}}</div>

            </div>
              
            <div class="px-6 pt-4 pb-2 ">
              <span class=" flex justify-center  px-3  text-sm font-semibold text-gray-700 mr-2 mb-2">{{__('Price')}} {{$article->price}}</span>
             

              <form action="{{ route('addArticle' ,[$wishlistId, $article->id]) }}" class="flex justify-center" method="POST">
                @csrf
                <button type="submit" class="text-xs px-2 py-2 mb-2 flex justify-center bg-indigo-500 hover:bg-indigo-700 focus:ring-indigo-500 focus:ring-offset-indigo-200 text-white  transition ease-in duration-200 text-center font-semibold shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2  rounded-lg">{{__('Add to wishlist')}}</button>
                </form>

            </div>
        </div>
        @endforeach
        <div class="row">
            <div class="col-md-14 my-4">
                {{ $articles->links() }}
            </div>
        </div>
    </div>

@endsection
