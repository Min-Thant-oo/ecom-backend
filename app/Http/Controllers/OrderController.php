<?php

namespace App\Http\Controllers;

use App\Jobs\SendOrderConfirmationEmail;
use App\Models\Order;
use App\Models\User;
use App\Notifications\TelegramNotiForAdmin;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Telegram\Bot\Laravel\Facades\Telegram;

class OrderController extends Controller
{
    

    public function orderStore(Request $request) {

        $request->validate([
            'user_id' => 'required|exists:users,id',
            'products' => 'required|array',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.quantity' => 'required',
            'total_amount' => 'required'
        ]);

        // Ensure the user is authenticated
        if (!$request->user()) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }

        // Generate a common transaction_id for the entire purchase
        $commonTransactionId = Str::uuid();

        // Create an order record using the common transaction_id
            $order = Order::create([
                'user_id' => $request->user_id,
                'quantity' => 0,
                // 'product_id' => $product['product_id'],
                // 'quantity' => $product['quantity'],
                'total_amount' => $request->total_amount,
                'transaction_id' => $commonTransactionId,
            ]);

        foreach ($request->input('products') as $product) {
            $order->products()->attach($product['product_id'], [
                'quantity' => $product['quantity'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $order->increment('quantity', $product['quantity']);
        }

        SendOrderConfirmationEmail::dispatch($order);

        Telegram::sendMessage([
            'chat_id' => env('TELEGRAM_CHAT_ID'),
            'text' => "New purchase made!\n\nOrder Details:\n\n" . 
                "Total Amount: $" . $order->total_amount . "\n\n" .
                "Transaction ID: " . $order->transaction_id . "\n\n" .
                "Customer Name: " . $order->user->name . "\n\n" .
                "Customer Email: " . $order->user->email,
        ]);
        

        return response()->json(['message' => 'Orders created successfully']);
    }


    public function getuserorder(Request $request) {
        // Ensure the user is authenticated
        if (!$request->user()) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }

        if($request->user()->orders) {
            $orders = $request->user()->orders()->with('products')->latest()->get();
            return response()->json(['orders' => $orders]);
        } else {
            return response()->json(['message' => "The user doesn't have any purchased products"]);
        }
    }
}
