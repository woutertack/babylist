<?php

namespace App\Http\Controllers\wishlist\articles;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AddArticles extends Controller
{
    public function addArticles(Request $r) {

            return view ('wishlist.add-articles');
    }
}
