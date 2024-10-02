<?php

namespace App\Http\Controllers;

use App\Models\Order; // Ensure you import the Order model
use App\Models\Customer; // Import the Customer model
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10); // Get the number of items per page from the request, default to 10
        $orders = Order::with('customer', 'orderItems')->paginate($perPage); // Use paginate instead of get

        return view('orders.index', compact('orders', 'perPage'))
            ->with('i', ($request->input('page', 1) - 1) * $perPage);
    }

    public function show($id)
    {
        $order = Order::with('customer')->findOrFail($id); // Find the order by ID with associated customer
        return view('orders.show', compact('order')); // Pass the order to the view
    }
}
