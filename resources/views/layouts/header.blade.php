<!-- Modern Header (Slim + Navigasi Tambahan) -->
<header class="modern-header" data-aos="fade-down">
  <nav class="nav-container">
    <!-- Brand -->
    <div class="nav-brand" data-aos="fade-right">
      <a href="{{ url('/') }}" class="brand-link">
        <span class="brand-text">UNIFIX</span>
      </a>
    </div>

    <!-- Menu -->
    <div class="nav-menu" data-aos="fade-up">
      <a href="{{ url('/') }}" class="nav-link {{ request()->is('/') ? 'active' : '' }}">Home</a>
      <a href="{{ route('laporan.index') }}" class="nav-link {{ request()->is('laporan*') ? 'active' : '' }}">Kelola Laporan</a>
      <a href="{{ route('laporan.create') }}" class="nav-link {{ request()->is('laporan/create') ? 'active' : '' }}">Buat Laporan</a>
    </div>

    <!-- Auth Buttons -->
    <div class="nav-auth" data-aos="fade-left">
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
            <a href="#" class="dropdown-item"><span>Profile</span></a>
            <a href="#" class="dropdown-item"><span>Settings</span></a>
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

    <!-- Mobile Menu Button -->
    <button class="mobile-menu-toggle" onclick="toggleMobileMenu()">
      <span class="hamburger-line"></span>
      <span class="hamburger-line"></span>
      <span class="hamburger-line"></span>
    </button>
  </nav>

  <!-- Mobile Menu -->
  <div class="mobile-menu" id="mobileMenu" data-aos="fade-down">
    <div class="mobile-menu-content">
      <a href="{{ url('/') }}" class="mobile-nav-link {{ request()->is('/') ? 'active' : '' }}">Home</a>
      <a href="{{ route('laporan.index') }}" class="mobile-nav-link {{ request()->is('laporan*') ? 'active' : '' }}">Kelola Laporan</a>
      <a href="{{ route('laporan.create') }}" class="mobile-nav-link {{ request()->is('laporan/create') ? 'active' : '' }}">Buat Laporan</a>

      <div class="mobile-auth">
        @guest
          @if (Route::has('login'))
            <a href="{{ route('login') }}" class="mobile-auth-btn">Login</a>
          @endif
          @if (Route::has('register'))
            <a href="{{ route('register') }}" class="mobile-auth-btn primary">Register</a>
          @endif
        @else
          <div class="mobile-user-info">
            <div class="mobile-user-avatar">
              <span>{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
            </div>
            <span class="mobile-user-name">{{ Auth::user()->name }}</span>
          </div>
          <a href="#" class="mobile-nav-link">Profile</a>
          <a href="#" class="mobile-nav-link">Settings</a>
          <a class="mobile-nav-link logout-link" href="{{ route('logout') }}"
             onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            Logout
          </a>
        @endguest
      </div>
    </div>
  </div>
</header>

<style>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@500;600;700&display=swap');

.modern-header {
  background: linear-gradient(135deg, #6a11cb, #2575fc);
  padding: 8px 25px; /* slim version */
  color: white;
  position: sticky;
  top: 0;
  z-index: 1000;
  box-shadow: 0 3px 10px rgba(0,0,0,0.08);
  font-family: 'Poppins', sans-serif;
}

.nav-container {
  display: flex;
  justify-content: space-between;
  align-items: center;
  max-width: 1250px;
  margin: 0 auto;
}

.brand-link {
  text-decoration: none;
  color: white;
  font-weight: 700;
  font-size: 20px;
  letter-spacing: 0.5px;
  transition: transform 0.3s ease;
}

.brand-link:hover {
  transform: scale(1.04);
}

/* Nav links */
.nav-menu {
  display: flex;
  gap: 18px;
}

.nav-link {
  color: #f3f3f3;
  text-decoration: none;
  font-weight: 500;
  font-size: 14px;
  transition: 0.3s;
}

.nav-link:hover,
.nav-link.active {
  color: #fff;
  text-decoration: underline;
}

/* Auth Buttons */
.nav-auth {
  display: flex;
  gap: 10px;
}

.auth-btn {
  padding: 5px 12px;
  border-radius: 20px;
  font-weight: 600;
  font-size: 13px;
  text-decoration: none;
  transition: 0.3s;
  display: inline-flex;
  align-items: center;
  justify-content: center;
}

.login-btn {
  background: white;
  color: #6a11cb;
  border: 2px solid white;
}

.login-btn:hover {
  background: #f0f0f0;
}

.register-btn {
  background: #6a11cb;
  color: white;
  border: 2px solid transparent;
}

.register-btn:hover {
  background: #5a0fb5;
}

/* Mobile */
.mobile-menu-toggle {
  display: none;
  flex-direction: column;
  gap: 3px;
  background: none;
  border: none;
  cursor: pointer;
}

.hamburger-line {
  width: 20px;
  height: 2px;
  background: white;
}

@media (max-width: 768px) {
  .nav-menu, .nav-auth {
    display: none;
  }
  .mobile-menu-toggle {
    display: flex;
  }
  .mobile-menu {
    display: none;
    background: linear-gradient(135deg, #6a11cb, #2575fc);
    color: white;
    padding: 10px;
  }
  .mobile-menu.active {
    display: block;
  }
  .mobile-nav-link,
  .mobile-auth-btn {
    display: block;
    padding: 8px 0;
    text-decoration: none;
    color: white;
    font-size: 14px;
  }
  .mobile-auth-btn.primary {
    background: white;
    color: #6a11cb;
    border-radius: 5px;
    padding: 8px;
    margin-top: 5px;
    text-align: center;
  }
}
</style>

<script>
function toggleMobileMenu() {
  document.getElementById('mobileMenu').classList.toggle('active');
}
function toggleUserDropdown() {
  document.getElementById('userDropdown').classList.toggle('active');
}
document.addEventListener("DOMContentLoaded", () => {
  const elements = document.querySelectorAll("[data-aos]");
  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add("aos-animate");
      }
    });
  }, { threshold: 0.2 });
  elements.forEach(el => observer.observe(el));
});
</script>
