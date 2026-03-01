<nav class="navbar">
    <div class="container">
        <div class="logo">
            <a href="/">HappyPet Store</a>
        </div>

        <ul class="nav-menu">
            {{-- Home --}}
            @auth
                <li>
                    <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">Home</a>
                </li>
            @endauth

            {{-- Shop & Kategori --}}
            @auth
                <li class="dropdown">
                    <a href="/shop" class="{{ request()->is('shop*') ? 'active' : '' }}">Shop</a>
                    <ul class="dropdown-menu">
                        {{-- Link untuk lihat semua produk --}}
                        <li><a href="/shop" style="font-weight: bold; border-bottom: 1px solid #eee;">All Products</a></li>
                        
                        {{-- Looping kategori dari database --}}
                        @foreach($globalCategories as $cat)
                            <li>
                                <a href="/shop?category={{ strtolower($cat->name) }}">
                                    {{ $cat->name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </li>

                {{-- Blog --}}
                <li>
                    <a href="{{ route('blog.index') }}" class="{{ request()->routeIs('blog.*') ? 'active' : '' }}">Blog</a>
                </li>
            @endauth

            {{-- About & Contact --}}
            <li>
                <a href="/about" class="{{ request()->is('about*') ? 'active' : '' }}">About Us</a>
            </li>

            <li>
                <a href="/contact" class="{{ request()->is('contact*') ? 'active' : '' }}">Contact</a>
            </li>

            {{-- Cart dengan Badge --}}
            @auth
                <li>
                    <a href="/cart" class="nav-link {{ request()->is('cart') ? 'active' : '' }}" style="display: flex; align-items: center; gap: 5px;">
                        🛒 <span class="cart-text">Cart</span>
                        @if(session('cart') && count(session('cart')) > 0)
                            <span style="background: #e67e22; color: white; padding: 2px 7px; border-radius: 50%; font-size: 11px; font-weight: bold; line-height: 1;">
                                {{ count(session('cart')) }}
                            </span>
                        @endif
                    </a>
                </li>
                <li class="{{ request()->routeIs('order.history') ? 'active' : '' }}">
                    <a href="{{ route('order.history') }}" 
                    style="text-decoration: none; 
                            color: {{ request()->routeIs('order.history') ? '#2c9a94' : '#333' }}; 
                            font-weight: {{ request()->routeIs('order.history') ? 'bold' : 'normal' }};">
                        Riwayat Pesanan
                    </a>
                </li>
            @endauth

            {{-- Auth Links --}}
            @auth
                {{-- Profile Dropdown Icon --}}
                <li class="dropdown" style="margin-left: auto; {{ request()->routeIs('profile.*') ? 'border-bottom: 3px solid #2c9a94;' : '' }}">
                    <a href="#" style="display: flex; align-items: center; gap: 8px; color: {{ request()->routeIs('profile.*') ? '#2c9a94' : '#333' }}; font-weight: bold; font-size: 1.2rem;">
                        @if(auth()->user()->profile_photo)
                            <img src="{{ asset('assets/img/profiles/' . auth()->user()->profile_photo) }}" alt="{{ auth()->user()->name }}" style="width: 35px; height: 35px; border-radius: 50%; object-fit: cover; border: 2px solid {{ request()->routeIs('profile.*') ? '#2c9a94' : '#ddd' }};">
                        @else
                            <div style="width: 35px; height: 35px; border-radius: 50%; background: #f0fdf4; border: 2px solid #ddd; display: flex; align-items: center; justify-content: center; font-size: 1.2rem;">👤</div>
                        @endif
                    </a>
                    <ul class="dropdown-menu" style="right: 0; left: auto; min-width: 200px;">
                        <li style="padding: 10px 15px; border-bottom: 1px solid #eee;">
                            <div style="font-weight: 600; color: #1e293b;">{{ auth()->user()->name }}</div>
                            <small style="color: #94a3b8;">{{ auth()->user()->email }}</small>
                        </li>
                        @if(auth()->user()->role === 'admin')
                            <li>
                                <a href="{{ route('admin.dashboard') }}" style="color: #e74c3c;">⚙️ Admin Panel</a>
                            </li>
                        @else
                            <li>
                                <a href="{{ route('profile.show') }}" style="color: {{ request()->routeIs('profile.*') ? '#2c9a94' : '#333' }}; font-weight: {{ request()->routeIs('profile.*') ? 'bold' : 'normal' }};">👤 My Profile</a>
                            </li>
                        @endif
                        <li>
                            <form method="POST" action="{{ route('logout') }}" style="display: block;">
                                @csrf
                                <button type="submit" style="background: none; border: none; color: #e74c3c; cursor: pointer; font-weight: bold; width: 100%; text-align: left; padding: 10px 15px;">🚪 Logout</button>
                            </form>
                        </li>
                    </ul>
                </li>
            @else
                <li style="margin-left: auto;">
                    <a href="{{ route('login') }}" style="color: #2c9a94; font-weight: bold;">Login</a>
                </li>
                <li>
                    <a href="{{ route('register') }}" style="color: #2c9a94; font-weight: bold;">Daftar</a>
                </li>
            @endauth
        </ul>
    </div>
</nav>
