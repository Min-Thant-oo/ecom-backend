<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Http\Middleware\User;
use App\Models\Category;
use App\Models\Order;
use App\Models\User as ModelsUser;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        // $this->call([
        //     $demoUser = UserSeeder::class,
        // ]);
        $demoUser = $this->call(UserSeeder::class);

        $users = \App\Models\User::factory(20)->create();

        \App\Models\Category::factory(10)->create();

        $products = \App\Models\Product::factory(100)->create();

        $orders = \App\Models\Order::factory(15)->create();

        // $randomUserProductCount = rand(4, 16);
        // $randomUserProducts = $products->random($randomUserProductCount)->pluck('id');
        

        // Attaching random favourite products to each user
        $users->each(function ($user) use ($products) {
            $randomUserProductCount = rand(4, 16);
            $randomUserProducts = $products->random($randomUserProductCount)->pluck('id');
            $user->products()->attach(
                $randomUserProducts,
                ['created_at' => now(), 'updated_at' => now()],
            );
        });

        $quantities = [];

        // // Attaching random purchased products to each order


        // Attaching random purchased products to each order
        // foreach ($orders as $order) {
        //     $randomOrderProductCount = rand(4, 15);
        //     $randomOrderProducts = $products->random($randomOrderProductCount)->pluck('id');

        //     // Ensure the total quantity of attached products equals the order's quantity
        //     $totalQuantity = $order->quantity;
        //     $attachedQuantity = 0;

        //     foreach ($randomOrderProducts as $productId) {
        //         // Ensure we don't attach more products than the order's quantity
        //         $quantityToAdd = min(rand(1, $totalQuantity - $attachedQuantity), $totalQuantity - $attachedQuantity);

        //         $order->products()->attach($productId, [
        //             'quantity' => $quantityToAdd,
        //             'created_at' => now(),
        //             'updated_at' => now(),
        //         ]);

        //         $attachedQuantity += $quantityToAdd;
        //     }
        // }


        foreach ($orders as $order) {
            $orderQuantity = $order->quantity;
            $randomOrderProductCount = rand(4, 15);
            $randomOrderProducts = $products->random($randomOrderProductCount)->pluck('id');

            // Ensure the total quantity of attached products equals the order's quantity
            $remainingQuantity = $orderQuantity;
            $attachedQuantity = 0;

            foreach ($randomOrderProducts as $productId) {
                // Ensure we don't attach more products than the remaining order quantity
                $quantityToAdd = min(rand(1, $remainingQuantity), $remainingQuantity);

                $order->products()->attach($productId, [
                    'quantity' => $quantityToAdd,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                $attachedQuantity += $quantityToAdd;
                $remainingQuantity -= $quantityToAdd;

                // Exit the loop if the order quantity is reached
                if ($remainingQuantity <= 0) {
                    break;
                }
            }

            $quantities[$order->id] = $orderQuantity;
        }
    }
}
