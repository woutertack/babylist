<?php

namespace App\Http\Controllers\WishList\create;

use App\Http\Controllers\Controller;
use App\Models\WishList;
use Illuminate\Http\Request;

class CreateWishlistController extends Controller
{
    // Create a new wishlist when logged in
    public function newList(Request $request) {
        $wishlist = new WishList();
        $wishlist->name = $request->name;
        $wishlist->user_id = auth()->id();
        $wishlist->babyName = $request->babyname;
        $wishlist->code = $request->code;
        $wishlist->save();
        return redirect('/overview');
    }
}
