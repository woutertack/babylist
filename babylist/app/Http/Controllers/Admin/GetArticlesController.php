<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;

class GetArticlesController extends Controller
{
    public function allArticles() {
        $articles = Article::paginate(25);
        return view('admin.scrape-result', [
             'articles'=> $articles,
        ]);
    }
}
