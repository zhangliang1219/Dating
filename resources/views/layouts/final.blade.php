@include('admin.layout.header')
<body class="sidebar-mini layout-fixed">
    <div id="wrapper">
        <div class="content-wrapper">
            <section class="content">
                <div class="container-fluid">
                        @yield('content')
                </div>
            </section>
        </div>
    </div>
    @include('admin.layout.footer')        
</body>
</html> 