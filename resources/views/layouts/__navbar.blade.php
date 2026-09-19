<header class="app-header">
  <nav class="navbar navbar-expand-lg navbar-light">
    <button class="btn nav-icon-hover d-xl-none" id="headerCollapse" type="button" aria-label="Buka navigasi">
      <i class="ti ti-menu-2"></i>
    </button>
    <div class="navbar-collapse justify-content-end px-0">
      <ul class="navbar-nav flex-row ms-auto align-items-center">
        <li class="nav-item me-3 text-end d-none d-sm-block">
          <strong class="d-block">{{ auth()->user()->full_name ?: auth()->user()->username }}</strong>
          <span class="text-muted small">Superadmin</span>
        </li>
        <li class="nav-item dropdown">
          <button class="btn nav-icon-hover p-0 border-0" data-bs-toggle="dropdown" aria-expanded="false"
            aria-label="Menu akun">
            <img src="{{ asset('assets/images/profile/user-1.jpg') }}" alt="" width="38" height="38"
              class="rounded-circle">
          </button>
          <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up">
            <div class="message-body">
              <a href="{{ route('profile.edit') }}" class="d-flex align-items-center gap-2 dropdown-item">
                <i class="ti ti-user"></i><span>Profil</span>
              </a>
              <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="d-flex align-items-center gap-2 dropdown-item text-danger">
                  <i class="ti ti-logout"></i><span>Keluar</span>
                </button>
              </form>
            </div>
          </div>
        </li>
      </ul>
    </div>
  </nav>
</header>
