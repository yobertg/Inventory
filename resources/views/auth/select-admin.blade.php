@extends('layouts.app')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Select Admin</h1>

    <div class="bg-white p-6 rounded-lg shadow-md mb-6">
        <h2 class="text-lg font-semibold mb-4">Choose an Admin to Proceed</h2>

        @if(session('error'))
            <div class="bg-red-100 text-red-700 p-4 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-4 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('admin.select') }}" method="POST">
            @csrf
            <div class="grid grid-cols-1 gap-4">
                <div>
                    <label for="admin_id" class="block text-gray-700">Select Admin</label>
                    <select name="admin_id" id="admin_id" class="w-full p-2 border rounded @error('admin_id') border-red-500 @enderror">
                        <option value="">Choose an Admin</option>
                        @foreach($admins as $admin)
                            <option value="{{ $admin->id }}" {{ old('admin_id') == $admin->id ? 'selected' : '' }}>{{ $admin->username }} ({{ $admin->email }})</option>
                        @endforeach
                    </select>
                    @error('admin_id')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div class="mt-4">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Proceed as Admin</button>
                <a href="{{ url('/') }}" class="bg-gray-300 text-gray-700 px-4 py-2 rounded hover:bg-gray-400">Cancel</a>
            </div>
        </form>
    </div>
@endsection