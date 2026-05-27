<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\User;

class AdminDashboardController extends Controller
{
    // ================= DASHBOARD =================
    public function index()
    {
        return view('admin.dashboard', [

            'totalSellers'  => User::where('role', 'seller')->count(),

            'totalProducts' => Product::count(),

            'totalPending'  => Product::where('status', 'pending')->count(),

            'totalApproved' => Product::where('status', 'approved')->count(),

            'totalRejected' => Product::where('status', 'rejected')->count(),

            // ✅ TOTAL SOLD
            'totalSold'     => Product::where('status', 'sold')->count(),

        ]);
    }

    // ================= PRODUCTS PAGE =================
    public function products()
    {
        return view('admin.products', [

            'pending' => Product::where('status', 'pending')
                                ->latest()
                                ->get(),

            'approved' => Product::where('status', 'approved')
                                 ->latest()
                                 ->get(),

            'rejected' => Product::where('status', 'rejected')
                                 ->latest()
                                 ->get(),

            // ✅ SOLD PRODUCTS
            'sold' => Product::where('status', 'sold')
                             ->latest()
                             ->get(),

        ]);
    }

    // ================= BLOCK / UNBLOCK SELLER =================
    public function toggleBlock(User $user)
    {
        $user->update([
            'is_blocked' => !$user->is_blocked
        ]);

        return back()->with(
            'success',
            'Seller status updated successfully.'
        );
    }

    // ================= DELETE SELLER =================
    public function deleteSeller(User $user)
    {
        $user->delete();

        return back()->with(
            'success',
            'Seller deleted successfully.'
        );
    }

    // ================= SELLERS PAGE =================
    public function sellers()
    {
        return view('admin.sellers', [

            'sellers' => User::where('role', 'seller')
                             ->latest()
                             ->get(),

        ]);
    }

    // ================= OVERVIEW PAGE =================
    public function overview()
    {
        return view('admin.overview', [

            'totalSellers'  => User::where('role', 'seller')->count(),

            'totalProducts' => Product::count(),

            'pending'       => Product::where('status', 'pending')->count(),

            'approved'      => Product::where('status', 'approved')->count(),

            'rejected'      => Product::where('status', 'rejected')->count(),

            // ✅ TOTAL SOLD
            'sold'          => Product::where('status', 'sold')->count(),

        ]);
    }
}