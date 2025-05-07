<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" href="assets/favicon.png" type="">

    <title>Login</title>

    <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('css/fontawesome-all.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('css/iofrm-style.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('css/iofrm-theme7.css') }}" />
</head>

<body>
    <div class="form-body">
        <div class="website-logo">
            <a class="navbar-brand" href="{{ route('frontend.index') }}">
                <span>
                    CariHunian
                </span>
            </a>
        </div>
        <div class="iofrm-layout">
            <div class="img-holder">
                <div class="bg"></div>
                <div class="info-holder">
                    <img src="{{ asset('assets/logo.png') }}" alt="Graphic" />
                </div>
            </div>
            <div class="form-holder">
                <div class="form-content">
                    <div class="form-items">
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
                            <div class="form-button mt-4">
                                <button id="submit" type="submit" class="btn btn-primary">Login</button>
                                @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}">Lupa Password?</a>
                                @endif
                            </div>
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