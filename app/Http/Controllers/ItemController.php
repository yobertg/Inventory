<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Category;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ItemController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin'); // Ensure admin is selected
    }

    public function index(Request $request)
    {
        if ($request->isMethod('post')) {
            // Handle create (POST request)
            $request->validate([
                'name' => 'required|string',
                'description' => 'nullable|string',
                'price' => 'required|numeric',
                'quantity' => 'required|integer',
                'category_id' => 'required|exists:categories,id',
                'supplier_id' => 'required|exists:suppliers,id',
            ]);

            $data = $request->all();
            $data['created_by'] = Auth::guard('admin')->id(); // Add created_by
            Item::create($data);

            return redirect()->route('items.index')->with('success', 'Item created successfully!');
        }

        // Handle read (GET request)
        $items = Item::all();
        $categories = Category::all();
        $suppliers = Supplier::all();
        return view('items.index', compact('items', 'categories', 'suppliers'));
    }
}