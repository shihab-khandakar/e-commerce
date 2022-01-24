<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <img src="{{asset('images/admin_images/AdminLTELogo.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">E-Commerce</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{asset('images/admin_images/admin_photos/6523.jpg')}}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">{{ucwords(Auth::guard('admin')->user()->name)}}</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

          <li class="nav-item">

            @if (Session::get('page')=='dashboard')
            <?php $active = 'active'; ?>
            @else
            <?php $active = ""; ?>
            @endif

            <a href="/admin/dashboard" class="nav-link {{$active}}">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              
              <p>
                Dashboard
              </p>
            </a>
          </li>

          @if (Session::get('page')=='update-admin-details' || Session::get('page')=='update-admin-password')
            <?php $active = 'active'; ?>
            @else
            <?php $active = ""; ?>
          @endif

          <li class="nav-item has-treeview menu-open">
            <a href="#" class="nav-link {{$active}} ">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Settings
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">

              @if (Session::get('page')=='update-admin-details')
                <?php $active = 'active'; ?>
                @else
                <?php $active = ""; ?>
              @endif

              <li class="nav-item">
                <a href="/admin/update-admin-details" class="nav-link {{$active}}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Update Admin Details</p>
                </a>
              </li>

              @if (Session::get('page')=='update-admin-password')
                <?php $active = 'active'; ?>
                @else
                <?php $active = ""; ?>
              @endif
              
              <li class="nav-item">
                <a href="/admin/update-admin-password" class="nav-link {{$active}}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Update Admin Password</p>
                </a>
              </li>
            </ul>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>