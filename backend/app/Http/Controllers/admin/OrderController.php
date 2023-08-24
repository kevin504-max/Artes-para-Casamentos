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
        return response()->json([
            'order' => Order::find($orderId)
        ], 200);
    }
}
