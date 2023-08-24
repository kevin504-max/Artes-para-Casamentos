<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function getOrders()
    {
        $orders = Order::where('user_id', Auth::id())->get();

        return response()->json([
            'orders' => $orders
        ]);
    }

    public function viewOrder($tracking_number)
    {
        $order = Order::where('tracking_number', $tracking_number)
            ->where('user_id', Auth::id())->with('orderItems')->with('user')->first();

        foreach ($order->orderItems as $orderItem) {
            $orderItem->thumb = asset('assets/uploads/product/' . $orderItem->product->thumbnail);
        }

        return response()->json([
            'order' => $order
        ]);
    }
}
