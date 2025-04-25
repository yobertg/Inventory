<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupplierController extends Controller
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
                'name' => 'required|string|max:100',
                'contact_info' => 'string|max:100|nullable',
            ]);

            $data = $request->all();
            $data['created_by'] = Auth::guard('admin')->id(); // Add created_by
            Supplier::create($data);

            return redirect()->route('suppliers.index')->with('success', 'Supplier created successfully!');
        }

        // Handle read (GET request)
        $suppliers = Supplier::all();
        return view('suppliers.index', compact('suppliers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'contact_info' => 'string|max:100|nullable',
        ]);

        $data = $request->all();
        $data['created_by'] = Auth::guard('admin')->id(); // Add created_by
        $supplier = Supplier::create($data);
        return response()->json($supplier, 201);
    }

    public function show(Supplier $supplier)
    {
        return $supplier;
    }

    public function update(Request $request, Supplier $supplier)
    {
        $request->validate([
            'name' => 'string|max:100',
            'contact_info' => 'string|max:100|nullable',
        ]);

        $supplier->update($request->all());
        return response()->json($supplier, 200);
    }

    public function destroy(Supplier $supplier)
    {
        $supplier->delete();
        return response()->json(null, 204);
    }
}