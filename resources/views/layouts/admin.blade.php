<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - HappyPet</title>
    
    <link rel="stylesheet" href="{{ asset('css/admin-layout.css') }}">
    
    {{-- @stack untuk CSS tambahan jika tiap page admin butuh CSS beda lagi --}}
    @stack('styles')
</head>
<body>

    <div class="sidebar">
        <h2>HappyPet Admin</h2>
        <ul class="sidebar-menu">
            <li><a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">🏠 <span>Dashboard</span></a></li>
            <li><a href="{{ route('admin.product.list') }}" class="{{ request()->routeIs('admin.product.*') ? 'active' : '' }}">📦 <span>Products</span></a></li>
            <li><a href="{{ route('admin.category.list') }}" class="{{ request()->routeIs('admin.category.*') ? 'active' : '' }}">📁 <span>Categories</span></a></li>
            <li><a href="{{ route('admin.order.list') }}" class="{{ request()->routeIs('admin.order.*') ? 'active' : '' }}">🛒 <span>Orders</span></a></li>
            <li><a href="#">📝 <span>Blog</span></a></li>
            <hr style="border: 0.5px solid #334155; margin: 20px 0;">
            <li><a href="/" style="color: #ef4444;">🚪 <span>Back to Store</span></a></li>
        </ul>
    </div>

    <div class="main-content">
        @yield('content')
    </div>

    @stack('scripts')
</body>
</html>