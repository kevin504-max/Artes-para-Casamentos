<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CheckoutController extends Controller
{
    public function getSessionData($user_id)
    {
        $stripe = new \Stripe\StripeClient(env('STRIPE_API_KEY'));

        $cartItems = Cart::where('user_id', $user_id)->with('product')->get();

        foreach ($cartItems as $item) {
            $lineItems[] = [
                'price_data' => [
                    'currency' => 'brl',
                    'unit_amount' => ($item->product->discount) ? ($item->product->price - $item->product->discount) * 100 : $item->product->price * 100,
                    'product_data' => [
                        'name' => $item->product->name,
                        // 'images' => [asset('assets/uploads/product/' . $item->product->thumbnail)],
                    ]
                ],
                'quantity' => $item->items,
            ];
        }

        $checkout = $stripe->checkout->sessions->create([
            'success_url' => route('checkoutSuccess', [], true) . "?session_id={CHECKOUT_SESSION_ID}",
            'cancel_url' => route('checkoutCancel', [], true),
            'line_items' => $lineItems,
            'mode' => 'payment',
        ]);

        $existingOrder = Order::where('user_id', $user_id)->where('status', 0)->first();

        if (!$existingOrder) {
            $existingOrder = Order::create([
                'user_id' => $user_id,
                'total_price' => $checkout->amount_total / 100,
                'payment_mode' => 'stripe',
                'session_id' => $checkout->id,
                'tracking_number' => 'PAPA' . rand(10000, 99999),
            ]);

            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $existingOrder->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->items,
                    'price' => $item->product->discount
                        ? $item->product->price - $item->product->discount
                        : $item->product->price,
                    'message' => '',
                ]);
            }
        } else {
            $existingOrder->total_price = $checkout->amount_total / 100;
            $existingOrder->session_id = $checkout->id;
            $existingOrder->save();

            OrderItem::where('order_id', $existingOrder->id)->delete();

            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $existingOrder->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->items,
                    'price' => $item->product->discount
                        ? $item->product->price - $item->product->discount
                        : $item->product->price,
                    'message' => '',
                ]);
            }
        }

        return $checkout;
    }

    public function success(Request $request)
    {
        $stripe = new \Stripe\StripeClient(env('STRIPE_API_KEY'));
        $sessionId = $request->get('session_id');

        try {
            $session = $stripe->checkout->sessions->retrieve($sessionId);

            if (!$session) {
                throw new NotFoundHttpException;
            }

            $order = Order::where('session_id', $session->id)->first();

            if (!$order) {
                throw new NotFoundHttpException;
            }

            $order->status = 1;
            $order->save();

            $cartItems = Cart::where(
                'user_id', User::where('email', $session->customer_details->email)->first()->id
            )->with('product')->get();

            Cart::destroy($cartItems);

            return redirect()->away('http://localhost:8080/my-orders');
        } catch(\Exception $e) {
            echo "\n \n" . $e->getMessage();
            throw new NotFoundHttpException;
        }
    }

    public function cancel()
    {

    }

    public function webhook()
    {
        $endpoint_secret = env('WEBHOOK_SIGNING_SECRET');

        $payload = @file_get_contents('php://input');
        $sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];
        $event = null;

        try {
            $event = \Stripe\Webhook::constructEvent(
                $payload, $sig_header, $endpoint_secret
            );
        } catch(\UnexpectedValueException $e) {
            return response( content: '', status: 400 );
        } catch(\Stripe\Exception\SignatureVerificationException $e) {
            return response( content: '', status: 400 );
        }

        switch ($event->type) {
            case 'payment_intent.succeeded':
                $paymentIntent = $event->data->object;
            default:
                echo 'Received unknown event type ' . $event->type;
        }

        return response( content: '', status: 200 );
    }

    public function registerMessage(Request $request)
    {
        $order = Order::where('session_id', $request->input('request.sessionId'))->first();

        if (!$order) {
            return response()->json([
                'title' => 'Oops...',
                'message' => 'Pedido não encontrado!',
                'status' => 'error',
            ]);
        }

        if (strlen($request->input('request.message')) > 255) {
            return response()->json([
                'title' => 'Oops...',
                'message' => 'Por favor, escreva uma observação menor!',
                'status' => 'warning',
            ]);
        }

        $order->message = $request->input('request.message');
        $order->save();

        return response()->json([
            'title' => 'Sucesso!',
            'message' => 'Observação registrada com sucesso!',
            'status' => 'success',
        ]);
    }
}
