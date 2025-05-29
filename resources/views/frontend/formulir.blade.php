@extends('../layouts.master')

@section('content')

<body class="sub_page">

    <div class="hero_area">

        <div class="hero_bg_box">

        </div>

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
                        <ul class="navbar-nav  ">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('frontend.index') }}">Home</a>
                            </li>
                            <!-- <li class="nav-item">
                                <a class="nav-link" href="{{ route('frontend.request') }}">Request</a>
                            </li> -->
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('frontend.rekomendasi') }}">Rekomendasi</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('frontend.hunian_lain') }}">Hunian Lain</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('frontend.promosi') }}">Pasang Iklan</a>
                            </li>

                            @auth
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('dashboard') }}" style="color: #7CFC00;">{{ explode(' ', Auth::user()->name)[0] }}</a>
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
    </div>


    <section class="request_section layout_padding">
        <div class="container">
            <div class="heading_container heading_center mb-5">
                <h2>
                    Input <span>Detail Hunian</span>
                </h2>
                <p>Isi form berikut untuk menambahkan informasi hunian Anda.</p>
            </div>
            <div class="card shadow">
                <div class="card-body">
                    <form id="propertyForm" action="#" method="post" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="owner_name" class="form-label">Nama Pemilik</label>
                            <input type="text" class="form-control" id="owner_name" name="owner_name" placeholder="Masukkan nama anda" required>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Masukkan email anda" required>
                        </div>

                        <div class="mb-3">
                            <label for="phone" class="form-label">Nomor Telepon</label>
                            <input type="text" class="form-control" id="phone" name="phone" placeholder="Masukkan nomor telepon" required>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Deskripsi</label>
                            <textarea class="form-control" id="description" name="description" placeholder="Masukkan deskripsi hunian" rows="3" required></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="type" class="form-label">Tipe Hunian</label>
                            <select class="form-control" id="type" name="type" required>
                                <option value="" disabled selected>Pilih Tipe Hunian</option>
                                <option value="rumah">Rumah</option>
                                <option value="ruko">Ruko</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="price" class="form-label">Harga</label>
                            <input type="number" class="form-control" id="price" name="price" placeholder="Masukkan harga (dijual/disewakan per-bulan)" required>
                        </div>

                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-control" id="status" name="status" required>
                                <option value="" disabled selected>Pilih status</option>
                                <option value="dijual">Dijual</option>
                                <option value="disewakan">Disewakan</option>
                            </select>
                        </div>

                        <!-- Lokasi Kecamatan -->
                        <div class="mb-3">
                            <label for="location" class="form-label">Lokasi Kecamatan</label>
                            <select name="location" id="location" class="form-control rounded-lg" required>
                                <option value="" disabled selected>Pilih Lokasi Kecamatan</option>

                                <!-- Kota Tegal -->
                                <optgroup label="Kota Tegal">
                                    <option value="Margadana">Margadana</option>
                                    <option value="Tegal Barat">Tegal Barat</option>
                                    <option value="Tegal Selatan">Tegal Selatan</option>
                                    <option value="Tegal Timur">Tegal Timur</option>
                                </optgroup>

                                <!-- Kabupaten Tegal -->
                                <optgroup label="Kabupaten Tegal">
                                    <option value="Adiwerna">Adiwerna</option>
                                    <option value="Balapulang">Balapulang</option>
                                    <option value="Bojong">Bojong</option>
                                    <option value="Bumijawa">Bumijawa</option>
                                    <option value="Dukuhturi">Dukuhturi</option>
                                    <option value="Dukuhwaru">Dukuhwaru</option>
                                    <option value="Jatinegara">Jatinegara</option>
                                    <option value="Kedungbanteng">Kedungbanteng</option>
                                    <option value="Kramat">Kramat</option>
                                    <option value="Lebaksiu">Lebaksiu</option>
                                    <option value="Margasari">Margasari</option>
                                    <option value="Pagerbarang">Pagerbarang</option>
                                    <option value="Pangkah">Pangkah</option>
                                    <option value="Slawi">Slawi</option>
                                    <option value="Surodadi">Surodadi</option>
                                    <option value="Talang">Talang</option>
                                    <option value="Tarub">Tarub</option>
                                    <option value="Warureja">Warureja</option>
                                </optgroup>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="full_address" class="form-label">Alamat Lengkap</label>
                            <textarea class="form-control" id="full_address" name="full_address" placeholder="Masukkan alamat lengkap" rows="3" required></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="details" class="form-label">Detail Hunian</label>
                            <textarea class="form-control" id="details" name="details" placeholder="Masukkan detail hunian" rows="3" required></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="facility" class="form-label">Fasilitas</label>
                            <textarea class="form-control" id="facility" name="facility" placeholder="Masukkan fasilitas hunian" rows="3" required></textarea>
                        </div>

                        <!-- Upload Bukti Kepemilikan SHM -->
                        <div class="mb-3">
                            <label for="shm" class="form-label">Upload Bukti Kepemilikan (SHM)</label>
                            <input type="file" class="form-control" id="shm" name="shm" accept=".pdf,.jpg,.jpeg,.png" required>
                            <p class="text-muted mt-1">Format: PDF, JPG, JPEG, PNG.</p>
                        </div>

                        <!-- Upload Kartu Identitas (KTP/SIM) -->
                        <div class="mb-3">
                            <label for="identity" class="form-label">Upload Kartu Identitas (KTP/SIM)</label>
                            <input type="file" class="form-control" id="identity" name="identity" accept=".pdf,.jpg,.jpeg,.png" required>
                            <p class="text-muted mt-1">Format: PDF, JPG, JPEG, PNG.</p>
                        </div>

                        <div class="mb-3">
                            <label for="foto" class="form-label">Foto Hunian</label>
                            <div id="foto-container" class="flex flex-col gap-y-2">
                                <!-- Input foto baru akan ditambahkan di sini -->
                            </div>
                            <button type="button" id="add-foto" class="btn btn-secondary mt-2">Tambah Foto</button>
                            <p class="text-muted mt-2">Maksimal 10 foto hunian.</p>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Kirim</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- info section -->

    <section class="info_section layout_padding2">
        <div class="container">
            <div class="row">
                <!-- Info Contact -->
                <div class="col-md-6 col-lg-3 info_col">
                    <div class="info_contact">
                        <h4>Kebijakan</h4>
                        <div class="contact_link_box">
                            <a href="{{ route('frontend.kebijakan_privasi') }}">
                                <span>Kebijakan privasi</span>
                            </a>
                            <a href="{{ route('frontend.syarat_ketentuan') }}">
                                <span>Syarat dan ketentuan umum</span>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Info Detail -->
                <div class="col-md-6 col-lg-3 mx-auto info_col">
                    <div class="info_detail">
                        <h4>Tentang Kami</h4>
                        <p>
                            Aplikasi ini membantu Anda menemukan kost terbaik yang sesuai dengan kebutuhan. Jelajahi berbagai pilihan kost dengan mudah dan cepat.
                        </p>
                    </div>
                </div>

                <!-- Social Media Links -->
                <div class="col-md-6 col-lg-3 mx-auto info_col">
                    <div class="info_link_box">
                        <h4>
                            Hubungi Kami
                        </h4>
                        <div class="info_links">
                            <a href="#">
                                <i class="fa fa-facebook" aria-hidden="true"></i>
                                <span>Facebook</span>
                            </a>
                            <a href="#">
                                <i class="fa fa-instagram" aria-hidden="true"></i>
                                <span>Instagram</span>
                            </a>
                            <a href="https://wa.me/62895704307742" target="_blank">
                                <i class="fa fa-whatsapp" aria-hidden="true"></i>
                                <span>WhatsApp</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- end info section -->

    <!-- footer section -->
    <section class="footer_section">
        <div class="container">
            <p>
                &copy; <span id="displayYear"></span> InfoKost Bahari
            </p>
        </div>
    </section>
    <!-- footer section -->

