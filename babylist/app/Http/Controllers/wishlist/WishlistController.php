<?php

namespace App\Http\Controllers\wishlist;

use App\Http\Controllers\Controller;
use App\Models\WishList;
use App\Models\WishlistArticle;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    //create a wishlist
    public function showListForm() {
        return view('wishlist.make-list');
    }

    //show wishlists for visitor
    public function showWishlist(){
        $client = auth()->user()->id;

        $wishlists = WishList::where('user_id',$client)->get();
        return view('wishlist.overview' , [
            'wishlists' => $wishlists
        ]);
    }

    //delete a wishlist
    public function deleteList(Request $request) {
        $listId = $request->wishlist_id;

        WishlistArticle::where('wishlist_id', $listId)->delete();
        WishList::where('id' , $listId )->delete();

        return redirect(route('overview'));
    }
}
