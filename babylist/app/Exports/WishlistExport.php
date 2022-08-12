<?php

namespace App\Exports;

use App\Models\WishlistExporting;
use Maatwebsite\Excel\Concerns\FromCollection;

use App\Http\Controllers\Controller;
use App\Models\Wishlist;
use App\Models\WishlistArticle;
use Illuminate\Http\Request;

class WishlistExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return WishlistArticle::all();
    }

    //cant get a request in there
    // public function test(Request $request)
    // {
    //     $listId = $request->id;
    //     $wishlist = Wishlist::where('id',$listId)->get();

    //     $WishlistArticles = WishlistArticle::where('wishlist_id', $listId)->get();
    //     return $WishlistArticles;
    // }

}
