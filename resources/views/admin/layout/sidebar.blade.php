<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <span class="brand-text font-weight-light">Admin</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="info">
          <a href="#" class="d-block">Welcome {{(Auth::user()?Auth::user()->name:'')}}</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <li class="nav-item">
                <a href="{{route('adminDashboard')}}" class="nav-link">
                  <i class="nav-icon fas fa-tachometer-alt"></i>
                  <p>
                    Dashboard
                  </p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{route('userListing')}}" class="nav-link">
                  <i class="nav-icon far fa-user"></i>
                  <p>
                    User Management
                  </p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{route('advertiseListing')}}" class="nav-link">
                  <i class="fa fa-bullhorn" aria-hidden="true"></i>
                  <p>
                    Ad Management
                  </p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{route('subscriptionListing')}}" class="nav-link">
                  <i class="nav-icon fas fa-edit" aria-hidden="true"></i>
                  <p>
                    Subscription Management
                  </p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{route('subscriptionListing')}}" class="nav-link">
                  <i class="nav-icon fa fa-cog" aria-hidden="true"></i>
                  <p>
                    General Settings
                  </p>
                  <i class="right fas fa-angle-left"></i>
                </a>
                <ul class="nav nav-treeview" style="display: none;">
                    <li class="nav-item">
                      <a href="{{route('userInfoPrivacyView')}}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>User Info Privacy</p>
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