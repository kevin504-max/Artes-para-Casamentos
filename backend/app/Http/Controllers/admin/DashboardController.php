<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function getCategories()
    {
        return response()->json([
            'categories' => Category::all(),
        ], 200);
    }

    public function getProducts()
    {
        return response()->json([
            'products' => Product::all(),
        ], 200);
    }

    public function getOrders()
    {
        return response()->json([
            'orders' => Order::all(),
        ], 200);
    }

    public function getUsers()
    {
        return response()->json([
            'users' => User::all(),
        ], 200);
    }
}
