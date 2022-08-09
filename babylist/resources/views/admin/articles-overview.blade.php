@extends('layouts.layout')


@section('content')


<!-- All articles overview -->
<div class="flex flex-col max-w-xs m-auto sm:justify-center items-center pt-5 mt-10 sm:pt-0 rounded-3xl">
    @foreach ($articles as $article )
                <div>   
                    <div class="w-full sm:max-w-md px-6 py-4 mt-6 bg-gray-200 shadow-md sm:rounded-lg">
                       
                        <div class="flex items-center justify-start mt-2">
                            <h4 class="font-bold text-xl uppercase">{{$article->title}}</h4>
                        </div>
                        <div class="flex justify-between mt-2">
                          
                            <div class="justify-start">
                                <p>{{__('Price')}}: €{{$article->price}} </p>
                              
                            </div>
                           
                            <div class="mr-5 w-20 h-15">
                                <img src="{{$article->src}}" alt="img">
                            </div>
                        </div>
                        <form action="{{ route('deleteArticle' , $article->id )}}" method="post">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-xs px-2 py-2 flex justify-center bg-indigo-500 hover:bg-indigo-700 focus:ring-indigo-500 focus:ring-offset-indigo-200 text-white  transition ease-in duration-200 text-center font-semibold shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2  rounded-lg">{{__('Delete')}}</button>
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
