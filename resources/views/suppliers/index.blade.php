@extends('layouts.app')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Suppliers List</h1>

    <!-- Informasi Admin -->
    <div class="mb-4">
        <p class="text-gray-700">Logged in as: {{ Auth::guard('admin')->user()->username }}</p>
        <form action="{{ route('admin.logout') }}" method="POST" class="inline">
            @csrf
            <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">Logout</button>
        </form>
    </div>

    <!-- Form Create -->
    <div class="bg-white p-6 rounded-lg shadow-md mb-6">
        <h2 class="text-lg font-semibold mb-4">Add New Supplier</h2>
        <form action="{{ route('suppliers.index') }}" method="POST">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="name" class="block text-gray-700">Supplier Name</label>
                    <input type="text" name="name" id="name" class="w-full p-2 border rounded @error('name') border-red-500 @enderror" value="{{ old('name') }}">
                    @error('name')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="contact_info" class="block text-gray-700">Contact Information</label>
                    <input type="text" name="contact_info" id="contact_info" class="w-full p-2 border rounded @error('contact_info') border-red-500 @enderror" value="{{ old('contact_info') }}">
                    @error('contact_info')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div class="mt-4">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Add Supplier</button>
                <a href="{{ route('suppliers.index') }}" class="bg-gray-300 text-gray-700 px-4 py-2 rounded hover:bg-gray-400">Cancel</a>
            </div>
        </form>
    </div>

    <hr class="my-6">

    <!-- Daftar Suppliers -->
    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-4 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif
    @if($suppliers->isEmpty())
        <p class="text-gray-500">No suppliers found.</p>
    @else
        <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden">
            <thead class="bg-gray-200">
                <tr>
                    <th class="py-2 px-4 text-left">Name</th>
                    <th class="py-2 px-4 text-left">Contact Information</th>
                    <th class="py-2 px-4 text-left">Created By</th>
                </tr>
            </thead>
            <tbody>
                @foreach($suppliers as $supplier)
                    <tr class="border-b">
                        <td class="py-2 px-4">{{ $supplier->name }}</td>
                        <td class="py-2 px-4">{{ $supplier->contact_info ?? 'N/A' }}</td>
                        <td class="py-2 px-4">{{ $supplier->admin->username ?? 'N/A' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
@endsection