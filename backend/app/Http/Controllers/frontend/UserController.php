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

    public function viewOrder($id)
    {
        $order = Order::where('id', $id)->where('user_id', Auth::id())->first();

        return response()->json([
            'order' => $order
        ]);
    }
}
