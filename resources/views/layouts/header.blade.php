<!-- Modern Header (Slim + Navigasi Tambahan) -->
<header class="modern-header">
  <nav class="nav-container">
    <!-- Brand -->
    <div class="nav-brand">
      <a href="{{ url('/') }}" class="brand-link">
        <span class="brand-text">UNIFIX</span>
      </a>
    </div>

    <!-- Menu -->
    <div class="nav-menu">
      @auth
        @if(auth()->user()->role == 'mahasiswa')
          <a href="{{ route('home') }}" class="nav-link {{ request()->is('home') ? 'active' : '' }}">Beranda</a>
          <a href="{{ route('laporan.index') }}" class="nav-link {{ request()->is('laporan*') ? 'active' : '' }}">Kelola Laporan</a>
        @elseif(auth()->user()->role == 'petugas')
          <a href="{{ route('petugas.dashboard') }}" class="nav-link {{ request()->is('petugas/dashboard') ? 'active' : '' }}">Dashboard</a>
          <a href="{{ route('home') }}" class="nav-link {{ request()->is('home') ? 'active' : '' }}">Beranda</a>
        @elseif(auth()->user()->role == 'admin')
          <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->is('admin/dashboard') ? 'active' : '' }}">Dashboard</a>
          <a href="{{ route('home') }}" class="nav-link {{ request()->is('home') ? 'active' : '' }}">Beranda</a>
        @endif
      @endauth
    </div>

    <!-- Auth Buttons -->
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
        {{-- =============================================== --}}
        {{-- PERBAIKAN: GANTI DROPDOWN DENGAN TOMBOL LOGOUT LANGSUNG --}}
        {{-- =============================================== --}}
        <div class="user-profile-section">
            <!-- Info Profil (Tidak bisa diklik, hanya tampilan) -->
            <div class="profile-info">
                <div class="profile-avatar">
                    <span>{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                </div>
                <span class="profile-name">{{ Auth::user()->name }}</span>
            </div>

            <!-- Tombol Logout -->
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="simple-logout-btn" title="Logout">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Keluar</span>
                </button>
            </form>
        </div>
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
  <div class="mobile-menu hidden" id="mobileMenu">
    <div class="mobile-menu-content">
      @auth
        @if(auth()->user()->role == 'mahasiswa')
          <a href="{{ route('home') }}" class="mobile-nav-link {{ request()->is('home') ? 'active' : '' }}">Beranda</a>
          <a href="{{ route('laporan.index') }}" class="mobile-nav-link {{ request()->is('laporan*') ? 'active' : '' }}">Kelola Laporan</a>
        @elseif(auth()->user()->role == 'petugas')
          <a href="{{ route('petugas.dashboard') }}" class="mobile-nav-link {{ request()->is('petugas/dashboard') ? 'active' : '' }}">Dashboard</a>
          <a href="{{ route('home') }}" class="mobile-nav-link {{ request()->is('home') ? 'active' : '' }}">Beranda</a>
        @elseif(auth()->user()->role == 'admin')
          <a href="{{ route('admin.dashboard') }}" class="mobile-nav-link {{ request()->is('admin/dashboard') ? 'active' : '' }}">Dashboard</a>
          <a href="{{ route('home') }}" class="mobile-nav-link {{ request()->is('home') ? 'active' : '' }}">Beranda</a>
        @endif
      @endauth

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
          <a href="#" class="mobile-nav-link"><i class="fas fa-user-circle"></i> Profile</a>
          <a class="mobile-nav-link logout-link" href="{{ route('logout') }}"
             onclick="event.preventDefault(); document.getElementById('logout-form-mobile').submit();">
            <i class="fas fa-sign-out-alt"></i> Keluar
          </a>
          {{-- Form Logout untuk Mobile --}}
          <form id="logout-form-mobile" action="{{ route('logout') }}" method="POST" class="hidden">
            @csrf
          </form>
        @endguest
      </div>
    </div>
  </div>
</header>

<style>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@500;600;700&display=swap');

.modern-header {
  background: linear-gradient(135deg, #6a11cb, #2575fc);
  padding: 8px 25px;
  color: white;
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
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

.nav-auth {
  display: flex;
  gap: 10px;
  align-items: center;
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

/* =============================================== */
/* == CSS BARU UNTUK PROFIL & TOMBOL LOGOUT == */
/* =============================================== */

.user-profile-section {
    display: flex;
    align-items: center;
    gap: 12px; /* Jarak antara profil dan tombol logout */
}

.profile-info {
    display: flex;
    align-items: center;
    padding: 6px 12px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 20px;
    border: 1px solid rgba(255, 255, 255, 0.2);
}

.profile-avatar {
    width: 24px;
    height: 24px;
    background-color: #ffffff;
    color: #6a11cb;
    border-radius: 50%;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 12px;
    margin-right: 8px;
}

.profile-name {
    font-size: 13px;
    font-weight: 600;
    color: white;
}

.simple-logout-btn {
    background: rgba(255, 82, 82, 0.8); /* Warna merah */
    color: white;
    padding: 8px 16px;
    border-radius: 20px;
    border: 1px solid rgba(255, 255, 255, 0.2);
    font-weight: 600;
    font-size: 13px;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 6px;
    transition: all 0.3s ease;
}

.simple-logout-btn:hover {
    background: rgba(217, 83, 79, 1); /* Merah lebih gelap saat hover */
    box-shadow: 0 2px 5px rgba(0,0,0,0.2);
}

/* =============================================== */
/* == CSS LAMA (DROPDOWN) SUDAH DIHAPUS == */
/* =============================================== */


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
    background: linear-gradient(135deg, #6a11cb, #2575fc);
    color: white;
    padding: 10px;
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
  #app {
    position: static !important;
    overflow: visible !important;
  }

  .mobile-auth {
      border-top: 1px solid rgba(255,255,255,0.2);
      padding-top: 10px;
      margin-top: 10px;
  }
  .mobile-user-info {
      display: flex;
      align-items: center;
      padding: 8px 0;
  }
  .mobile-user-avatar {
      width: 32px;
      height: 32px;
      background-color: #ffffff;
      color: #6a11cb;
      border-radius: 50%;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      font-weight: 700;
      font-size: 14px;
      margin-right: 10px;
  }
  .mobile-user-name {
      font-weight: 600;
  }
  .logout-link {
      color: #ffcdd2;
  }
}
</style>

{{-- SCRIPT LOKAL SUDAH DIHAPUS KARENA TIDAK DIPERLUKAN LAGI --}}