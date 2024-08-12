<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
  <div class="app-brand demo">
    <a href="/dashboard" class="app-brand-link">
    <span class="app-brand-logo demo">
      <img src="{{ asset('assets/img/logo.png') }}" alt="" width="60">
    </span>
    <span class=" demo menu-text fw-bolder ms-2 fs-xlarge mt-3">BMKG</span>
  </a>
  
    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
      <i class="bx bx-chevron-left bx-sm align-middle"></i>
    </a>
  </div>

  <div class="menu-inner-shadow"></div>

  <ul class="menu-inner py-1 mt-5">
    <!-- Dashboard -->
    <li class="menu-item {{ Request::is('dashboard') ? 'active' : '' }}">
      <a href="/dashboard" class="menu-link ">
        <i class="menu-icon tf-icons bx bx-home-circle"></i>
        <div data-i18n="Analytics">Dashboard</div>
      </a>
    </li>

    <!-- Data -->
    @can('superadmin')

    <li class="menu-header small text-uppercase">
      <span class="menu-header-text">Data</span>
    </li>
    @endcan
    @can('admin')

    <li class="menu-header small text-uppercase">
      <span class="menu-header-text">Data</span>
    </li>
    @endcan
    @can('superadmin')
    <li class="menu-item {{ Request::is('users*') ? 'active' : '' }}">
        <a href="/users" class="menu-link">
            <i class="menu-icon tf-icons bx bx-group"></i>
            <div data-i18n="Users">Users</div>
        </a>
    </li>
    <li class="menu-item {{ Request::is('barang*') ? 'active' : '' }}">
        <a href="/barang" class="menu-link">
            <i class="menu-icon tf-icons bx bx-package"></i>
            <div data-i18n="Barang">Barang</div>
        </a>
    </li>
    @endcan

  @can('admin')
    <li class="menu-item {{ Request::is('barang*') ? 'active' : '' }}">
        <a href="/barang" class="menu-link">
            <i class="menu-icon tf-icons bx bx-package"></i>
            <div data-i18n="Barang">Barang</div>
        </a>
    </li>
  @endcan


    
    <!-- Transaction -->
    <li class="menu-header small text-uppercase"><span class="menu-header-text">Transaction</span></li>
 
    <li class="menu-item {{ Request::is('peminjaman') ? 'active' : '' }}">
      <a href="/peminjaman" class="menu-link">
        <i class="menu-icon tf-icons bx bx-archive-out"></i>
        <div data-i18n="Peminjaman">Peminjaman</div>
      </a>
    </li>
    <li class="menu-item {{ Request::is('pengembalian') ? 'active' : '' }}">
      <a href="/pengembalian" class="menu-link">
        <i class="menu-icon tf-icons bx bx-archive-in"></i>
        <div data-i18n="Pengembalian">Pengembalian</div>
      </a>
    </li>
    <li class="menu-item {{ Request::is('riwayat') ? 'active' : '' }}">
      <a href="/riwayat" class="menu-link">
        <i class="menu-icon tf-icons bx bx-history"></i>
        <div data-i18n="Riwayat">Riwayat</div>
      </a>
    </li>

  </ul>
</aside>