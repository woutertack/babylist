<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;

class AllArticlesController extends Controller
{
     // Show all articles (Admin section)
     public function allArticles() {
        $articles = Article::paginate(25);
        return view('admin.articles-overview', [
             'articles'=> $articles,
        ]);
    }

    public function deleteArticle($id) {
        
        $article = Article::findOrFail($id);
        $article->delete();
        
        return redirect()->back();
    }
}
