<?php

namespace App\Http\Controllers\wishlist\delete;

use App\Http\Controllers\Controller;
use App\Models\WishList;
use App\Models\WishlistArticle;
use Illuminate\Http\Request;

class DeleteListController extends Controller
{   // Delete the wishlist & All articles linked with that wishlist
    public function deleteList(Request $request) {
        $listId = $request->wishlist_id;

        WishlistArticle::where('wishlist_id', $listId)->delete();
        WishList::where('id' , $listId )->delete();

        return redirect(route('dashboard'));
    }
}
