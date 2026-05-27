<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | PUBLIC PRODUCTS (BUYER VIEW)
    |--------------------------------------------------------------------------
    */
    public function index()
    {
        $products = Product::with('user')
            ->where('status', 'approved')
            ->latest()
            ->get();

        return view('products.index', compact('products'));
    }

    /*
    |--------------------------------------------------------------------------
    | SELLER CREATE FORM
    |--------------------------------------------------------------------------
    */
    public function create()
    {
        return view('seller.products.create');
    }

    /*
    |--------------------------------------------------------------------------
    | STORE PRODUCT (SELLER)
    |--------------------------------------------------------------------------
    */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'price' => 'required|numeric',
            'category' => 'required',
            'condition' => 'required',
            'image' => 'nullable|image',
        ]);

        $path = null;

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
        }

        $category = $request->category === 'other'
            ? $request->other_category
            : $request->category;

        Product::create([
            'title' => $request->title,
            'price' => $request->price,
            'category' => $category,
            'condition' => $request->condition,
            'description' => $request->description,
            'image' => $path,
            'user_id' => auth()->id(),
            'status' => 'pending',
        ]);

        return redirect()
            ->route('seller.dashboard')
            ->with('success', 'Product submitted and pending approval.');
    }

    /*
    |--------------------------------------------------------------------------
    | ADMIN PANEL - ALL PRODUCTS
    |--------------------------------------------------------------------------
    */
    public function adminProducts()
    {
        return view('admin.products', [
            'pending' => Product::with('user')->where('status', 'pending')->latest()->get(),
            'approved' => Product::with('user')->where('status', 'approved')->latest()->get(),
            'rejected' => Product::with('user')->where('status', 'rejected')->latest()->get(),
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | ADMIN ACTION - APPROVE
    |--------------------------------------------------------------------------
    */
    public function approve(Product $product)
    {
        $product->update([
            'status' => 'approved',
            'rejection_reason' => null
        ]);

        return back()->with('success', 'Product approved successfully.');
    }

    /*
    |--------------------------------------------------------------------------
    | ADMIN ACTION - REJECT (WITH REASON)
    |--------------------------------------------------------------------------
    */
   public function reject(Request $request, Product $product)
{
    $request->validate([
        'rejection_reason' => 'required|string|max:255',
    ]);

    $product->update([
        'status' => 'rejected',
        'rejection_reason' => $request->rejection_reason,
    ]);

    return back()->with('success', 'Product rejected successfully.');
}

public function edit(Product $product)
{
    // security: only owner can edit
    if ($product->user_id !== auth()->id()) {
        abort(403);
    }

    return view('seller.products.edit', compact('product'));
}

public function update(Request $request, Product $product)
{
    if ($product->user_id !== auth()->id()) {
        abort(403);
    }

    $request->validate([
        'title' => 'required',
        'price' => 'required|numeric',
        'category' => 'required',
        'condition' => 'required',
    ]);

    $product->update($request->all());

    return redirect()->route('seller.dashboard')
        ->with('success', 'Product updated successfully.');
}

/* ✅ DELETE WITH VALIDATION */
public function destroy(Product $product)
{
    if ($product->user_id !== auth()->id()) {
        abort(403);
    }

    if ($product->status === 'approved') {
        return back()->with('error', 'You cannot delete approved product.');
    }

    $product->delete();

    return back()->with('success', 'Product deleted successfully.');
}

/* ✅ MARK AS SOLD */
public function markAsSold(Product $product)
{
    if ($product->user_id !== auth()->id()) {
        abort(403);
    }

    $product->update([
        'status' => 'sold'
    ]);

    return back()->with('success', 'Product marked as sold.');
}

}