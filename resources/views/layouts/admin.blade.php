<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - HappyPet</title>
    
    <link rel="stylesheet" href="{{ asset('css/admin-layout.css') }}">
    
    @stack('styles')
</head>
<body>

    <div class="sidebar">
        <h2>HappyPet Admin</h2>
        <ul class="sidebar-menu">
            {{-- Dashboard --}}
            <li>
                <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    🏠 <span>Dashboard</span>
                </a>
            </li>

            <p class="menu-label" style="color: #64748b; font-size: 11px; font-weight: 700; margin: 20px 0 10px 15px; text-transform: uppercase;">E-Commerce</p>

            {{-- Produk --}}
            <li>
                <a href="{{ route('admin.product.list') }}" class="{{ request()->routeIs('admin.product.*') ? 'active' : '' }}">
                    📦 <span>Products</span>
                </a>
            </li>

            {{-- Kategori Produk --}}
            <li>
                <a href="{{ route('admin.category.list') }}" class="{{ request()->routeIs('admin.category.*') ? 'active' : '' }}">
                    📁 <span>Categories</span>
                </a>
            </li>

            {{-- Pesanan --}}
            <li>
                <a href="{{ route('admin.order.list') }}" class="{{ request()->routeIs('admin.order.*') ? 'active' : '' }}">
                    🛒 <span>Orders</span>
                </a>
            </li>

            <p class="menu-label" style="color: #64748b; font-size: 11px; font-weight: 700; margin: 20px 0 10px 15px; text-transform: uppercase;">Content & Stats</p>
            
            {{-- Blog & Edukasi --}}
            <li>
                {{-- Kita pake pengecekan manual biar nggak tabrakan sama kategori --}}
                <a href="{{ route('admin.blog.list') }}" class="{{ (request()->routeIs('admin.blog.list') || request()->routeIs('admin.blog.create')) ? 'active' : '' }}">
                    📝 <span>Blog & Edukasi</span>
                </a>
            </li>

            {{-- Supplier --}}
            <li>
                <a href="{{ route('admin.suppliers.index') }}"
                class="{{ request()->routeIs('admin.suppliers.*') ? 'active' : '' }}">
                    🚚 <span>Supplier</span>
                </a>
            </li>
            
            {{-- Kategori Blog --}}
            <li>
                <a href="{{ route('admin.blog.category.list') }}" class="{{ request()->routeIs('admin.blog.category.*') ? 'active' : '' }}">
                    📁 <span>Kategori Blog</span>
                </a>
            </li>

            {{-- Laporan Penjualan --}}
            <li>
                <a href="{{ route('admin.report.index') }}" class="{{ request()->routeIs('admin.report.*') ? 'active' : '' }}">
                    📄 <span>Laporan Penjualan</span>
                </a>
            </li>

            {{-- User Management --}}
            <li>
                <a href="{{ route('admin.user.list') }}" class="{{ request()->routeIs('admin.user.*') ? 'active' : '' }}">
                    👥 <span>Manajemen User</span>
                </a>
            </li>

            <hr style="border: 0.5px solid #334155; margin: 20px 0;">
            
            {{-- Logout --}}
            <li>
                <form method="POST" action="{{ route('logout') }}" style="display: block;">
                    @csrf
                    <button type="submit" style="background: none; border: none; color: #ef4444; cursor: pointer; font-weight: bold; font-size: 14px; width: 100%; text-align: left; padding: 12px 15px; display: flex; align-items: center; gap: 10px;">
                        🚪 <span>Logout</span>
                    </button>
                </form>
            </li>
        </ul>
    </div>

    <div class="main-content">
        @yield('content')
    </div>

    @stack('scripts')
</body>
</html>