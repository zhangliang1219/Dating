@include('layouts.header')

<body>
  <div class="page">
      @yield('content')
  </div>
  @include('layouts.js')
</body>

</html>
{{-- <body class="sidebar-mini layout-fixed">
    <ul class="nav nav-pills nav-sidebar flex-column col-3" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item has-treeview ">
            <a href="#" class="nav-link active">
              <i class="nav-icon fas fa-edit"></i>
              <p>
                Language
                <span class="caret"></span>
              </p>
            </a>
            <ul class="nav nav-treeview" >
              <li class="nav-item">
                <a href="{{ url('locale/en') }}" class="nav-link active">
<p>English</p>
</a>
</li>
<li class="nav-item">
  <a href="{{ url('locale/fr') }}" class="nav-link active">
    <p>French</p>
  </a>
</li>
</ul>
</li>
</ul>
<div id="wrapper">
  <div class="content-wrapper">
    <section class="content">
      <div class="container-fluid">
        @yield('content')
      </div>
    </section>
  </div>
</div>
@include('layouts.footer')
</body>

</html> --}}