<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function getOrders()
    {
        $orders = Order::where('status', 0)->orderBy('created_at', 'DESC')->get();

        return response()->json([
            'orders' => $orders
        ], 200);
    }

    public function viewOrder($orderId)
    {
        $order = Order::with('orderItems')->with('user')->find($orderId);

        foreach ($order->orderItems as $orderItem) {
            $orderItem->thumb = asset('assets/uploads/product/' . $orderItem->product->thumbnail);
        }

        return response()->json([
            'order' => $order
        ], 200);
    }

    public function history()
    {
        $orders = Order::where('status', 1)->orderBy('created_at', 'DESC')->get();

        return response()->json([
            'orders' => $orders
        ], 200);
    }
}
