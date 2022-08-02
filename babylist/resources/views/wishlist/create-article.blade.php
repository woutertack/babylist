@extends('layouts.layout')


@section('content')



    <div class="flex justify-center">
        <div class="mb-3 xl:w-96 mt-3">
            <form method="get" >
                <input
                    name="search"
                    type="search"
                    class="form-control block w-full px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid
                    border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                    id="exampleSearch"
                    placeholder="{{__('Search an article')}}">
            </form>
        </div>
    </div>

    <div class="p-10 grid grid-cols-2 sm:grid-cols-1 md:grid-cols-5 lg:grid-cols-5 xl:grid-cols-5 gap-5">
        @foreach ( $articles as $article )
        <div class="rounded overflow-hidden shadow-lg">
            <img class="w-full h-100 object-contain" src="{{$article->src}}" alt="{{$article->title}}">
            <div class="flex justify-center pt-2">
              <div class="font-bold text-sm ">{{$article->title}}</div>
              {{--<details class="text-gray-700 text-base">
                  <summary>Beschrijving</summary>
                  {{$article->description}}
              </details>--}}
            </div>
            <div class="px-6 pt-4 pb-2 ">
              <span class="inline-block flex justify-center  px-3  text-sm font-semibold text-gray-700 mr-2 mb-2">{{__('Price')}} {{$article->price}}</span>
              {{--<span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2">Categorie: {{$article->category->title}}</span>--}}

              <form action="{{ route('addArticle' ,[$wishlistId, $article->id]) }}" method="POST">
                @csrf
                <button type="submit" class="text-xs px-2 py-2 flex justify-center bg-indigo-500 hover:bg-indigo-700 focus:ring-indigo-500 focus:ring-offset-indigo-200 text-white  transition ease-in duration-200 text-center font-semibold shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2  rounded-lg">{{__('Add to wishlist')}}</button>
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
