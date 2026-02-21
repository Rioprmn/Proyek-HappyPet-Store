<nav class="navbar">
    <div class="container">
        <div class="logo">
            <a href="/">HappyPet Store</a>
        </div>

        <ul class="nav-menu">
            {{-- Home --}}
            <li>
                <a href="/" class="{{ request()->is('/') ? 'active' : '' }}">Home</a>
            </li>

            {{-- Shop & Kategori --}}
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
                <a href="/blog" class="{{ request()->is('blog*') ? 'active' : '' }}">Blog</a>
            </li>

            {{-- About --}}
            <li>
                <a href="/about" class="{{ request()->is('about*') ? 'active' : '' }}">About Us</a>
            </li>

            {{-- Contact --}}
            <li>
                <a href="/contact" class="{{ request()->is('contact*') ? 'active' : '' }}">Contact</a>
            </li>

            {{-- Cart dengan Badge --}}
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
        </ul>
    </div>
</nav>