@extends('layouts.layout')


@section('content')

   <!-- All articles overview -->
   <div class="container">
        <div class="row py-5">
            @foreach($articles as $article)
            <div class="col-sm-4 col-md-3 col-lg-2 flex justify-center">

                <article class=" justify-center pb-3">
                    <h5>{{ $article->title}}</h5>
                    <img src="{{ $article->image}}" alt="img" class="img-fluid rounded-t-2xl object-contain h-28 w-13">
                    <p>{{$article->price}}</p>
                </article>

            </div>
            @endforeach
        </div>
    </div>

@endsection
