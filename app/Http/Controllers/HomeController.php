<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\User;
use App\Models\Brand;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $products = Product::select('id')->get();
        $totalProducts = $products->count();
        $orders = Order::select('id')->get();
        $totalOrders = $orders->count();

        // Products by Brand
        $productsByBrand = Product::selectRaw('brands.id, brands.name, COUNT(products.id) as total')
            ->join('brands', 'products.brand_id', '=', 'brands.id')
            ->groupBy('brands.id', 'brands.name')
            ->pluck('total', 'name');

        // Create a mapping of brand names to IDs
        $brandIds = Product::join('brands', 'products.brand_id', '=', 'brands.id')
            ->select('brands.id as brand_id', 'brands.name')
            ->distinct()
            ->pluck('brand_id', 'name');
        // Products by Category
        $productsByCategory = Product::selectRaw('categories.id, categories.name, COUNT(products.id) as total')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->groupBy('categories.id', 'categories.name')
            ->pluck('total', 'name');

        // Create a mapping of category names to IDs
        $categoryIds = Product::join('categories', 'products.category_id', '=', 'categories.id')
            ->select('categories.id as category_id', 'categories.name')
            ->distinct()
            ->pluck('category_id', 'name');

        // Orders by Status
        $ordersByStatus = Order::selectRaw('status, COUNT(id) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        // Orders by Month
        $ordersByMonth = Order::selectRaw('MONTHNAME(created_at) as month, COUNT(id) as total')
            ->groupBy('month')
            ->orderByRaw('MIN(created_at)')
            ->pluck('total', 'month');

        return view('home', compact(
            'totalProducts',
            'totalOrders',
            'productsByBrand',
            'productsByCategory',
            'ordersByStatus',
            'ordersByMonth',
            'brandIds', // Pass the brand ID mapping
            'categoryIds' // Pass the category ID mapping
        ));
    }
}
