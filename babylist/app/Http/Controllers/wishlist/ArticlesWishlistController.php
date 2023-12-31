<?php

namespace App\Http\Controllers\wishlist;

use App\Exports\WishlistExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\WishList;
use App\Models\WishlistArticle;
use Maatwebsite\Excel\Facades\Excel;

class ArticlesWishlistController extends Controller
{
    public function showListId(Request $request) {

        $listId = $request->id;
        $wishlist = WishList::where('id',$listId)->get();

        $WishlistArticles = WishlistArticle::where('wishlist_id', $listId)->get();
        return view('wishlist.articles', [
            'wishlist' => $wishlist,
            'WishlistArticles' => $WishlistArticles
        ]);}

        //articles that can be added to wishlist
        public function showArticleForm(Request $request) {
            $wishlistId = $request->id;
            if ($request->search) {
                $filter = $request->search;
                $articles = Article::where('title','LIKE','%' . $filter . '%')->paginate(25);
            } else {

                $articles = Article::paginate(25);
            }

            return view('wishlist.add-article', [
                 'articles'=> $articles,
                 'wishlistId' => $wishlistId
            ]);
        }



    // Add an article to the wishlist
    public function addArticle(Request $request) {

        $listId = $request->wishlist_id;
        $articleId = $request->article_id;

        $id = new WishlistArticle();
        $id->wishlist_id = $listId;
        $id->article_id = $articleId;
        $id->save();

        return redirect(route('listdetail' , $listId));
    }

    // Delete article from wishlist
    public function deleteListArticle(Request $request) {
        $listId = $request->wishlist_id;
        $articleId = $request->article_id;
        WishlistArticle::where('article_id',$articleId)->where('wishlist_id',$listId)->delete();
        return redirect(route('listdetail' , $listId));
    }

    //export a wishlist
    public function export() {
        return Excel::download(new WishlistExport, 'wishlist.xlsx');
    }
}
