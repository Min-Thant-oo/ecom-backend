<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $with = ['category'];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function order()
    {
        return $this->belongsToMany(Order::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }


    public function scopeFilter($query, $searchTerm, $categorySearchTerm)
    {
        $query->with('category');

        if ($searchTerm) {
            $query->where(function ($innerQuery) use ($searchTerm) {
                $innerQuery->where('title', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('description', 'LIKE', '%' . $searchTerm . '%');
            });
        }

        if ($categorySearchTerm) {
            $query->whereHas('category', function ($innerQuery) use ($categorySearchTerm) {
                $innerQuery->where('slug', $categorySearchTerm);
            });
        }

        return $query;
    }
}
