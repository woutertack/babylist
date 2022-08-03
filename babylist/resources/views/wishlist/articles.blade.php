@extends('layouts.layout')


@section('content')
<div class="flex flex-col max-w-xs m-auto sm:justify-center items-center pt-5 mt-10 sm:pt-0 rounded-3xl">
        @foreach ($wishlist as $wishlist )


            <div class="w-full sm:max-w-md px-6 py-4 bg-white shadow-md rounded-xl">
                <div class="flex items-center justify-center mt-4">
                    <h2 class="font-bold text-xl ">{{__('Your articles')}} </h2>
                </div>

                <div class="mt-4 flex justify-end">
                    <a href=" {{ route('newArticle' , $wishlist->id)}}" class="text-xs m-5 py-2 px-4 mt-8 bg-indigo-500 hover:bg-indigo-700 focus:ring-indigo-500 focus:ring-offset-indigo-200 text-white w-full transition ease-in duration-200 text-center font-semibold shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2  rounded-lg "> + Voeg een nieuw artikel toe</a>
                </div>

                <div>
                    @foreach ($WishlistArticles as $article )
                    <div class="w-full sm:max-w-md px-6 py-4 mt-6 bg-gray-200 shadow-md sm:rounded-lg">
                        <!-- Titel Article -->
                        <div class="flex items-center justify-start mt-2">
                            <h4 class="font-bold text-xl uppercase">{{$article->article->title}}</h4>
                        </div>
                        <div class="flex justify-between mt-2">
                            <!-- Info wenslijst-->
                            <div class="justify-start">
                                <p>Prijs: {{$article->article->price}} </p>
                              
                            </div>
                            <!-- Image wenslijst-->
                            <div class="mr-5 w-20 h-15">
                                <img src="{{$article->article->src}}" alt="img">
                            </div>
                        </div>
                        <!-- deletearticle -->
                        <form action="{{ route('deleteListArticle' ,[$wishlist->id , $article->article->id]) }}" method="POST">
                            @csrf
                            @method("delete")
                            <button type="submit" class="py-2 px-2  text-sm bg-white hover:bg-indigo-700 hover:text-white focus:ring-indigo-500 focus:ring-offset-indigo-200 text-indigo-500  transition ease-in duration-200 text-center shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2  rounded-lg">Delete</button>
                        </form>                
                    </div>
                    @endforeach
                </div>

            </div>
        @endforeach
    </div>



@endsection
