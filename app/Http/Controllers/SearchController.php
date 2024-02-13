<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    // public function searchbyword($searchTerm) {
    //     try {
    //         $products = Product::with('category')
    //         ->where('title', 'LIKE', '%' . $searchTerm . '%')
    //         ->get();
    
    //         return response()->json(['products' => $products]);
    //     } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
    //         return response()->json(['message' => 'Product not found'], 404);
    //         // return $exception;
    //     }
    // }

    // public function searchbyword($searchTerm) {
    //     $products = Product::with('category')
    //         ->where('title', 'LIKE', '%' . $searchTerm . '%')
    //         ->orWhere('description', 'LIKE', '%' . $searchTerm . '%')
    //         ->paginate();
    
    //     if ($products->isEmpty()) {
    //         return response()->json(['error' => 'No products found'], 404);
    //     }
    
    //     return response()->json(['products' => $products]);
    // }
    

    public function searchProducts($searchTerm = null, $categorySearchTerm = null) {
        $products = Product::filter($searchTerm, $categorySearchTerm)->paginate(15);

        if ($products->isEmpty()) {
            return response()->json(['message' => 'No products found'], 404);
        }

        return response()->json(['products' => $products]);
    }

    
    
}
