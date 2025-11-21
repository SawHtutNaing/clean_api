<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class QueryOptimizationService
{
    /**
     * BAD: N+1 Problem Example
     * This will execute 1 query for orders + N queries for items
     */
    public function badExample()
    {
        $orders = Order::all(); // 1 query

        foreach ($orders as $order) {
            // N queries (one for each order)
            $items = $order->items;

            foreach ($items as $item) {
                // N*M queries (one for each item)
                $product = $item->product;
            }
        }
    }

    /**
     * GOOD: Eager Loading with N+1 Fix
     * This will execute only 3 queries total
     */
    public function goodExample()
    {
        // 1 query for orders
        // 1 query for all items
        // 1 query for all products
        $orders = Order::with(['items.product', 'user'])->get();

        foreach ($orders as $order) {
            $items = $order->items; // No query, already loaded

            foreach ($items as $item) {
                $product = $item->product; // No query, already loaded
            }
        }
    }

    /**
     * Lazy Loading vs Eager Loading Comparison
     */
    public function lazyVsEagerLoading()
    {
        // LAZY LOADING (Default)
        // Problem: Each relationship access triggers a new query
        $order = Order::find(1);
        $items = $order->items; // Query executed here
        foreach ($items as $item) {
            $product = $item->product; // Query for each product
        }

        // EAGER LOADING (Recommended)
        // Benefit: All relationships loaded in advance
        $order = Order::with(['items.product'])->find(1);
        $items = $order->items; // No query, already loaded
        foreach ($items as $item) {
            $product = $item->product; // No query, already loaded
        }
    }

    /**
     * Sales by date range with efficient query
     */
    public function getSalesByDateRange($startDate, $endDate)
    {
        return Order::query()
            ->with(['items.product']) // Eager load relationships
            ->completed()
            ->whereBetween('created_at', [$startDate, $endDate])
            ->select([
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(total_amount) as total_sales'),
                DB::raw('COUNT(*) as order_count'),
            ])
            ->groupBy('date')
            ->orderBy('date', 'desc')
            ->get();
    }

    /**
     * Top selling products with optimized query
     */
    public function getTopSellingProducts($limit = 10)
    {
        return Product::query()
            ->select([
                'products.id',
                'products.name',
                'products.price',
                DB::raw('SUM(order_items.quantity) as total_sold'),
                DB::raw('SUM(order_items.subtotal) as total_revenue'),
            ])
            ->join('order_items', 'products.id', '=', 'order_items.product_id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.status', 'completed')
            ->groupBy('products.id', 'products.name', 'products.price')
            ->orderByDesc('total_sold')
            ->limit($limit)
            ->get();
    }

    /**
     * Efficient query with subqueries instead of multiple queries
     */
    public function getOrdersWithStats()
    {
        return Order::query()
            ->select([
                'orders.*',
                DB::raw('(SELECT COUNT(*) FROM order_items WHERE order_items.order_id = orders.id) as items_count'),
                DB::raw('(SELECT SUM(quantity) FROM order_items WHERE order_items.order_id = orders.id) as total_items'),
            ])
            ->with(['user:id,name,email']) // Only select needed columns
            ->get();
    }

    /**
     * Chunk large datasets to avoid memory issues
     */
    public function processLargeDataset()
    {
        Order::with(['items.product'])
            ->completed()
            ->chunk(100, function ($orders) {
                foreach ($orders as $order) {
                    // Process each order
                    // Items and products already eager loaded
                }
            });
    }

    /**
     * Use cursor for memory-efficient iteration
     */
    public function useCursorForLargeDataset()
    {
        foreach (Order::with(['items.product'])->cursor() as $order) {
            // Process each order with minimal memory usage
        }
    }

    /**
     * Conditional eager loading
     */
    public function conditionalEagerLoading()
    {
        return Order::query()
            ->when(request()->has('include_items'), function ($query) {
                $query->with('items.product');
            })
            ->when(request()->has('include_user'), function ($query) {
                $query->with('user');
            })
            ->get();
    }
}
