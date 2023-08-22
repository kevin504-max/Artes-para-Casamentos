<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function getSessionData($user_id)
    {
        $stripe = new \Stripe\StripeClient(env('STRIPE_API_KEY'));

        $cartItems = Cart::where('user_id', $user_id)->get();
        $products = [];

        foreach ($cartItems as $item) {
            $product = [
                'price_data' => [
                    'currency' => 'brl',
                    'unit_amount' => ($item->product->discount) ? ($item->product->price - $item->product->discount) * 100 : $item->product->price * 100,
                    'product_data' => [
                        'name' => $item->product->name,
                        'images' => [
                            asset('assets/uploads/product/' . $item->product->thumbnail),
                        ],
                    ]
                ],
                'quantity' => $item->items,
            ];

            array_push($products, $product);
        }

        $checkout = $stripe->checkout->sessions->create([
            'success_url' => 'http://localhost:8080/my-orders',
            'line_items' => [
                $products
            ],
            'mode' => 'payment',
        ]);

        return $checkout;
    }

    public function webhook(Request $request)
    {
        \Log::info("webhook");

        $endpoint_secret = env('webhook_key');

        $sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];
        $payload = @file_get_contents('php://input');

        try {
            $event = \Stripe\Webhook::constructEvent(
                $payload,
                $sig_header,
                $endpoint_secret,
            );
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            // Invalid signature
            echo '⚠️  Webhook error while validating signature.';
            http_response_code(400);
            exit();
        }

        if ($request->type == 'checkout.session.completed') {
            //validate the purchase
            \Log::info('its all done!');
        }

        return response()->json(["status" => "success"]);
    }
}
