<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" href="assets/icon.png" type="" />

    <title>InfoKosTegal | Tipe Akun</title>

    <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('css/fontawesome-all.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('css/iofrm-style.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('css/iofrm-theme7.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('css/custom.css') }}" />
</head>

<body>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h3 class="mb-4 text-center">Pilih Tipe Akun</h3>

                    <form method="POST" action="{{ route('select-role.store') }}">
                        @csrf

                        <div class="form-group mb-4">
                            <label for="account_type">Tipe Akun</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="account_type" id="pemilik_kost" value="pemilik_kost" required>
                                <label class="form-check-label" for="pemilik_kost">Pemilik Hunian</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="account_type" id="pencari_kost" value="pencari_kost" required>
                                <label class="form-check-label" for="pencari_kost">Pencari Hunian</label>
                            </div>
                        </div>

                        <div class="form-group text-center">
                            <button class="btn btn-primary w-100" type="submit">Lanjutkan</button>
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




