<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function showcategory()
    {
        $category = Category::all();
        return response()->json(['category' => $category]);
    }

    // public function searchcategory($categorySearchTerm) {
    //     $category = Category::where('slug', $categorySearchTerm)->first();

    //     if ($category) {
    //         $products = $category->products()->get();

    //         return response()->json(['products' => $products]);
    //     } else {
    //         return response()->json(['message' => 'Category not found'], 404);
    //     }
    // }

    public function searchcategory($categorySearchTerm)
    {
        try {
            $category = Category::where('slug', $categorySearchTerm)->firstOrFail();

            // $category->load('products.category');

            $products = $category->products()->paginate(15);


            return response()->json(['products' => $products]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
            // return response()->json(['message' => 'Category not found'], 404);
            return $exception;
        }
    }
}
