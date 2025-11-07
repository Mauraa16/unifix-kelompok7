<!-- Modern Header -->
<header class="modern-header">
    <nav class="nav-container">
        <div class="nav-brand">
            <a href="{{ url('/') }}" class="brand-link">
                <div class="brand-logo">
                    <span class="logo-icon">🚀</span>
                </div>
                <span class="brand-text">{{ config('app.name', 'UNIFIX') }}</span>
            </a>
        </div>

        <div class="nav-menu">
            <a href="{{ url('/') }}" class="nav-link {{ request()->is('/') ? 'active' : '' }}">
                <span>Home</span>
            </a>
            <!-- Add more navigation items as needed -->
        </div>

        <div class="nav-auth">
            @guest
                @if (Route::has('login'))
                    <a href="{{ route('login') }}" class="auth-btn login-btn">
                        <span>Login</span>
                    </a>
                @endif

                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="auth-btn register-btn">
                        <span>Register</span>
                    </a>
                @endif
            @else
                <div class="user-menu">
                    <button class="user-btn" onclick="toggleUserDropdown()">
                        <div class="user-avatar">
                            <span>{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                        </div>
                        <span class="user-name">{{ Auth::user()->name }}</span>
                        <svg class="dropdown-arrow" width="12" height="12" viewBox="0 0 12 12">
                            <path d="M3 4.5L6 7.5L9 4.5" stroke="currentColor" stroke-width="1.5" fill="none"/>
                        </svg>
                    </button>

                    <div class="user-dropdown" id="userDropdown">
                        <a href="#" class="dropdown-item">
                            <span>Profile</span>
                        </a>
                        <a href="#" class="dropdown-item">
                            <span>Settings</span>
                        </a>
                        <hr class="dropdown-divider">
                        <a class="dropdown-item logout-item" href="{{ route('logout') }}"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <span>Logout</span>
                        </a>
                    </div>
                </div>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            @endguest
        </div>

        <button class="mobile-menu-toggle" onclick="toggleMobileMenu()">
            <span class="hamburger-line"></span>
            <span class="hamburger-line"></span>
            <span class="hamburger-line"></span>
        </button>
    </nav>

    <!-- Mobile Menu -->
    <div class="mobile-menu" id="mobileMenu">
        <div class="mobile-menu-content">
            <a href="{{ url('/') }}" class="mobile-nav-link {{ request()->is('/') ? 'active' : '' }}">
                <span>Home</span>
            </a>
            <!-- Add more mobile navigation items as needed -->

            <div class="mobile-auth">
                @guest
                    @if (Route::has('login'))
                        <a href="{{ route('login') }}" class="mobile-auth-btn">
                            <span>Login</span>
                        </a>
                    @endif

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="mobile-auth-btn primary">
                            <span>Register</span>
                        </a>
                    @endif
                @else
                    <div class="mobile-user-info">
                        <div class="mobile-user-avatar">
                            <span>{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                        </div>
                        <span class="mobile-user-name">{{ Auth::user()->name }}</span>
                    </div>
                    <a href="#" class="mobile-nav-link">
                        <span>Profile</span>
                    </a>
                    <a href="#" class="mobile-nav-link">
                        <span>Settings</span>
                    </a>
                    <a class="mobile-nav-link logout-link" href="{{ route('logout') }}"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <span>Logout</span>
                    </a>
                @endguest
            </div>
        </div>
    </div>
</header>
