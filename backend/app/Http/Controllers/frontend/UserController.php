<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function getUsers()
    {
        $users = User::all();

        return response()->json([
            'users' => $users
        ]);
    }

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
            ->where('user_id', Auth::id())->with('orderItems')->with('user')->orderBy('created_at', 'DESC')->first();

        foreach ($order->orderItems as $orderItem) {
            $orderItem->thumb = asset('assets/uploads/product/' . $orderItem->product->thumbnail);
        }

        return response()->json([
            'order' => $order
        ]);
    }
}
