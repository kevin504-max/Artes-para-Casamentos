<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function getSessionData()
    {
        $stripe = new \Stripe\StripeClient(env('STRIPE_API_KEY'));

        $checkout = $stripe->checkout->sessions->create([
            'success_url' => 'http://localhost:8080/checkout-success',
            'line_items' => [
                [
                    'price_data' => [
                        'currency' => 'brl',
                        'unit_amount' => 500,
                        'product_data' => [
                            'name' => "Cool stripe checkout",
                            'images' => ["https://i.imgur.com/EHyR2nP.png"],
                        ]
                    ],
                    'quantity' => 1,
                ],
            ],
            'mode' => 'payment',
        ]);

        return $checkout;
    }
}
