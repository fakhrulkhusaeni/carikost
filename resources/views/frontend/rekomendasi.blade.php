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
                    <a class="navbar-brand" href="{{ route('frontend.index') }}">
                        <span>
                            CariHunian
                        </span>
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
                            <li class="nav-item active">
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
                                <a class="nav-link" href="{{ route('dashboard') }}" style="color: #7CFC00;">{{ Auth::user()->name }}</a>
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

    <!-- service section -->
    <section class="service_section layout_padding">
        <div class="service_container">
            <div class="container">
                <div class="container search-form-container">
                    <div class="heading_container heading_center mb-4">
                        <h2>
                            <span>Rekomendasi Tempat Kost dan Kontrakan</span>
                        </h2>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-lg-10 col-md-12">
                            <div class="card-cari shadow h-100 border-0 rounded" style="background-color: white;">
                                <form action="{{ route('frontend.rekomendasi') }}" method="GET">
                                    <div class="row g-3 align-items-center p-4">

                                        <!-- Lokasi -->
                                        <div class="col-lg-12 col-md-6 col-12 mb-3">
                                            <select id="location" name="location" class="form-control" style="border-radius: 5px;" required
                                                oninvalid="this.setCustomValidity('Silakan Pilih Lokasi')"
                                                oninput="this.setCustomValidity('')">
                                                <option value="" disabled {{ request('location') ? '' : 'selected' }}>Lokasi</option>
                                                <!-- Kota Tegal -->
                                                <optgroup label="Kota Tegal">
                                                    <option value="Margadana" {{ request('location') == 'Margadana' ? 'selected' : '' }}>Margadana</option>
                                                    <option value="Tegal Barat" {{ request('location') == 'Tegal Barat' ? 'selected' : '' }}>Tegal Barat</option>
                                                    <option value="Tegal Timur" {{ request('location') == 'Tegal Timur' ? 'selected' : '' }}>Tegal Timur</option>
                                                    <option value="Tegal Selatan" {{ request('location') == 'Tegal Selatan' ? 'selected' : '' }}>Tegal Selatan</option>
                                                </optgroup>
                                                <!-- Kabupaten Tegal -->
                                                <optgroup label="Kabupaten Tegal">
                                                    @foreach(['Adiwerna', 'Balapulang', 'Bojong', 'Dukuhturi', 'Dukuhwaru', 'Jatinegara',
                                                    'Kedungbanteng', 'Kramat', 'Lebaksiu', 'Margasari', 'Pagerbarang', 'Pangkah',
                                                    'Slawi', 'Suradadi', 'Talang', 'Tarub', 'Warureja'] as $area)
                                                    <option value="{{ $area }}" {{ request('location') == $area ? 'selected' : '' }}>{{ $area }}</option>
                                                    @endforeach
                                                </optgroup>
                                            </select>
                                        </div>

                                        <!-- Jenis Hunian -->
                                        <div class="col-lg-12 col-md-6 col-12 mb-3">
                                            <select id="type" name="type" class="form-control" style="border-radius: 5px;">
                                                <option value="" disabled {{ request('type') ? '' : 'selected' }}>Tipe Hunian</option>
                                                <option value="putra" {{ request('type') == 'putra' ? 'selected' : '' }}>Kost Putra</option>
                                                <option value="putri" {{ request('type') == 'putri' ? 'selected' : '' }}>Kost Putri</option>
                                                <option value="campur" {{ request('type') == 'campur' ? 'selected' : '' }}>Kost Campur</option>
                                                <option value="kontrakan" {{ request('type') == 'kontrakan' ? 'selected' : '' }}>Kontrakan</option>
                                            </select>
                                        </div>

                                        <!-- Harga -->
                                        <div class="col-lg-12 col-md-6 col-12 mb-3">
                                            <div class="dropdown">
                                                <select class="form-control" id="pilihanHarga" style="border-radius: 5px;">
                                                    <option value="" disabled selected>Harga</option>
                                                </select>
                                                <div id="inputHargaContainer" class="mt-2" style="display: none;">
                                                    <input type="text" id="harga" name="harga" class="form-control" placeholder="Masukkan Harga (contoh: 500000)" value="{{ request('harga') }}" style="border-radius: 5px; margin-top: 5px;">
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Pilihan Fasilitas -->
                                        <div class="col-lg-12 col-md-6 col-12 mb-3">
                                            <select id="facilityDropdown" class="form-control" style="border-radius: 5px;">
                                                <option value="" disabled selected>Fasilitas</option>
                                            </select>

                                            <!-- Checkbox Fasilitas dalam Dua Kolom -->
                                            <div id="checkboxContainer" class="border p-3 rounded mt-2" style="display: none;">
                                                <div class="row">
                                                    @php
                                                    $allFacilities = [
                                                    "Kamar Mandi Dalam", "Air Panas", "Lemari Baju", "AC",
                                                    "Kursi", "Meja", "TV", "Kasur", "Mesin Cuci", "Dapur Bersama", "Parkir Mobil",
                                                    "Kloset Duduk", "Kipas Angin", "Wifi", "Parkir Motor", "CCTV", "Dispenser", "Kulkas", "Teras",
                                                    "Ruang Tamu", "Ruang Makan", "Tempat Jemur", "Kamar Mandi Luar", "Mushola"
                                                    ];
                                                    $selectedFacilities = $facilities ?? []; // Pastikan array selalu ada
                                                    @endphp

                                                    @foreach($allFacilities as $facility)
                                                    <div class="col-md-6 col-12">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" name="facilities[]" value="{{ $facility }}"
                                                                {{ in_array($facility, $selectedFacilities) ? 'checked' : '' }}>
                                                            <label class="form-check-label">{{ $facility }}</label>
                                                        </div>
                                                    </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Tombol -->
                                        <div class="col-lg-12 col-md-6 col-12 text-center">
                                            <button type="submit" class="btn w-100" style="background-color: #007bff; border-radius: 10px;">
                                                <i class="bi bi-magic text-white"></i> <span class="text-white">Cari Rekomendasi</span>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                @if(request()->has('location') || request()->has('type') || request()->has('harga') || request()->has('facilities'))
                @if(isset($kosts) && $kosts->count() > 0)
                <!-- tampilkan kost -->
                <div class="row mt-5">
                    @foreach ($kosts as $kost)
                    <div class="col-md-4 mb-4">
                        <div class="card h-90 shadow">
                            <img src="{{ asset('storage/' . json_decode($kost->foto)[0]) }}"
                                class="img-fluid w-100 rounded-top"
                                style="height: 200px; object-fit: cover;"
                                alt="{{ $kost->nama }}">
                            <div class="card-body text-start">
                                <h6 class="card-title mb-2" style="color: #007bff;">{{ ucfirst($kost->type) }}</h6>
                                <p class="card-text mb-3">{{ $kost->nama }}</p>
                                <ul class="list-unstyled mb-3">
                                    <li><i class="bi bi-geo-alt me-2"></i> <span class="ms-2">Lokasi: {{ $kost->location }}</span></li>
                                    <li><i class="bi bi-cash me-2"></i> <span class="ms-2">Harga: Rp{{ number_format((int) preg_replace('/[^0-9]/', '', $kost->harga), 0, ',', '.') }}/bulan</span></li>
                                    <li><i class="bi bi-door-closed me-2"></i> <span class="ms-2">Jumlah Kamar: {{ $kost->jumlah_kamar }}</span></li>
                                </ul>

                                <!-- Tampilkan jumlah skor -->
                                @isset($kost->bobotScore)
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="badge bg-info" style="font-size: 1rem;">Skor: {{ number_format($kost->bobotScore, 2) }}</span>
                                </div>
                                @endisset

                                <div class="d-flex justify-content-between align-items-center">
                                    <a href="{{ route('frontend.detail', $kost->id) }}" class="btn btn-primary">Lihat Detail</a>
                                    @if ($kost->verifikasi && $kost->verifikasi->status_verifikasi === 'terverifikasi')
                                    <span class="verified text-primary" style="font-size: 0.80rem; cursor: pointer;">Terverifikasi</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="row mt-5">
                    <div class="col-12">
                        <div class="alert alert-warning" role="alert">
                            <i class="bi bi-exclamation-triangle"></i> Tidak ada kost atau kontrakan yang direkomendasikan.
                        </div>
                    </div>
                </div>
                @endif
                @endif
            </div>
        </div>
    </section>
    <!-- end service section -->

    <!-- info section -->
    <section class="info_section layout_padding2">
        <div class="container">
            <div class="row">
                <!-- Info Contact -->
                <div class="col-md-6 col-lg-3 info_col">
                    <div class="info_contact">
                        <h4>Kebijakan</h4>
                        <div class="contact_link_box">
                            <a href="">
                                <span>Kebijakan privasi</span>
                            </a>
                            <a href="">
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
                &copy; <span id="displayYear"></span> Tegal Kost
            </p>
        </div>
    </section>
    <!-- footer section -->

    <!-- SweetAlert2 Script -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const verifiedIcons = document.querySelectorAll('.verified');

            verifiedIcons.forEach(icon => {
                icon.addEventListener('click', function() {
                    Swal.fire({
                        title: 'Informasi',
                        text: 'Hunian ini sudah Terverifikasi oleh Admin.',
                        icon: 'info',
                        confirmButtonText: 'OK'
                    });
                });
            });
        });
    </script>

    <script>
        document.getElementById('facilityDropdown').addEventListener('click', function() {
            let container = document.getElementById('checkboxContainer');
            container.style.display = container.style.display === 'none' ? 'block' : 'none';
        });
    </script>

    <script>
        const pilihanHarga = document.getElementById('pilihanHarga');
        const inputHargaContainer = document.getElementById('inputHargaContainer');

        pilihanHarga.addEventListener('click', function() {
            // Toggle visibility of the input field when dropdown is clicked
            if (inputHargaContainer.style.display === 'none' || inputHargaContainer.style.display === '') {
                inputHargaContainer.style.display = 'block'; // Show the input field
            } else {
                inputHargaContainer.style.display = 'none'; // Hide the input field
            }
        });
    </script>

    <script>
        const hargaInput = document.getElementById('harga');

        hargaInput.addEventListener('input', function(e) {
            let angka = e.target.value.replace(/[^0-9]/g, '');
            if (!angka) {
                e.target.value = '';
                return;
            }

            e.target.value = formatRupiah(angka);
        });

        function formatRupiah(angka) {
            let number_string = angka.toString(),
                sisa = number_string.length % 3,
                rupiah = number_string.substr(0, sisa),
                ribuan = number_string.substr(sisa).match(/\d{3}/g);

            if (ribuan) {
                let separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            return 'Rp ' + rupiah;
        }
    </script>

</body>

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