<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
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
}
