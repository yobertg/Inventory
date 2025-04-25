<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Category;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin'); // Require admin selection
    }

    public function index(Request $request)
    {
        // System summary
        $systemSummary = [
            'total_items' => Item::count(),
            'total_stock_value' => Item::sum(DB::raw('price * quantity')) ?? 0,
            'total_categories' => Category::count(),
            'total_suppliers' => Supplier::count(),
        ];

        // Stock summary
        $totalStock = Item::sum('quantity');
        $totalStockValue = Item::sum(DB::raw('price * quantity'));
        $averagePrice = Item::avg('price') ?? 0;

        // Low-stock items (quantity < 5)
        $lowStockThreshold = 5;
        $lowStockItems = Item::where('quantity', '<', $lowStockThreshold)->get();

        // Category filter
        $categories = Category::all();
        $selectedCategoryId = $request->query('category_id') ? (int) $request->query('category_id') : null;
        $categoryItems = Item::when($selectedCategoryId, function ($query, $selectedCategoryId) {
            return $query->where('category_id', $selectedCategoryId);
        })->get();
        $selectedCategory = $selectedCategoryId ? Category::find($selectedCategoryId) : null;

        // Per-category summary
        $categorySummaries = Category::select([
            'categories.id',
            'categories.name',
            DB::raw('COUNT(items.id) as item_count'),
            DB::raw('SUM(items.price * items.quantity) as total_stock_value'),
            DB::raw('AVG(items.price) as average_price')
        ])
            ->leftJoin('items', 'categories.id', '=', 'items.category_id')
            ->groupBy('categories.id', 'categories.name')
            ->get();

        // Per-supplier summary
        $supplierSummaries = Supplier::select([
            'suppliers.id',
            'suppliers.name',
            DB::raw('COUNT(items.id) as item_count'),
            DB::raw('SUM(items.price * items.quantity) as total_stock_value')
        ])
            ->leftJoin('items', 'suppliers.id', '=', 'items.supplier_id')
            ->groupBy('suppliers.id', 'suppliers.name')
            ->get();

        return view('dashboard', compact(
            'systemSummary',
            'totalStock',
            'totalStockValue',
            'averagePrice',
            'lowStockItems',
            'lowStockThreshold',
            'categories',
            'categoryItems',
            'selectedCategory',
            'selectedCategoryId',
            'categorySummaries',
            'supplierSummaries'
        ));
    }
}