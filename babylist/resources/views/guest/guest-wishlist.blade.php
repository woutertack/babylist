@extends('layouts.layout')


@section('content')
@foreach ($wishlist as $wishlist )
    
    <div class="flex flex-col max-w-xs m-auto sm:justify-center items-center pt-5 pb-8 mt-10 sm:pt-0 rounded-3xl">
        <div class="w-full sm:max-w-md mb-5 px-6 py-4 bg-white shadow-md rounded-xl">
            <div class="row my-5">
                <div class="col-sm-6offset sm-3p-5bg-warning">
                <div class="flex items-center underline underline-offset-2 mb-5 mt-4">
                    <h2 class="font-bold text-xl uppercase">winkelmandje</h2>
                    <img src="/img/shoppingcart.png" class="w-8 h-7 ml-3">
                </div>
                    <ul class="list-group">
                        @foreach($cart->getContent() as $item)
                            <li class="list-group-item">
                                {{$item->name}}
                            €{{$item->price}}
                            </li>
                        @endforeach
                    </ul>
                    <h3 class="pt-3 uppercase text-black">Totaal: €{{$cart->getTotal()}}
                </div> 
                <form action="{{route('checkout')}}" method="get"> 
                    <input type="hidden" name="wishlist" value={{$wishlist->id}}>
                    <input type="text" class="" name="name" placeholder="naam" required>
                    <input type="text" class="" placeholder="Mededeling" name="remarks"><br>
                    <button type="submit" class="p-5 bg-black text-white">Pay</button> 
                </form>  
            </div>
        </div>
  


   
        <div class="flex justify-center">
            <div class="w-full sm:max-w-md px-6 py-4 bg-white shadow-md rounded-xl">
                <div class="flex items-center justify-center mt-4">
                    <h2 class="font-bold text-xl uppercase">{{__('Articles')}}</h2>
                </div>
                <div>
                    @foreach ($WishlistArticles as $article )
                    <div class="w-full sm:max-w-md px-6 py-4 mt-6 bg-gray-200 shadow-md sm:rounded-lg">
                        <!-- Titel Article -->
                        <div class="flex items-center justify-start mt-2">
                            <h4 class="font-bold text-base uppercase">{{$article->article->title}}</h4>
                        </div>
                        <div class="flex justify-between mt-2">
                            <!-- Info wenslijst-->
                            <div class="justify-start">
                                <p>Prijs: {{$article->article->price}} </p>
                              
                                <!-- <details>
                                    <summary>Beschrijving</summary>
                                    {{$article->article->description}}
                                </details> -->

                            </div>
                            <!-- Image wenslijst-->
                            <div class="mr-5 w-20 h-15">
                                <img src="{{$article->article->src}}" alt="IMG">
                            </div>
                        </div>
                        <form method="POST">
                            @csrf
                            <input type="hidden" name="article" value="{{$article->article->id}}">
                            <input type="hidden" name="wishlist" value="{{$wishlist->id}}">
                            <button type="submit" class="py-2 px-2  text-xs bg-white hover:bg-indigo-700 hover:text-white focus:ring-indigo-500 focus:ring-offset-indigo-200 text-indigo-500  transition ease-in duration-200 text-center shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2  rounded-lg">{{__('Buy article')}}</button>
                        </form>

                    </div>
                    @endforeach
                </div>

            </div>
        </div>    
    @endforeach
   



</div>














@endsection