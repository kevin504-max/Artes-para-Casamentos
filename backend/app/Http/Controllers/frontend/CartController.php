<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function addProduct(Request $request)
    {
        $product = Product::find($request->product_id);

        if (!$product) {
            return response()->json([
                'status' => 'error',
                'title' => 'Oops...',
                'message' => 'Produto não encontrado!'
            ]);
        }

        $existingCartItem = Cart::where('product_id', $request->product_id)->where('user_id', $request->auth_id)->first();

        if ($existingCartItem) {
            return response()->json([
                'status' => 'info',
                'title' => 'Oops...',
                'message' => 'Produto já adicionado ao carrinho!'
            ]);
        }

        $cartItem = new Cart();
        $cartItem->user_id = $request->auth_id;
        $cartItem->product_id = $request->product_id;
        $cartItem->items = $request->quantity;
        $cartItem->save();

        return response()->json([
            'status' => 'success',
            'title' => 'Sucesso!',
            'message' => $product->name . ' adicionado ao carrinho!'
        ]);
    }

    public function viewCart()
    {
        $cartItems = Cart::where('user_id', Auth::id())->with('product')->get();

        foreach ($cartItems as $item) {
            $item->thumb_url = asset(
                'assets/uploads/product/' . $item->product->thumbnail
            );
        }

        return response()->json([
            'cartItems' => $cartItems
        ]);
    }

    public function updateCart(Request $request)
    {
        if(Cart::where('product_id', $request->input('request.product_id'))->where('user_id', Auth::id())->exists()) {
            $cart = Cart::where('product_id', $request->input('request.product_id'))->where('user_id', Auth::id())->first();
            $cart->items = $request->input('request.quantity');
            $cart->update();

            return response()->json([
                'status' => 'success',
                'title' => 'Sucesso!',
                'message' => 'Carrinho atualizado!'
            ]);
        }

        return response()->json([
            'status' => 'error',
            'title' => 'Oops...',
            'message' => 'Produto não encontrado!'
        ]);
    }

    public function removeProduct(Request $request)
    {
        $existingCartItem = Cart::where('product_id', $request->input('request.product_id'))->where('user_id', Auth::id())->first();

        if (!$existingCartItem) {
            return response()->json([
                'status' => 'error',
                'title' => 'Oops...',
                'message' => 'Produto não encontrado!'
            ]);
        }

        $existingCartItem->delete();
        return response()->json([
            'status' => 'success',
            'title' => 'Sucesso!',
            'message' => 'Produto removido do carrinho!'
        ]);
    }

    public function cartCount()
    {
        $cartCount = Cart::where('user_id', Auth::id())->count();

        return response()->json([
            'count' => $cartCount
        ]);
    }
}
