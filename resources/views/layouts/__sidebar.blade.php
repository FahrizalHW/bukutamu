<aside class="left-sidebar">
  <div>
    <div class="brand-logo d-flex align-items-center justify-content-between">
      <a href="{{ route('dashboard.index') }}" class="d-flex align-items-center gap-2 text-decoration-none">
        <img src="{{ asset('assets/images/logos/smkn4tpi.png') }}" width="42" height="42" alt="Logo SMKN 4">
        <span class="fw-bold text-dark">Buku Tamu</span>
      </a>
      <button class="btn close-btn d-xl-none sidebartoggler" id="sidebarCollapse" type="button" aria-label="Tutup navigasi">
        <i class="ti ti-x fs-7"></i>
      </button>
    </div>
    <nav class="sidebar-nav scroll-sidebar" data-simplebar>
      <ul id="sidebarnav">
        <li class="nav-small-cap"><span class="hide-menu">PENGELOLAAN</span></li>
        <li class="sidebar-item">
          <a class="sidebar-link {{ request()->routeIs('dashboard.*') ? 'active' : '' }}" href="{{ route('dashboard.index') }}">
            <i class="ti ti-layout-dashboard"></i><span class="hide-menu">Dashboard</span>
          </a>
        </li>
        <li class="sidebar-item">
          <a class="sidebar-link {{ request()->routeIs('rekap.*') ? 'active' : '' }}" href="{{ route('rekap.index') }}">
            <i class="ti ti-list-details"></i><span class="hide-menu">Rekap</span>
          </a>
        </li>
        <li class="nav-small-cap"><span class="hide-menu">KIOS</span></li>
        <li class="sidebar-item">
          <a class="sidebar-link" href="{{ route('reception.index') }}">
            <i class="ti ti-users"></i><span class="hide-menu">Penerimaan</span>
          </a>
        </li>
        <li class="sidebar-item">
          <a class="sidebar-link" href="{{ route('tamu.create') }}" target="_blank">
            <i class="ti ti-external-link"></i><span class="hide-menu">Buka Form Tamu</span>
          </a>
        </li>
      </ul>
    </nav>
  </div>
</aside>
