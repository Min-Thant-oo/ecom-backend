<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function addToFavourite(Request $request) {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'product_id' => 'required|exists:products,id',
        ]);

        // Ensure the user is authenticated
        if (!$request->user()) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }

        $user = $request->user();
        $product_id = $request->product_id;


        // Check if the user already has this product in favourites
        if (!$user->products()->where('product_id', $product_id)->exists()) {
            // If not, attach the product to the user's favourites
            $user->products()->attach($product_id, ['created_at' => now(), 'updated_at' => now()]);
            return response()->json(['message' => 'Product added to favourites successfully']);
        }

        // here indicating that the product is already in favourites
        return response()->json(['message' => 'Product already in favourites']);
    }

    public function getfavourite(Request $request) {

        // Ensure the user is authenticated
        if (!$request->user()) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }

        $userFavourites = $request->user()->products;
        return response()->json(['favourites' => $userFavourites]);
    }

    // public function getuserfavourite(Request $request) {
    //     $userFavourites = $request->user()->products;
    //     return response()->json(['userfavourites' => $userFavourites]);
    // }

    public function removefromfavourite(Request $request) {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'product_id' => 'required|exists:products,id',
        ]);

        // Ensure the user is authenticated
        if (!$request->user()) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }

        $user = $request->user();
        $product_id = $request->product_id;

        if ($user->products()->where('product_id', $product_id)->exists()) {
            // detach the product to the user's favourites
            $user->products()->detach($product_id);
            $userFavourites = $user->products;
            return response()->json(['message' => 'Product removed from favourites successfully']);
        }
        return response()->json(['message' => 'This product is not in your favourite list']);
    }

    public function moveFromFavouriteToCart(Request $request) {
        // if($request->user()->products()->where('product_id', ))
        return 'success';
    }

    public function removeallfromfavourite(Request $request) {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        // Ensure the user is authenticated
        if (!$request->user()) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }

        $user = $request->user();

        if ($user->products()->count() > 0) {
            $user->products()->detach();
            return response()->json(['message' => 'All products have been removed from favourites successfully']);
        }

        return response()->json(['message' => 'No products in your favourites']);
    }
}
