<?php

namespace App\Http\Controllers\ShoppingCart;

use App\Http\Controllers\Controller;
use App\Mail\sendPaymentMail;
use App\Models\Order;
use Illuminate\Http\Request;

use Darryldecode\Cart\Facades\CartFacade as Cart;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Mollie\Laravel\Facades\Mollie;

class CheckoutController extends Controller
{
    public function checkout(Request $r) {
      
        $cart = Cart::session(1);
        
        $total = (string) $cart->getTotal();
        $total = number_format($total, 2);

        //create new order
        $order = new Order();
        $order->name = $r->name;
        $order->remarks = $r->remarks;
        $order->email = $r->email;
        $order->wishlist_id = $r->wishlist;
        $order->total = $total;
        $order->status = 'pending';
        
        //save order
        $order->save();

        //webhooklogic,  make accessable from online env
        $webhookUrl = route('webhooks.mollie');
        if (App::environment('local')){
            $webhookURL = 'https://57a2-2a02-1811-c41b-7200-80f8-6fe2-3286-7884.eu.ngrok.io/webhooks/mollie';
        };
        
        

        
        //create payment
        $payment = Mollie::api()->payments->create([
            "amount" => [
                "currency" => "EUR",
                "value" => $total // You must send the correct number of decimals, thus we enforce the use of strings
            ],
            "description" => "Bestelling op " . date('d-m-Y h:i'),
            "redirectUrl" => route('checkout.success'),
            "webhookUrl" => "https://57a2-2a02-1811-c41b-7200-80f8-6fe2-3286-7884.eu.ngrok.io/webhooks/mollie",
            "metadata" => [
                "order_id" => $order->id,
                "order_form" => $order->name
            ],
        ]);
    
     
        Mail::to($order->email)->send(new sendPaymentMail($order));

        // redirect customer to Mollie checkout page
        return redirect($payment->getCheckoutUrl(), 303);

    }

    public function success() {
        Cart::session(1)->clear();
        return redirect('/')->with('mssg', 'Bedankt voor je bestelling!');
    }


    
}
