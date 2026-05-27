<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    // GET all products
    public function index()
    {
        return response()->json(
            Product::latest()->get()
        );
    }

    // POST create product
    public function store(Request $request)
    {
        $product = Product::create([
            'user_id' => 1,
            'title' => $request->title,
            'description' => $request->description,
            'price' => $request->price,
            'category' => $request->category,
            'condition' => $request->condition,
            'image' => $request->image,
            'contact_number' => $request->contact_number,
            'messenger_link' => $request->messenger_link,
        ]);

        return response()->json([
            'message' => 'Product created successfully',
            'data' => $product
        ]);
    }
}