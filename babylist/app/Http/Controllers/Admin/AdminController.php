<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function adminCheck(Request $r) {


        if($r->user() && $r->user()->role == 'admin'){
            return redirect('/scrape');
        } else {
            return view ('welcome');
        }

    }
}
