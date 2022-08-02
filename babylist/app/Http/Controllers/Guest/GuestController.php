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
        return view('guest.access');
    }
    // Login to a wishlist with given private code (Visitor section)
    public function accessList(Request $request) {


        try {
            $code = $request->code;
            $codeWishlist = Wishlist::where('code',$code)->first();
            try {
                $wishListid = $codeWishlist->id;
            }
            catch (ModelNotFoundException $exception) {
                report($exception);
                return back()->withError($exception->getMessage())->withInput();
            }

        } catch (ModelNotFoundException $exception) {
            report($exception);
            return back()->withError($exception->getMessage())->withInput();
        }
        return redirect(route('detailList' , $wishListid));
    }
}
