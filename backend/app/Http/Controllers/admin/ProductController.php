<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    protected $directory = 'assets/uploads/product/';

    public function getProducts()
    {
        try {
            $products = Product::with('category')->orderBy('name', 'asc')->get();

            return response()->json([
                'products' => $products,
                'status' => 200,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Something went wrong!',
                'error' => $th->getMessage(),
            ], 500);
        }
    }

    public function getThumbnail($id)
    {
        $product = Product::find($id);
        $path = $this->directory . $product->thumbnail;

        if (File::exists($path)) {
            return response()->json([
                'thumbnail_url' => asset($path),
                'status' => 200,
            ]);
        }

        return response()->json([
            'message' => 'Thumbnail not found!',
            'status' => 404,
        ]);
    }

    public function store(Request $request)
    {
        try {
            $product = new Product();

            if ($request->hasFile('thumbnail')) {
                $file = $request->file('thumbnail');
                $filename = time() . '.' . $file->getClientOriginalName();
                $file->move($this->directory, $filename);
                $product->thumbnail = $filename;
            }

            if ($request->hasFile('gallery')) {
                $gallery = [];

                foreach ($request->file('gallery') as $file) {
                    $filename = time() . '.' . $file->getClientOriginalName();
                    $file->move($this->directory, $filename);
                    $gallery[] = $filename;
                }

                $product->gallery = json_encode($gallery);
            }

            $product->name = $request->name;
            $product->slug = Str::slug($request->name, '_');
            $product->category_id = $request->category_id;
            $product->description = $request->description;
            $product->price = $request->price;
            $product->discount = $request->discount ?? 0.00;
            $product->rating = 0;
            $product->save();

            return response()->json([
                'message' => 'Product created successfully!',
                'product' => $product,
            ], 201);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Something went wrong!',
                'error' => $th->getMessage(),
            ], 500);
        }
    }

    public function update(Request $request)
    {
        try {
            $product = Product::find($request->id);

            if ($request->hasFile('thumbnail')) {
                $path = $this->directory . $product->thumbnail;

                if (File::exists($path)) {
                    File::delete($path);
                }

                $file = $request->file('thumbnail');
                $filename = time() . '.' . $file->getClientOriginalName();
                $file->move($this->directory, $filename);
                $product->thumbnail = $filename;
            }

            if ($request->hasFile('gallery')) {
                $gallery = [];

                foreach ($request->file('gallery') as $file) {
                    $path = $this->directory . $file->getClientOriginalName();

                    if (File::exists($path)) {
                        File::delete($path);
                    }

                    $filename = time() . '.' . $file->getClientOriginalName();
                    $file->move($this->directory, $filename);
                    $gallery[] = $filename;
                }

                $product->gallery = json_encode($gallery);
            }

            $product->name = $request->name;
            $product->slug = Str::slug($request->name, '_');
            $product->category_id = $request->category_id;
            $product->description = $request->description;
            $product->price = $request->price;
            $product->discount = $request->discount ?? 0.00;
            $product->update();

            return response()->json([
                'message' => 'Product updated successfully!',
                'product' => $product,
                'status' => 201,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Something went wrong!',
                'error' => $th->getMessage(),
            ], 500);
        }
    }

    public function updateStatus(Request $request)
    {
        try {
            $product = Product::findOrFail($request->id);
            $product->status = $request->status;

            $product->update();

            return response()->json([
                'message' => 'Product status updated successfully!',
                'status' => 201,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Something went wrong!',
                'error' => $th->getMessage(),
            ], 500);
        }
    }
}
