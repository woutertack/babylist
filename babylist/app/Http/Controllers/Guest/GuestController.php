<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class GuestController extends Controller
{
    // View access page
    public function show()  {
        return view('guest.access',['error'=>'']);
    }
    // Login to a wishlist with given private code (Visitor section)
    public function accessList(Request $request) {


        try {
            $code = $request->code;
            $codeWishlist = Wishlist::where('code',$code)->first();
           
                if($codeWishlist){
                    $wishListid = $codeWishlist->id;
                    return redirect(route('detailList' , $wishListid));
                } else {
                    return view('guest.access',['error'=>"Deze code bestaat niet, vul een geldige code in."]);
                }

        } catch (ModelNotFoundException $exception) {
            report($exception);
            return back()->withError($exception->getMessage())->withInput();
        }
        
    }
}
