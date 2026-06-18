<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = Cache::remember('dashboard.stats', 300, function () {
            return [
                'totalUsers'    => User::where('role', 'customer')->count(),
                'totalProducts' => Product::count(),
                'totalOrders'   => Order::count(),
                'totalRevenue'  => Order::where('status', '!=', 'cancelled')->sum('total_price'),
                'monthlySales'  => Order::select(
                    DB::raw('MONTH(created_at) as month'),
                    DB::raw('SUM(total_price) as total')
                )
                    ->whereYear('created_at', now()->year)
                    ->where('status', '!=', 'cancelled')
                    ->groupBy('month')
                    ->orderBy('month')
                    ->get(),
            ];
        });

        $recentOrders = Order::with('user')->latest()->take(5)->get();

        return view('admin.dashboard', array_merge($stats, compact('recentOrders')));
    }
}
