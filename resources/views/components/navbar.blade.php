<!-- header section strats -->
<header class="header_section">
    <div class="container-fluid">
        <nav class="navbar navbar-expand-lg custom_nav-container ">
            <a class="navbar-brand d-flex align-items-center gap-2" href="{{ route('frontend.index') }}">
                <img src="{{ asset('assets/icon.png') }}" alt="CariHunian Logo" style="height: 40px;" class="img-fluid">
                <span class="fw-bold fs-5 text-white mb-0">InfoKost Bahari</span>
            </a>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class=""> </span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav">
                    <li class="nav-item {{ request()->routeIs('frontend.index') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('frontend.index') }}">Home</a>
                    </li>
                    <li class="nav-item {{ request()->routeIs('frontend.rekomendasi') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('frontend.rekomendasi') }}">Rekomendasi</a>
                    </li>
                    <li class="nav-item {{ request()->routeIs('frontend.hunian_lain') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('frontend.hunian_lain') }}">Tempat Usaha</a>
                    </li>
                    <li class="nav-item {{ request()->routeIs('frontend.promosi') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('frontend.promosi') }}">Pasang Iklan</a>
                    </li>

                    @auth
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('dashboard') }}" style="color: #7CFC00;">
                            {{ explode(' ', Auth::user()->name)[0] }}
                        </a>
                    </li>
                    @endauth

                    @guest
                    <li class="nav-item">
                        <a href="{{ route('login') }}">
                            <button class="btn btn-primary">
                                <i class="fa fa-user" aria-hidden="true"></i> Login
                            </button>
                        </a>
                    </li>
                    @endguest
                </ul>
            </div>
        </nav>
    </div>
</header>
<!-- end header section -->