</body>


<!-- SweetAlert2 Library -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.getElementById('add-foto').addEventListener('click', function() {
        const fotoContainer = document.getElementById('foto-container');
        const currentFotos = fotoContainer.querySelectorAll('input[type="file"]').length;

        // Batasi penambahan foto hingga 10
        if (currentFotos < 10) {
            // Membuat div baru untuk foto dan tombol hapus
            const fotoDiv = document.createElement('div');
            fotoDiv.className = 'flex items-center gap-x-2 mt-2';

            // Membuat input file
            const input = document.createElement('input');
            input.type = 'file';
            input.name = 'foto[]';
            input.className = 'block w-full p-2 border border-gray-300 rounded';
            input.accept = 'image/*';

            // Membuat tombol hapus
            const deleteButton = document.createElement('button');
            deleteButton.type = 'button';
            deleteButton.className = 'btn btn-danger btn-sm';
            deleteButton.textContent = 'Hapus';

            // Menambahkan event untuk tombol hapus
            deleteButton.addEventListener('click', function() {
                fotoDiv.remove();
            });

            // Menambahkan input dan tombol hapus ke dalam div fotoDiv
            fotoDiv.appendChild(input);
            fotoDiv.appendChild(deleteButton);

            // Menambahkan div fotoDiv ke dalam foto-container
            fotoContainer.appendChild(fotoDiv);
        } else {
            // Menampilkan pop-up SweetAlert2 jika sudah mencapai batas 10 foto
            Swal.fire({
                title: 'Maksimal 10 Foto!',
                text: 'Anda sudah mencapai batas maksimum foto yang dapat diunggah.',
                icon: 'warning',
                confirmButtonText: 'OK'
            });
        }
    });
</script>

@endsection


@push('after-scripts')

<!-- jQery -->
<script type="text/javascript" src="js/jquery-3.4.1.min.js"></script>
<!-- popper js -->
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
    integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
</script>
<!-- bootstrap js -->
<script type="text/javascript" src="js/bootstrap.js"></script>
<!-- owl slider -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js">
</script>
<!-- custom js -->
<script type="text/javascript" src="js/custom.js"></script>
<!-- Google Map -->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCh39n5U-4IoWpsVGUHWdqB6puEkhRLdmI&callback=myMap">
</script>
<!-- End Google Map -->

@endpush