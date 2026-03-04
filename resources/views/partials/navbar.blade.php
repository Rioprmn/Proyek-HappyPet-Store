<nav class="navbar">
    <div class="navbar-container">
        <div class="navbar-logo">
            <a href="/">HappyPet Store</a>
        </div>

        <button class="hamburger" id="hamburger">
            <span></span>
            <span></span>
            <span></span>
        </button>

        <ul class="nav-menu" id="navMenu">
            @auth
                <li><a href="{{ route('dashboard') }}" class="nav-link">🏠 Home</a></li>
                <li class="dropdown">
                    <a href="/shop" class="nav-link">🛒 Shop</a>
                    <ul class="dropdown-menu">
                        <li><a href="/shop">All Products</a></li>
                        @foreach($globalCategories as $cat)
                            <li><a href="/shop?category={{ strtolower($cat->name) }}">{{ $cat->name }}</a></li>
                        @endforeach
                    </ul>
                </li>
                <li><a href="{{ route('blog.index') }}" class="nav-link">📝 Blog</a></li>
            @endauth
            <li><a href="/about" class="nav-link">ℹ️ About</a></li>
            <li><a href="/contact" class="nav-link">✉️ Contact</a></li>
            @auth
                <li><a href="/cart" class="nav-link cart-link">🛍️ Cart @if(session('cart') && count(session('cart')) > 0)<span class="badge">{{ count(session('cart')) }}</span>@endif</a></li>
                <li><a href="{{ route('order.history') }}" class="nav-link">📦 Orders</a></li>
            @endauth
        </ul>

        <div class="navbar-right">
            @auth
                <div class="profile-menu-wrapper">
                    <button class="profile-btn" id="profileBtn">
                        @if(auth()->user()->profile_photo)
                            <img src="{{ asset('assets/img/profiles/' . auth()->user()->profile_photo) }}" alt="Profile">
                        @else
                            <span class="profile-initial">{{ substr(auth()->user()->name, 0, 1) }}</span>
                        @endif
                    </button>
                    <div class="profile-menu" id="profileMenu">
                        <div class="menu-item">{{ auth()->user()->name }}</div>
                        <div class="menu-divider"></div>
                        @if(auth()->user()->role === 'admin')
                            <a href="{{ route('admin.dashboard') }}" class="menu-link">⚙️ Admin</a>
                        @else
                            <a href="{{ route('profile.show') }}" class="menu-link">👤 Profile</a>
                        @endif
                        <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                            @csrf
                            <button type="submit" class="menu-link logout-btn">🚪 Logout</button>
                        </form>
                    </div>
                </div>
            @else
                <a href="{{ route('login') }}" class="btn-login">Login</a>
                <a href="{{ route('register') }}" class="btn-register">Sign Up</a>
            @endauth
        </div>
    </div>
</nav>

