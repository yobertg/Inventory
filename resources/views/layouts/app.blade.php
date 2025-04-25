<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Management</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <nav class="bg-blue-600 p-4">
        <div class="container mx-auto flex justify-between">
            <a href="/" class="text-white text-lg font-bold">Inventory Management</a>
            <div>
                <a href="{{ route('items.index') }}" class="text-white mx-4">Items</a>
                <a href="{{ route('categories.index') }}" class="text-white mx-4">Categories</a>
                <a href="{{ route('suppliers.index') }}" class="text-white mx-4">Suppliers</a>
                <a href="{{ route('dashboard') }}" class="text-white mx-4">Dashboard</a>
                <a href="{{ route('admin.select.form') }}" class="text-white mx-4">Admin</a>
            </div>
        </div>
    </nav>
    <div class="container mx-auto mt-6">
        @yield('content')
    </div>
</body>
</html>