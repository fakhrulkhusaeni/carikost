<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" href="assets/icon.png" type="">

    <title>InfoKosTegal | Login</title>

    <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('css/fontawesome-all.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('css/iofrm-style.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('css/iofrm-theme7.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('css/custom.css') }}" />

    <!-- CDN Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

</head>

<body>
    <div class="form-body">
        <div class="website-logo">
            <a class="navbar-brand" href="{{ route('frontend.index') }}">
                <span>
                    InfoKosTegal
                </span>
            </a>
        </div>
        <div class="iofrm-layout">
            <div class="img-holder">
                <div class="bg"></div>
                <div class="info-holder">
                    <img src="{{ asset('assets/logo-login.png') }}" alt="Graphic" />
                </div>
            </div>
            <div class="form-holder">
                <div class="form-content">
                    <div class="form-items">

                        @if ($errors->any())
                        <div class="alert alert-danger mt-2">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif


                        <h3>Login</h3>
                        <p>
                            Temukan tempat kost dan kontrakan dengan mudah dan cepat.
                        </p>
                        <div class="page-links">
                            <a href="{{ route('login') }}" class="active">Login</a>
                            <a href="{{ route('register') }}">Register</a>
                        </div>
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <input class="form-control" type="email" name="email" placeholder="Email" value="{{ old('email') }}"
                                style="outline: 1px solid gray; border-radius: 5px;" required
                                oninvalid="this.setCustomValidity('Silakan isi email')"
                                oninput="this.setCustomValidity('')" />
                            <input class="form-control mt-4" type="password" name="password" placeholder="Password"
                                style="outline: 1px solid gray; border-radius: 5px;" required
                                oninvalid="this.setCustomValidity('Silakan isi password')"
                                oninput="this.setCustomValidity('')" />
                            {{-- Tombol Login --}}
                            <div class="d-grid gap-2 mt-3">
                                <button id="submit" type="submit" class="btn btn-primary w-100">
                                    Login
                                </button>

                                {{-- Tombol Login dengan Google --}}
                                <a href="{{ route('google.login') }}" class="btn btn-danger w-100 d-flex align-items-center justify-content-center" style="gap: 8px;">
                                    <i class="fab fa-google"></i> Login dengan Google
                                </a>
                            </div>

                            {{-- Lupa Password --}}
                            @if (Route::has('password.request'))
                                <div class="text-end mt-2">
                                    <a href="{{ route('password.request') }}" class="text-decoration-none">Lupa Password?</a>
                                </div>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>
</body>

</html>