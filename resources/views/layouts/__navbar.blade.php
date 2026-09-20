@php
  $userName = auth()->user()->full_name ?: auth()->user()->username;
  $userInitials = collect(preg_split('/\s+/', trim($userName)))
    ->filter()
    ->take(2)
    ->map(fn ($part) => mb_strtoupper(mb_substr($part, 0, 1)))
    ->implode('');
@endphp

<header class="app-header">
  <nav class="navbar navbar-expand-lg navbar-light">
    <button class="btn nav-icon-hover d-xl-none" id="headerCollapse" type="button" aria-label="Buka navigasi">
      <i class="ti ti-menu-2"></i>
    </button>
    <div class="navbar-collapse justify-content-end px-0">
      <ul class="navbar-nav flex-row ms-auto align-items-center">
        <li class="nav-item dropdown account-menu">
          <button class="btn account-menu-trigger p-0 border-0" data-bs-toggle="dropdown" data-bs-display="static"
            aria-expanded="false" aria-controls="account-dropdown-menu" aria-label="Menu akun">
            <span class="user-initials" aria-hidden="true">{{ $userInitials }}</span>
          </button>
          <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up account-dropdown"
            id="account-dropdown-menu">
            <a href="{{ route('profile.edit') }}" class="account-summary dropdown-item">
              <span class="user-initials" aria-hidden="true">{{ $userInitials }}</span>
              <span class="account-name">{{ $userName }}</span>
            </a>
            <div class="dropdown-divider m-0"></div>
            <form action="{{ route('logout') }}" method="POST" class="m-0">
              @csrf
              <button type="submit" class="account-logout dropdown-item">
                <i class="ti ti-logout" aria-hidden="true"></i>
                <span>Keluar</span>
              </button>
            </form>
          </div>
        </li>
      </ul>
    </div>
  </nav>
</header>
