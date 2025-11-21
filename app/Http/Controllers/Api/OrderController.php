<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with(['user', 'items.product']);

        // Filtering
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        if ($request->has('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->has('date_from')) {
            $query->where('created_at', '>=', $request->date_from);
        }

        if ($request->has('date_to')) {
            $query->where('created_at', '<=', $request->date_to);
        }

        // Sorting
        $sortBy = $request->input('sort_by', 'created_at');
        $sortOrder = $request->input('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        // Pagination
        $perPage = $request->input('per_page', 15);
        $orders = $query->paginate($perPage);

        return OrderResource::collection($orders);
    }

    public function store(StoreOrderRequest $request)
    {
        try {
            DB::beginTransaction();

            $taxRate = 0.1;
            $subtotal = 0;

            // Calculate subtotal and validate stock
            foreach ($request->items as $item) {
                $product = Product::findOrFail($item['product_id']);

                if ($product->stock < $item['quantity']) {
                    // return response()->json([
                    //     'message' => "Insufficient stock for product: {$product->name}",
                    // ], 422);
                    throw new \App\Exceptions\InsufficientStockException("Insufficient stock for product: {$product->name}");
                }

                $subtotal += $product->price * $item['quantity'];
            }

            $discountAmount = $request->input('discount_amount', 0);
            $taxAmount = ($subtotal - $discountAmount) * $taxRate;
            $totalAmount = $subtotal - $discountAmount + $taxAmount;


            $order = Order::create([
                'user_id' => auth()->id(),
                'total_amount' => $totalAmount,
                'tax_amount' => $taxAmount,
                'discount_amount' => $discountAmount,
                'status' => 'pending',
            ]);


            foreach ($request->items as $item) {
                $product = Product::findOrFail($item['product_id']);

                $order->items()->create([
                    'product_id' => $product->id,
                    'quantity' => $item['quantity'],
                    'unit_price' => $product->price,
                    'subtotal' => $product->price * $item['quantity'],
                ]);

                $product->decrement('stock', $item['quantity']);
            }

            DB::commit();

            return new OrderResource($order->load(['items.product', 'user']));

        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function show(Order $order)
    {
        return new OrderResource($order->load(['items.product', 'user']));
    }

    public function update(UpdateOrderRequest $request, Order $order)
    {
        $order->update($request->validated());

        if ($request->status === 'completed' && ! $order->completed_at) {
            $order->update(['completed_at' => now()]);
        }

        return new OrderResource($order->load(['items.product', 'user']));
    }

    public function destroy(Order $order)
    {
        // Restore stock before deleting
        foreach ($order->items as $item) {
            $item->product->increment('stock', $item->quantity);
        }

        $order->delete();

        return response()->json([
            'message' => 'Order deleted successfully',
        ], 200);
    }
}
