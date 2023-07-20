<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    protected $directory = 'assets/uploads/category/';

    public function getCategories()
    {
        try {
            $categories = Category::where('status', 1)->orderBy('name', 'desc')->get();

            return response()->json([
                'categories' => $categories,
                'status' => 200,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Something went wrong!',
                'error' => $th->getMessage(),
            ], 500);
        }
    }

    public function getImage($id)
    {
        $category = Category::find($id);
        $path = $this->directory . $category->image;

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

    public function store(Request $request)
    {
        try {
            $category = new Category();

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $filename = time() . '.' . $file->getClientOriginalName();
                $file->move($this->directory, $filename);
                $category->image = $filename;
            }

            $category->name = $request->name;
            $category->slug = Str::slug($request->name, '_');
            $category->description = $request->description;
            $category->save();

            return response()->json([
                'message' => 'Category created successfully!',
                'category' => $category,
                'status' => 201,
            ]);
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
            $category = Category::findOrFail($request->id);

            if ($request->hasFile('image')) {
                $path = $this->directory . $category->image;

                if (File::exists($path)) {
                    File::delete($path);
                }

                $file = $request->file('image');
                $filename = time() . '.' . $file->getClientOriginalName();
                $file->move($this->directory, $filename);
                $category->image = $filename;
            }

            $category->name = $request->name;
            $category->slug = Str::slug($request->name, '_');
            $category->description = $request->description;
            $category->update();

            return response()->json([
                'message' => 'Category updated successfully!',
                'category' => $category,
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
            $category = Category::findOrFail($request->id);
            $category->status = $request->status;

            $category->update();

            return response()->json([
                'message' => 'Category status updated successfully!',
                'status' => 201,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Something went wrong!',
                'error' => $th->getMessage(),
            ], 500);
        }
    }

    public function destroy(Request $request)
    {
        try {
            $category = Category::findOrFail($request->id);

            if ($category->image) {
                $path = $this->directory . $category->image;

                if (File::exists($path)) {
                    File::delete($path);
                }
            }

            $category->delete();

            return response()->json([
                'message' => 'Category deleted successfully!',
                'status' => 200,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Something went wrong!',
                'error' => $th->getMessage(),
            ], 500);
        }
    }
}