<style>
    .navbar {
        background: white;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        position: sticky;
        top: 0;
        z-index: 1000;
    }

    .navbar-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        height: 70px;
    }

    .navbar-logo a {
        font-size: 1.4rem;
        font-weight: 800;
        color: #2c9a94;
        text-decoration: none;
    }

    .hamburger {
        display: none;
        flex-direction: column;
        background: none;
        border: none;
        cursor: pointer;
        gap: 5px;
        padding: 5px;
    }

    .hamburger span {
        width: 25px;
        height: 3px;
        background: #333;
        border-radius: 2px;
        transition: 0.3s;
    }

    .hamburger.active span:nth-child(1) {
        transform: rotate(45deg) translate(8px, 8px);
    }

    .hamburger.active span:nth-child(2) {
        opacity: 0;
    }

    .hamburger.active span:nth-child(3) {
        transform: rotate(-45deg) translate(7px, -7px);
    }

    .nav-menu {
        display: flex;
        list-style: none;
        gap: 5px;
        flex: 1;
        margin-left: 50px;
    }

    .nav-link {
        color: #333;
        text-decoration: none;
        font-weight: 600;
        padding: 10px 16px;
        border-radius: 6px;
        transition: all 0.3s;
        display: inline-block;
        font-size: 0.95rem;
    }

    .nav-link:hover {
        color: #2c9a94;
        background: #f0fdf4;
    }

    .dropdown {
        position: relative;
    }

    .dropdown-menu {
        display: none;
        position: absolute;
        top: 100%;
        left: 0;
        background: white;
        list-style: none;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        min-width: 200px;
        margin-top: 8px;
        overflow: hidden;
    }

    .dropdown:hover .dropdown-menu {
        display: block;
    }

    .dropdown-menu a {
        display: block;
        padding: 12px 16px;
        color: #333;
        text-decoration: none;
        transition: all 0.3s;
        font-weight: 500;
        font-size: 0.9rem;
    }

    .dropdown-menu a:hover {
        background: #f0fdf4;
        color: #2c9a94;
    }

    .badge {
        background: #ff6b6b;
        color: white;
        padding: 2px 6px;
        border-radius: 50%;
        font-size: 10px;
        font-weight: 700;
        margin-left: 4px;
    }

    .navbar-right {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .profile-menu-wrapper {
        position: relative;
    }

    .profile-btn {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        border: 2px solid #2c9a94;
        background: white;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s;
        padding: 0;
        font-weight: 700;
        color: #2c9a94;
        font-size: 1rem;
    }

    .profile-btn:hover {
        background: #f0fdf4;
    }

    .profile-btn img {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        object-fit: cover;
    }

    .profile-initial {
        font-size: 1.1rem;
    }

    .profile-menu {
        display: none;
        position: absolute;
        top: 100%;
        right: 0;
        background: white;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        min-width: 200px;
        margin-top: 8px;
        z-index: 1001;
        overflow: hidden;
    }

    .profile-menu.active {
        display: block;
    }

    .menu-item {
        padding: 12px 16px;
        color: #1e293b;
        font-weight: 600;
        font-size: 0.9rem;
    }

    .menu-divider {
        height: 1px;
        background: #e2e8f0;
    }

    .menu-link {
        display: block;
        width: 100%;
        padding: 12px 16px;
        text-align: left;
        background: none;
        border: none;
        color: #333;
        text-decoration: none;
        cursor: pointer;
        transition: all 0.3s;
        font-size: 0.9rem;
        font-weight: 500;
    }

    .menu-link:hover {
        background: #f0fdf4;
        color: #2c9a94;
    }

    .logout-btn {
        color: #e74c3c;
    }

    .btn-login, .btn-register {
        padding: 8px 16px;
        border-radius: 6px;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s;
        font-size: 0.9rem;
    }

    .btn-login {
        color: #2c9a94;
        border: 2px solid #2c9a94;
    }

    .btn-login:hover {
        background: #2c9a94;
        color: white;
    }

    .btn-register {
        background: #2c9a94;
        color: white;
    }

    .btn-register:hover {
        background: #1a7a75;
    }

    @media (max-width: 768px) {
        .hamburger {
            display: flex;
        }

        .nav-menu {
            display: none;
            position: absolute;
            top: 70px;
            left: 0;
            right: 0;
            background: white;
            flex-direction: column;
            gap: 0;
            margin-left: 0;
            border-bottom: 1px solid #e2e8f0;
            border-radius: 0;
        }

        .nav-menu.active {
            display: flex;
        }

        .nav-menu li {
            border-bottom: 1px solid #f0f0f0;
        }

        .nav-link {
            padding: 14px 20px;
            border-radius: 0;
            display: block;
        }

        .dropdown {
            position: relative;
        }

        .dropdown > .nav-link::after {
            content: ' ▼';
            font-size: 0.7rem;
        }

        .dropdown.active > .nav-link::after {
            content: ' ▲';
        }

        .dropdown-menu {
            position: static;
            display: none;
            box-shadow: none;
            background: #f9fafb;
            margin-top: 0;
            border-radius: 0;
        }

        .dropdown.active .dropdown-menu {
            display: block;
        }

        .dropdown-menu a {
            padding-left: 40px;
        }

        .navbar-container {
            height: 60px;
        }
    }      display: block;
        }

        .dropdown-menu a {
            padding-left: 40px;
        }

        .navbar-container {
            height: 60px;
        }
    }

    @media (max-width: 480px) {
        .navbar-logo a {
            font-size: 1.1rem;
        }

        .nav-menu {
            top: 60px;
        }

        .profile-btn {
            width: 36px;
            height: 36px;
            font-size: 0.9rem;
        }

        .btn-login, .btn-register {
            padding: 6px 12px;
            font-size: 0.85rem;
        }
    }
</style>

<script>
    const hamburger = document.getElementById('hamburger');
    const navMenu = document.getElementById('navMenu');
    const profileBtn = document.getElementById('profileBtn');
    const profileMenu = document.getElementById('profileMenu');

    hamburger.addEventListener('click', function() {
        this.classList.toggle('active');
        navMenu.classList.toggle('active');
    });

    profileBtn.addEventListener('click', function(e) {
        e.stopPropagation();
        profileMenu.classList.toggle('active');
    });

    document.addEventListener('click', function(e) {
        if (!e.target.closest('.profile-menu-wrapper')) {
            profileMenu.classList.remove('active');
        }
    });

    document.querySelectorAll('.dropdown').forEach(dropdown => {
        dropdown.addEventListener('click', function(e) {
            if (window.innerWidth <= 768) {
                e.preventDefault();
                this.classList.toggle('active');
            }
        });
    });
</script>
