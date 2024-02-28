<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function searchProducts()
    {
        $searchTerm = request()->get('q') ?? null;
        $category = request()->get('category') ?? null;

        $products = Product::filter($searchTerm, $category)->paginate(15);

        if ($products->isEmpty()) {
            return response()->json(['message' => 'No products found'], 404);
        }

        return response()->json(['products' => $products]);
    }
}
