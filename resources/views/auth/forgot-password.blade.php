<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" href="assets/favicon.png" type="">

    <title>Reset Password</title>

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
                    Cari Hunian
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
                        <h3>Reset Password</h3>
                        <p>Untuk mereset kata sandi Anda, masukkan alamat email yang Anda gunakan saat mendaftar.</p>

                        <!-- Form to Request Password Reset -->
                        <form method="POST" action="{{ route('password.email') }}">
                            @csrf
                            <input style="outline: 1px solid gray; border-radius: 5px;" class="form-control" type="email" name="email" placeholder="ALamat Email Anda" value="{{ old('email') }}" required autofocus />

                            <!-- Error Message Display -->
                            @error('email')
                            <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror

                            <div class="form-button full-width mt-4">
                                <button id="submit" type="submit" class="btn btn-primary">Kirim</button>
                            </div>
                        </form>
                    </div>

                    <!-- Sent Confirmation (display after form submission) -->
                    @if (session('status'))
                    <div class="form-sent">
                        <div class="tick-holder">
                            <div class="tick-icon"></div>
                        </div>
                        <h3>Password Reset Link Sent</h3>
                        <p>
                            Please check your inbox for the password reset link.
                        </p>
                        <div class="info-holder">
                            <span>Unsure if that email address was correct?</span>
                            <a href="#">We can help</a>.
                        </div>
                    </div>
                    @endif
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