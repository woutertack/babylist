@extends('layouts.layout')


@section('content')

   <!-- All articles overview -->
   <div class="container">
        <div class="row py-5">
            @foreach($articles as $article)
            <div class="col-sm-4 col-md-3 col-lg-2">

                <article>
                    <h5>{{ $article->title}}</h5>
                    <img src="https://static.dreambaby.be{{ $article->image}}" alt="img" class="img-fluid">
                    <p>{{$article->price}}</p>
                </article>

            </div>
            @endforeach
        </div>
    </div>

@endsection
