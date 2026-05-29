<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;

class SellerController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | PROFILE SETUP
    |--------------------------------------------------------------------------
    */

    public function setup()
    {
        return view('seller.profile-setup');
    }

    public function storeProfile(Request $request)
    {
        $request->validate([
            'contact_number' => 'required',
            'address' => 'required',
        ]);

        $hasSocial =
            $request->facebook ||
            $request->instagram ||
            $request->messenger_link;

        if (!$hasSocial) {
            return back()
                ->withErrors([
                    'social' => 'Please provide at least one social media link.'
                ])
                ->withInput();
        }

        $user = auth()->user();

        $user->contact_number = $request->contact_number;
        $user->address = $request->address;
        $user->facebook = $request->facebook;
        $user->instagram = $request->instagram;
        $user->messenger_link = $request->messenger_link;
        $user->profile_completed = true;

        $user->save();

        return redirect()
            ->route('seller.products.create')
            ->with('success', 'Profile completed! You can now add products.');
    }

    /*
    |--------------------------------------------------------------------------
    | SELLER DASHBOARD
    |--------------------------------------------------------------------------
    */

    public function dashboard(Request $request)
    {
        $userId = Auth::id();

        // GET FILTER STATUS
        $status = $request->status ?? 'all';

        // PRODUCT QUERY
        $query = Product::where('user_id', $userId);

        // FILTER BY STATUS
        if ($status !== 'all') {
            $query->where('status', $status);
        }

        // GET PRODUCTS
        $products = $query->latest()->get();

        // COUNTS
        $totalProducts = Product::where('user_id', $userId)->count();

        $pendingCount = Product::where('user_id', $userId)
            ->where('status', 'pending')
            ->count();

        $approvedCount = Product::where('user_id', $userId)
            ->where('status', 'approved')
            ->count();

        $rejectedCount = Product::where('user_id', $userId)
            ->where('status', 'rejected')
            ->count();

        $soldCount = Product::where('user_id', $userId)
            ->where('status', 'sold')
            ->count();

        return view('seller.dashboard', compact(
            'products',
            'status',
            'totalProducts',
            'pendingCount',
            'approvedCount',
            'rejectedCount',
            'soldCount'
        ));
    }

    /*
    |--------------------------------------------------------------------------
    | DELETE PRODUCT
    |--------------------------------------------------------------------------
    */

    public function destroy(Product $product)
    {
        if ($product->user_id !== auth()->id()) {
            abort(403);
        }

        $product->delete();

        return redirect()
            ->route('seller.dashboard')
            ->with('success', 'Product deleted successfully.');
    }

    /*
    |--------------------------------------------------------------------------
    | EDIT PRODUCT
    |--------------------------------------------------------------------------
    */

    public function edit(Product $product)
    {
        if ($product->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('seller.edit-product', compact('product'));
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE PRODUCT
    |--------------------------------------------------------------------------
    */

    public function update(Request $request, Product $product)
    {
        if ($product->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'title' => 'required',
            'price' => 'required|numeric',
            'category' => 'required',
            'condition' => 'required',
            'description' => 'nullable',
        ]);

        $product->update([
            'title' => $request->title,
            'price' => $request->price,
            'category' => $request->category,
            'condition' => $request->condition,
            'description' => $request->description,
        ]);

        return redirect()
            ->route('seller.dashboard')
            ->with('success', 'Product updated successfully.');
    }
}