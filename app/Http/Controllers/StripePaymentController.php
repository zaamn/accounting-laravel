<?php
   
namespace App\Http\Controllers;
   
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Stripe;
   
class StripePaymentController extends Controller
{
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function stripe()
    {
        return view('payment.payment');
    }
  
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function stripePost(Request $request)
    {
        return 'Ok';

        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        Stripe\Charge::create ([
                "amount" => 100 * $request->amount,
                "currency" => "usd",
                "source" => $request->stripeToken,
                "description" => "Test payment from BFIN." 
        ]);
  
        Session::flash('success', 'Payment successful!');
          
        return back();
    }
}