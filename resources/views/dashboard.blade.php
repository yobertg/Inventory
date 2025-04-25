@extends('layouts.app')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Dashboard</h1>

    <!-- Informasi Admin -->
    <div class="mb-4">
        <p class="text-gray-700">Logged in as: {{ Auth::guard('admin')->user()->username }}</p>
        <form action="{{ route('admin.logout') }}" method="POST" class="inline">
            @csrf
            <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">Logout</button>
        </form>
    </div>

    <!-- Ringkasan Sistem -->
    <div class="bg-white p-6 rounded-lg shadow-md mb-6">
        <h2 class="text-lg font-semibold mb-4">Ringkasan Sistem</h2>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="bg-blue-100 p-4 rounded">
                <p class="text-gray-700 font-semibold">Total Items</p>
                <p class="text-2xl">{{ number_format($systemSummary['total_items'], 0) }} units</p>
            </div>
            <div class="bg-green-100 p-4 rounded">
                <p class="text-gray-700 font-semibold">Total Stock Value</p>
                <p class="text-2xl">IDR {{ number_format($systemSummary['total_stock_value'], 2) }}</p>
            </div>
            <div class="bg-yellow-100 p-4 rounded">
                <p class="text-gray-700 font-semibold">Total Categories</p>
                <p class="text-2xl">{{ number_format($systemSummary['total_categories'], 0) }}</p>
            </div>
            <div class="bg-purple-100 p-4 rounded">
                <p class="text-gray-700 font-semibold">Total Suppliers</p>
                <p class="text-2xl">{{ number_format($systemSummary['total_suppliers'], 0) }}</p>
            </div>
        </div>
    </div>

    <!-- Ringkasan Stok -->
    <div class="bg-white p-6 rounded-lg shadow-md mb-6">
        <h2 class="text-lg font-semibold mb-4">Ringkasan Stok</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-blue-100 p-4 rounded">
                <p class="text-gray-700 font-semibold">Total Stock</p>
                <p class="text-2xl">{{ number_format($totalStock, 0) }} units</p>
            </div>
            <div class="bg-green-100 p-4 rounded">
                <p class="text-gray-700 font-semibold">Total Stock Value</p>
                <p class="text-2xl">IDR {{ number_format($totalStockValue, 2) }}</p>
            </div>
            <div class="bg-yellow-100 p-4 rounded">
                <p class="text-gray-700 font-semibold">Average Item Price</p>
                <p class="text-2xl">IDR {{ number_format($averagePrice, 2) }}</p>
            </div>
        </div>
    </div>

    <!-- Barang Stok Rendah -->
    <div class="bg-white p-6 rounded-lg shadow-md mb-6">
        <h2 class="text-lg font-semibold mb-4">Barang Stok Rendah (Di Bawah {{ $lowStockThreshold }} Unit)</h2>
        @if($lowStockItems->isEmpty())
            <p class="text-gray-500">No items with low stock.</p>
        @else
            <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="py-2 px-4 text-left">Name</th>
                        <th class="py-2 px-4 text-left">Category</th>
                        <th class="py-2 px-4 text-left">Supplier</th>
                        <th class="py-2 px-4 text-left">Price (IDR)</th>
                        <th class="py-2 px-4 text-left">Quantity</th>
                        <th class="py-2 px-4 text-left">Created By</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($lowStockItems as $item)
                        <tr class="border-b">
                            <td class="py-2 px-4">{{ $item->name }}</td>
                            <td class="py-2 px-4">{{ $item->category->name ?? 'N/A' }}</td>
                            <td class="py-2 px-4">{{ $item->supplier->name ?? 'N/A' }}</td>
                            <td class="py-2 px-4">{{ number_format($item->price, 2) }}</td>
                            <td class="py-2 px-4">{{ $item->quantity }}</td>
                            <td class="py-2 px-4">{{ $item->admin->username ?? 'N/A' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

    <!-- Laporan Barang Berdasarkan Kategori -->
    <div class="bg-white p-6 rounded-lg shadow-md mb-6">
        <h2 class="text-lg font-semibold mb-4">Laporan Barang Berdasarkan Kategori</h2>
        <form action="{{ route('dashboard') }}" method="GET" class="mb-4">
            <div class="flex items-center gap-4">
                <div class="w-full md:w-1/3">
                    <label for="category_id" class="block text-gray-700">Select Category</label>
                    <select name="category_id" id="category_id" class="w-full p-2 border rounded">
                        <option value="">All Categories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $selectedCategoryId) == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 mt-6">Filter</button>
                </div>
            </div>
        </form>

        @if($selectedCategory)
            <h3 class="text-md font-semibold mb-2">Items in Category: {{ $selectedCategory->name }}</h3>
        @else
            <h3 class="text-md font-semibold mb-2">All Items</h3>
        @endif

        @if($categoryItems->isEmpty())
            <p class="text-gray-500">No items found for this category.</p>
        @else
            <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="py-2 px-4 text-left">Name</th>
                        <th class="py-2 px-4 text-left">Category</th>
                        <th class="py-2 px-4 text-left">Supplier</th>
                        <th class="py-2 px-4 text-left">Price (IDR)</th>
                        <th class="py-2 px-4 text-left">Quantity</th>
                        <th class="py-2 px-4 text-left">Created By</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($categoryItems as $item)
                        <tr class="border-b">
                            <td class="py-2 px-4">{{ $item->name }}</td>
                            <td class="py-2 px-4">{{ $item->category->name ?? 'N/A' }}</td>
                            <td class="py-2 px-4">{{ $item->supplier->name ?? 'N/A' }}</td>
                            <td class="py-2 px-4">{{ number_format($item->price, 2) }}</td>
                            <td class="py-2 px-4">{{ $item->quantity }}</td>
                            <td class="py-2 px-4">{{ $item->admin->username ?? 'N/A' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

    <!-- Ringkasan Per Kategori -->
    <div class="bg-white p-6 rounded-lg shadow-md mb-6">
        <h2 class="text-lg font-semibold mb-4">Ringkasan Per Kategori</h2>
        @if($categorySummaries->isEmpty())
            <p class="text-gray-500">No categories found.</p>
        @else
            <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="py-2 px-4 text-left">Category</th>
                        <th class="py-2 px-4 text-left">Number of Items</th>
                        <th class="py-2 px-4 text-left">Total Stock Value (IDR)</th>
                        <th class="py-2 px-4 text-left">Average Item Price (IDR)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($categorySummaries as $summary)
                        <tr class="border-b">
                            <td class="py-2 px-4">{{ $summary->name }}</td>
                            <td class="py-2 px-4">{{ $summary->item_count }}</td>
                            <td class="py-2 px-4">{{ number_format($summary->total_stock_value ?? 0, 2) }}</td>
                            <td class="py-2 px-4">{{ number_format($summary->average_price ?? 0, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

    <!-- Ringkasan Per Pemasok -->
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-lg font-semibold mb-4">Ringkasan Per Supplier</h2>
        @if($supplierSummaries->isEmpty())
            <p class="text-gray-500">No suppliers found.</p>
        @else
            <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="py-2 px-4 text-left">Supplier</th>
                        <th class="py-2 px-4 text-left">Number of Items</th>
                        <th class="py-2 px-4 text-left">Total Stock Value (IDR)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($supplierSummaries as $summary)
                        <tr class="border-b">
                            <td class="py-2 px-4">{{ $summary->name }}</td>
                            <td class="py-2 px-4">{{ $summary->item_count }}</td>
                            <td class="py-2 px-4">{{ number_format($systemSummary['total_stock_value'], 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection