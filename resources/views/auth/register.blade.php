<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" href="assets/favicon.png" type="" />

    <title>Register</title>

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
                        <h3>Register</h3>
                        <p>
                            Temukan tempat kost dan kontrakan dengan mudah dan cepat.
                        </p>
                        <div class="page-links">
                            <a href="{{ route('login') }}">Login</a>
                            <a href="{{ route('register') }}" class="active">Register</a>
                        </div>
                        <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                            @csrf

                            <!-- Avatar Upload -->
                            <div class="mb-3 text-center">
                                <button type="button" id="Upload-btn" class="btn rounded-circle p-0 overflow-hidden"
                                    style="width: 100px; height: 100px; border-color: #2196F3; color: #2196F3;">
                                    <img id="File-thumbnail" src="{{ asset('assets/upload-avatar.svg') }}" class="img-fluid" alt="avatar">
                                </button>

                                <input type="file" name="avatar" id="File-upload" class="d-none" accept="image/*">
                                <div class="mt-2">
                                    <label for="File-upload" style="display: block; text-align: center;">Foto Profil</label>
                                </div>
                                <button type="button" id="Replace-photo-btn" class="btn btn-link text-blue d-none">Ganti Foto Profil</button>
                            </div>

                            <!-- Name -->
                            <input style="outline: 1px solid gray; border-radius: 5px;" class="form-control mb-4" type="text" name="name" placeholder="Nama" value="{{ old('name') }}" required
                                oninvalid="this.setCustomValidity('Silakan isi nama lengkap')"
                                oninput="this.setCustomValidity('')" />
                            @error('name')
                            <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror

                            <!-- Email -->
                            <input style="outline: 1px solid gray; border-radius: 5px;" class="form-control mb-4" type="email" name="email" placeholder="Email" value="{{ old('email') }}" required
                                oninvalid="this.setCustomValidity('Silakan isi email')"
                                oninput="this.setCustomValidity('')" />
                            @error('email')
                            <div class="text-danger mb-2">{{ $message }}</div>
                            @enderror

                            <!-- Phone Number -->
                            <input style="outline: 1px solid gray; border-radius: 5px;" class="form-control mb-4" type="text" name="phone" placeholder="Nomor Telepon" value="{{ old('phone') }}" required
                                oninvalid="this.setCustomValidity('Silakan isi nomor telepon')"
                                oninput="this.setCustomValidity('')" />
                            @error('phone')
                            <div class="text-danger mb-2">{{ $message }}</div>
                            @enderror

                            <!-- Gender -->
                            <div class="form-group mb-4">
                                <label for="gender" class="form-label">Jenis Kelamin</label>
                                <div class="d-flex align-items-center">
                                    <div class="form-check me-3">
                                        <input class="form-check-input" type="radio" name="gender" id="laki-laki" value="laki-laki" required
                                            oninvalid="this.setCustomValidity('Silakan pilih jenis kelamin')"
                                            oninput="this.setCustomValidity('')" />
                                        <label class="form-check-label" for="laki-laki">Laki-laki</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="gender" id="perempuan" value="perempuan" required
                                            oninvalid="this.setCustomValidity('Silakan pilih jenis kelamin')"
                                            oninput="this.setCustomValidity('')" />
                                        <label class="form-check-label" for="perempuan">Perempuan</label>
                                    </div>
                                </div>
                            </div>
                            @error('gender')
                            <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror

                            <!-- Password -->
                            <input style="outline: 1px solid gray; border-radius: 5px;" class="form-control mb-4" type="password" name="password" placeholder="Password" required
                                oninvalid="this.setCustomValidity('Silakan isi password')"
                                oninput="this.setCustomValidity('')" />
                            @error('password')
                            <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror

                            <!-- Confirm Password -->
                            <input style="outline: 1px solid gray; border-radius: 5px;" class="form-control mb-4" type="password" name="password_confirmation" placeholder="Konfirmasi Password" required
                                oninvalid="this.setCustomValidity('Silakan konfirmasi password')"
                                oninput="this.setCustomValidity('')" />
                            @error('password_confirmation')
                            <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror

                            <!-- Account Type -->
                            <div class="form-group mb-4">
                                <label for="account-type" class="form-label">Tipe Akun</label>
                                <div class="d-flex align-items-center">
                                    <div class="form-check me-3">
                                        <input class="form-check-input" type="radio" name="account_type" id="pemilik_kost" value="pemilik_kost" required
                                            oninvalid="this.setCustomValidity('Silakan pilih tipe akun')"
                                            oninput="this.setCustomValidity('')" />
                                        <label class="form-check-label" for="pemilik_kost">
                                            <img src="{{ asset('assets/pemilik-kost.png') }}" alt="Pemilik Kost" style="width: 25px; height: 25px;" class="me-1">Pemilik Hunian
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="account_type" id="pencari_kost" value="pencari_kost" required
                                            oninvalid="this.setCustomValidity('Silakan pilih tipe akun')"
                                            oninput="this.setCustomValidity('')" />
                                        <label class="form-check-label" for="pencari_kost">
                                            <img src="{{ asset('assets/pencari-kost.png') }}" alt="Pencari Kost" style="width: 25px; height: 25px;" class="me-1">Pencari Hunian
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-button mt-4">
                                <button type="submit" class="btn btn-primary">Register</button>
                            </div>
                        </form>


                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Menambahkan event listener untuk tombol upload foto
        document.getElementById('Upload-btn').addEventListener('click', function() {
            document.getElementById('File-upload').click();
        });

        // Menambahkan event listener untuk tombol ganti foto
        document.getElementById('Replace-photo-btn').addEventListener('click', function() {
            document.getElementById('File-upload').click();
        });

        // Menangani perubahan file input dan menampilkan pratinjau foto
        document.getElementById('File-upload').addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    // Menampilkan pratinjau gambar yang diupload
                    document.getElementById('File-thumbnail').src = e.target.result;
                    // Menampilkan tombol ganti foto setelah gambar diupload
                    document.getElementById('Replace-photo-btn').classList.remove('d-none');
                };
                reader.readAsDataURL(file);
            }
        });
    </script>

    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>
</body>

</html>