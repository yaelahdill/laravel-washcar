<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <img src="{{ asset('dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">WashCar</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{ asset('dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">Admin</a>
        </div>
      </div>

      {{-- <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div> --}}

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item">
            <a href="{{ asset('dashboard') }}" class="nav-link {{ ($page_url == "dashboard") ? 'active': ''}}">
              <i class="nav-icon fas fa-home"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{ route('customer') }}" class="nav-link {{ ($page_url == "customer") ? 'active': ''}}">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Customer
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{ route('merchant') }}" class="nav-link {{ ($page_url == "merchant") ? 'active': ''}}">
              <i class="nav-icon fas fa-store"></i>
              <p>
                Merchant
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{ route('service') }}" class="nav-link {{ ($page_url == "service") ? 'active': ''}}">
              <i class="nav-icon fas fa-list"></i>
              <p>
                Layanan
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{ route('voucher') }}" class="nav-link {{ ($page_url == "voucher") ? 'active': ''}}">
              <i class="nav-icon fas fa-percentage"></i>
              <p>
                Voucher
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{ route('banner') }}" class="nav-link {{ ($page_url == "banner") ? 'active': ''}}">
              <i class="nav-icon fas fa-image"></i>
              <p>
                Banner
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{ route('order') }}" class="nav-link {{ ($page_url == "order") ? 'active': ''}}">
              <i class="nav-icon fas fa-history"></i>
              <p>
                Order
              </p>
            </a>
          </li>

        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>