<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller
{
    /**
     * Get comprehensive analytics dashboard data
     */
    public function dashboard(Request $request)
    {
        $startDate = $request->input('start_date', now()->subDays(30));
        $endDate = $request->input('end_date', now());

        // Cache key based on date range
        $cacheKey = "analytics_dashboard_{$startDate}_{$endDate}";

        $data = Cache::remember($cacheKey, 3600, function () use ($startDate, $endDate) {
            return [
                'total_sales' => $this->getTotalSales($startDate, $endDate),
                'monthly_chart' => $this->getMonthlyChartData($startDate, $endDate),
                'daily_breakdown' => $this->getDailyBreakdown($startDate, $endDate),
                'top_products' => $this->getTopSellingProducts($startDate, $endDate, 10),
                'summary' => $this->getSummaryStats($startDate, $endDate),
                'transaction_summary' => $this->getTransactionSummary($startDate, $endDate),
            ];
        });

        return response()->json($data);
    }

    /**
     * Get total sales amount
     */
    private function getTotalSales($startDate, $endDate)
    {
        return Order::completed()
            ->whereBetween('created_at', [$startDate, $endDate])
            ->sum('total_amount');
    }

    /**
     * Get monthly chart data with groupBy
     */
    private function getMonthlyChartData($startDate, $endDate)
    {
        return Order::completed()
            ->whereBetween('created_at', [$startDate, $endDate])
            ->select(
                DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
                DB::raw('SUM(total_amount) as total_sales'),
                DB::raw('COUNT(*) as order_count'),
                DB::raw('AVG(total_amount) as avg_order_value')
            )
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->map(function ($item) {
                return [
                    'month' => $item->month,
                    'total_sales' => (float) $item->total_sales,
                    'order_count' => $item->order_count,
                    'avg_order_value' => (float) $item->avg_order_value,
                ];
            });
    }

    /**
     * Get daily breakdown
     */
    private function getDailyBreakdown($startDate, $endDate)
    {
        return Order::completed()
            ->whereBetween('created_at', [$startDate, $endDate])
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(total_amount) as total_sales'),
                DB::raw('COUNT(*) as order_count'),
                DB::raw('SUM(tax_amount) as total_tax'),
                DB::raw('SUM(discount_amount) as total_discount')
            )
            ->groupBy('date')
            ->orderBy('date', 'desc')
            ->get()
            ->map(function ($item) {
                return [
                    'date' => $item->date,
                    'total_sales' => (float) $item->total_sales,
                    'order_count' => $item->order_count,
                    'total_tax' => (float) $item->total_tax,
                    'total_discount' => (float) $item->total_discount,
                ];
            });
    }

    /**
     * Get top selling products
     */
    private function getTopSellingProducts($startDate, $endDate, $limit = 10)
    {
        return OrderItem::select(
            'products.id',
            'products.name',
            DB::raw('SUM(order_items.quantity) as total_quantity'),
            DB::raw('SUM(order_items.subtotal) as total_revenue'),
            DB::raw('COUNT(DISTINCT order_items.order_id) as order_count')
        )
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.status', 'completed')
            ->whereBetween('orders.created_at', [$startDate, $endDate])
            ->groupBy('products.id', 'products.name')
            ->orderByDesc('total_revenue')
            ->limit($limit)
            ->get()
            ->map(function ($item) {
                return [
                    'product_id' => $item->id,
                    'product_name' => $item->name,
                    'total_quantity' => $item->total_quantity,
                    'total_revenue' => (float) $item->total_revenue,
                    'order_count' => $item->order_count,
                ];
            });
    }

    /**
     * Get summary statistics
     */
    private function getSummaryStats($startDate, $endDate)
    {
        $orders = Order::completed()
            ->whereBetween('created_at', [$startDate, $endDate]);

        return [
            'total_orders' => $orders->count(),
            'avg_order_value' => (float) $orders->avg('total_amount'),
            'total_revenue' => (float) $orders->sum('total_amount'),
            'total_tax_collected' => (float) $orders->sum('tax_amount'),
            'total_discounts_given' => (float) $orders->sum('discount_amount'),
        ];
    }

    /**
     * Clear analytics cache
     */
    public function clearCache()
    {
        Cache::flush();

        return response()->json([
            'message' => 'Analytics cache cleared successfully',
        ]);
    }

    /**
     * Get transaction summary
     */
    private function getTransactionSummary($startDate, $endDate)
    {
        return [
            'total_transactions' => Transaction::dateRange($startDate, $endDate)->count(),
            'completed_transactions' => Transaction::completed()->dateRange($startDate, $endDate)->count(),
            'failed_transactions' => Transaction::failed()->dateRange($startDate, $endDate)->count(),
            'total_payments' => (float) Transaction::payments()->completed()->dateRange($startDate, $endDate)->sum('amount'),
            'total_refunds' => (float) Transaction::refunds()->dateRange($startDate, $endDate)->sum('amount'),
            'success_rate' => $this->calculateTransactionSuccessRate($startDate, $endDate),
            'payment_methods' => Transaction::payments()->completed()
                ->dateRange($startDate, $endDate)
                ->select('payment_method', DB::raw('COUNT(*) as count'), DB::raw('SUM(amount) as total'))
                ->groupBy('payment_method')
                ->get()
                ->map(function ($item) {
                    return [
                        'method' => $item->payment_method,
                        'count' => $item->count,
                        'total' => (float) $item->total,
                    ];
                }),
        ];
    }

    private function calculateTransactionSuccessRate($startDate, $endDate)
    {
        $total = Transaction::payments()->dateRange($startDate, $endDate)->count();
        $completed = Transaction::payments()->completed()->dateRange($startDate, $endDate)->count();

        return $total > 0 ? round(($completed / $total) * 100, 2) : 0;
    }
}
