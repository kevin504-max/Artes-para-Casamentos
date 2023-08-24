<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function getWishlist()
    {
        $wishlist = Wishlist::where('user_id', Auth::id())->with('product')->get();

        return response()->json([
            'wishlist' => $wishlist
        ]);
    }

    public function addProduct(Request $request)
    {
        if (!Product::find($request->product_id)) {
            return response()->json([
                'status' => 'error',
                'title' => 'Oops...',
                'message' => 'Produto não encontrado!'
            ]);
        }

        $wish = new Wishlist();
        $wish->user_id = Auth::id();
        $wish->product_id = $request->product_id;
        $wish->save();

        return response()->json([
            'status' => 'success',
            'title' => 'Sucesso!',
            'message' => 'Produto adicionado à lista de desejos!'
        ]);
    }

    public function removeProduct()
    {
        $existingWishlistItem = Wishlist::where('product_id', request()->product_id)->where('user_id', Auth::id())->first();

        if (!$existingWishlistItem) {
            return response()->json([
                'status' => 'error',
                'title' => 'Oops...',
                'message' => 'Produto não encontrado!'
            ]);
        }

        $existingWishlistItem->delete();

        return response()->json([
            'status' => 'success',
            'title' => 'Sucesso!',
            'message' => 'Produto removido da lista de desejos!'
        ]);
    }
}
