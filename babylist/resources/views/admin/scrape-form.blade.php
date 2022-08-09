@extends('layouts.layout')


@section('content')

    <div class="container">
        <div class="row flex justify-center">
            <div class="col-sm-8 offset-sm-2">
            <div class="mt-5 mb-2 flex justify-end">
                        <a href="{{ route('articles.overview')}}" class="text-xs  py-2 px-4  bg-white hover:bg-indigo-700 hover:text-white focus:ring-indigo-500 focus:ring-offset-indigo-200 text-indigo-600 w-full transition ease-in duration-200 text-center font-semibold shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2  rounded-lg ">{{__('See all articles')}}</a>
                </div>
                <h1 class="flex justify-center text-xl my-5">{{__('Scrape data here')}}</h1>
                
                <form action="{{ route('scrape.categories')}}" method="post">
                    @csrf
                    <div class="form-group">
                        <div>
                            <label for="shop" class="flex justify-center text-base pb-1">{{__('webshop')}}</label>
                        </div>
                        <div class="flex justify-center">
                            <select name="shop" id="shop" class="form-control text-base">
                                @foreach ($shops as $key => $shop)
                                    <option value="{{ $key }}" class="text-base ">
                                        {{ $shop}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group py-3">
                        <div>
                            <label for="url" class="flex justify-center text-base pb-1">
                                {{__('Collection')}} Url
                            </label>
                            <div class="flex justify-center">
                                <input required class="form-control text-sm" type="url" name="url" id="url" placeholder="e.g. http://bol.com/speelgoed">
                            </div>
                        </div>
                    </div>
                    <div class=" flex justify-center text-base mt-3">
                        <button type="submit" class="py-2 px-2  text-sm bg-indigo-600 hover:bg-indigo-900 focus:ring-indigo-500 focus:ring-offset-indigo-200 text-white w-full transition ease-in duration-200 text-center font-semibold shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2  rounded-lg">
                            {{__('Scrape categories')}}
                        </button>
                    </div>
                </form>



                <h2 class="mt-4 underline underline-offset-2 text-indigo-500">{{$shops['dreamBaby']}}</h2>
                <table class="table table-striped my-5">
                    @foreach ($dreamBabyCategories as $category)
                        <tr>
                            <td>{{ $category->title}}</td>
                            <td>
                                <form method="post" action="{{ route('scrape.articles') }}">
                                    @csrf
                                    <input type="hidden" name="url" value="{{ $category->url}}">
                                    <input type="hidden" name="shop" value="dreamBaby">
                                    <button type="submit" class="py-2 px-2  text-xs bg-white hover:bg-indigo-700 hover:text-white focus:ring-indigo-500 focus:ring-offset-indigo-200 text-indigo-500  transition ease-in duration-200 text-center shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2  rounded-lg">{{__('Scrape all articles')}}</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </table>
                <h2 class="mt-4 underline underline-offset-2 text-indigo-500">{{$shops['mimibaby']}}</h2>
                <table class="table table-striped my-5">
                    @foreach ($mimibabyCategories as $category)
                        <tr>
                            <td>{{ $category->title}}</td>
                            <td>
                                <form method="post" action="{{ route('scrape.articles') }}">
                                    @csrf
                                    <input type="hidden" name="url" value="{{ $category->url}}">
                                    <input type="hidden" name="shop" value="mimibaby">
                                    <button type="submit" class="py-2 px-2  text-xs bg-white hover:bg-indigo-700 hover:text-white focus:ring-indigo-500 focus:ring-offset-indigo-200 text-indigo-500  transition ease-in duration-200 text-center shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2  rounded-lg">{{__('Scrape all articles')}}</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </table>
            
                <h2 class="mt-4 underline underline-offset-2 text-indigo-500">{{$shops['littleMoustache']}}</h2>
                <table class="table table-striped my-5">
                    @foreach ($littleMoustacheCategories as $category)
                        <tr>
                            <td>{{ $category->title}}</td>
                            <td>
                                <form method="post" action="{{ route('scrape.articles') }}">
                                    @csrf
                                    <input type="hidden" name="url" value="{{ $category->url}}">
                                    <input type="hidden" name="shop" value="littleMoustache">
                                    <button type="submit" class="py-2 px-2  text-xs bg-white hover:bg-indigo-700 hover:text-white focus:ring-indigo-500 focus:ring-offset-indigo-200 text-indigo-500  transition ease-in duration-200 text-center shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2  rounded-lg">{{__('Scrape all articles')}}</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </table>


            </div>
        </div>
    </div>

@endsection
