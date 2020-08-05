<header class="fixed-top">
    <div class="container-fluid">
        <div class="menu">
            <nav class="navbar navbar-expand-lg">
                <a class="navbar-brand" href="{{route('home')}}">
                    <img src="{{ asset('images/logo.png')}}" alt="">
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText"
                    aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                @if(Auth::user())
                <div class="collapse navbar-collapse" id="navbarText">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item active">
                            <a class="nav-link" href="{{route('home')}}">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('profileInfo') }}">Profile</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('viewSearchProfile')}}">Search</a>
                        </li>
                    </ul>
                </div>
                @endif
                <ul class="navbar-nav ml-auto">
<!--                    <li class="nav-item">
                        <a class="nav-link" href="{{route('viewSearchProfile')}}"><ion-icon name="search-outline"></ion-icon></a>
                    </li>-->
                    @if(Auth::user())
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault();
                                     document.getElementById('logout-form').submit();">Logout</a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </li>
                    @else
                        <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Login</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Register</a></li>                            
                    @endif
                </ul>
            </nav>
        </div>
    </div>
</header>