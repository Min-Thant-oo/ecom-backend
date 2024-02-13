<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    

    public function showproduct() {
        $products = Product::with('category')->latest()->paginate(15);

        return response()->json(['products' => $products]);
    }

    public function eachproduct($id, Request $request) {

        $product = Product::find($id);

        if(!$product) {
            return response()->json(['message' => 'There is no product with this id'], 404);
        }

        return response()->json(['product' => $product]);
    }

    public function addtocart(Request $request, $id) {
        if (Auth::id()) {
            $user_id = Auth::id();
            // Perform actions that require authentication, e.g., adding to the cart
            return $user_id;
        } else {
            // User is not authenticated
            return response()->json(['error' => 'User is not authenticated'], 401);
        }
    }
    
}
