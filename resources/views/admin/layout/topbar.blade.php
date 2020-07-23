<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Right navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>
    <ul class="navbar-nav ml-auto">
      <!-- Messages Dropdown Menu -->
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
              <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-sms dropdown-menu-right">
                <div class="media">
                    <div class="media-body dropdown-item dropdown-header p-0">
                        <h5><a href="{{ route('adminLogout') }}">Logout</a></h5>
                    </div>
                </div>
            </div>
        </li> 
    </ul>
  </nav>