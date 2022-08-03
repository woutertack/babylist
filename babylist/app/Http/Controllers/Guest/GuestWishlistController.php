<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Wishlist;
use App\Models\WishlistArticle;
use Darryldecode\Cart\Facades\CartFacade as Cart;
use Illuminate\Http\Request;


class GuestWishlistController extends Controller
{
     // Get specific wishlist & all articles added to  wishlist
     public function guestListDetail(Request $request) {
        $listId = $request->id;
        $wishlist = Wishlist::where('id',$listId)->get();
        $WishlistArticles = WishlistArticle::where('wishlist_id', $listId)->get();
        
        $cart = Cart::session(1);
        return view('guest.guest-wishlist', [
            'wishlist' => $wishlist,
            'WishlistArticles' => $WishlistArticles,
            'cart' => $cart
        ]);
    }
    
    // Add article to the cart
    public function addShopingCart(Request $request) {
        $article = Article::findOrFail($request->article);
        
        Cart::session(1)->add(array(
            'id' => $article->id,
            'name' => $article->title,
            'price' =>  12,
            'quantity' => 1,
            'attributes' => array(),
            'associatedModel' => $article
        ));

        return redirect()->back();
    }
}

//price is default 12€ because it only accepts float and my database price is a string