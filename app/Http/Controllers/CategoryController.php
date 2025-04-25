<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
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
                'description' => 'string|nullable',
            ]);

            $data = $request->all();
            $data['created_by'] = Auth::guard('admin')->id(); // Add created_by
            Category::create($data);

            return redirect()->route('categories.index')->with('success', 'Category created successfully!');
        }

        // Handle read (GET request)
        $categories = Category::all();
        return view('categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'description' => 'string|nullable',
        ]);

        $data = $request->all();
        $data['created_by'] = Auth::guard('admin')->id(); // Add created_by
        $category = Category::create($data);
        return response()->json($category, 201);
    }

    public function show(Category $category)
    {
        return $category;
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'string|max:100',
            'description' => 'string|nullable',
        ]);

        $category->update($request->all());
        return response()->json($category, 200);
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return response()->json(null, 204);
    }
}