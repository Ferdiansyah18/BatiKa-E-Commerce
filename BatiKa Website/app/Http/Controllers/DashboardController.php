<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        if (!auth()->user()->hasAnyRole(['owner', 'admin'])) {
            return redirect()->route('account.dashboard');
        }

        // Real Statistics
        $totalRevenue = Order::where('payment_status', 'paid')
            ->orWhereIn('status', ['processing', 'on_delivery', 'delivered'])
            ->sum('total_amount');
            
        // Month-over-Month Growth Calculation
        $now = Carbon::now();
        $lastMonth = Carbon::now()->subMonth();

        // 1. Revenue Growth
        $currentMonthRevenue = Order::whereMonth('created_at', $now->month)
             ->whereYear('created_at', $now->year)
             ->where('payment_status', 'paid')
             ->sum('total_amount');

        $lastMonthRevenue = Order::whereMonth('created_at', $lastMonth->month)
             ->whereYear('created_at', $lastMonth->year)
             ->where('payment_status', 'paid')
             ->sum('total_amount');
        
        $revenueGrowth = 0;
        if ($lastMonthRevenue > 0) {
            $revenueGrowth = (($currentMonthRevenue - $lastMonthRevenue) / $lastMonthRevenue) * 100;
        } elseif ($currentMonthRevenue > 0) {
            $revenueGrowth = 100;
        }

        // 2. Orders Growth
        $currentMonthOrders = Order::whereMonth('created_at', $now->month)
             ->whereYear('created_at', $now->year)
             ->count();

        $lastMonthOrders = Order::whereMonth('created_at', $lastMonth->month)
             ->whereYear('created_at', $lastMonth->year)
             ->count();

        $ordersGrowth = 0;
        if ($lastMonthOrders > 0) {
            $ordersGrowth = (($currentMonthOrders - $lastMonthOrders) / $lastMonthOrders) * 100;
        } elseif ($currentMonthOrders > 0) {
            $ordersGrowth = 100;
        }

        $stats = [
            'total_revenue' => $totalRevenue,
            'total_orders' => Order::count(),
            'products_sold' => OrderItem::sum('quantity'),
            'new_customers' => User::role('buyer')->whereMonth('created_at', $now->month)->count(),
            'total_customers' => User::role('buyer')->count(),
            'revenue_growth' => round($revenueGrowth, 1),
            'orders_growth' => round($ordersGrowth, 1),
        ];

        // Recent Orders (All Statuses)
        $ordersToProcess = Order::with(['user'])
            ->latest()
            ->take(5)
            ->get();

        // Dummy Consumer Feedback (Keep for now or replace if Review model has data)
        // Real Consumer Feedback
        $feedback = \App\Models\Review::with(['user', 'product'])
            ->latest()
            ->take(5)
            ->get();
        // Re-using dummy feedback for UI completeness if DB is empty of reviews
        
        // Re-using dummy feedback for UI completeness if DB is empty of reviews
        
        $wishlists = \App\Models\Wishlist::with('product')->where('user_id', auth()->id())->get();

        return view('dashboard', compact('stats', 'feedback', 'wishlists', 'ordersToProcess'));
    }
}


