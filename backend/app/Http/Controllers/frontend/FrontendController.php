<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class FrontendController extends Controller
{
    public function index()
    {
        try {
            $featureds = Product::where('status', 1)->orderBy('discount', 'desc')->take(3)->get();
            $popular_categories = Category::where('status', 1)->where('popular', 1)->get();

            return response()->json([
                'featureds' => $featureds,
                'popular_categories' => $popular_categories,
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Something went wrong',
                'error' => $th->getMessage()
            ], 500);
        }
    }

    public function getImage($id)
    {
        $featured = Product::find($id);
        $path = 'assets/uploads/product/' . $featured->thumbnail;

        if (File::exists($path)) {
            return response()->json([
                'image_url' => asset($path),
                'status' => 200,
            ]);
        }

        return response()->json([
            'message' => 'Image not found!',
            'status' => 404,
        ]);
    }
}
