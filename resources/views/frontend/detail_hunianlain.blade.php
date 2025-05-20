@extends('../layouts.master')

@section('content')

<body class="sub_page">

    <!-- Tambahkan GLightbox atau Fancybox ke dalam proyek Anda -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">


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

                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
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


    <!-- Detail Start -->
    <div class="container-xxl py-5 wow fadeInUp" data-wow-delay="0.1s">
        <div class="container">
            <div class="card shadow rounded">
                <div class="card-body">
                    <div class="row gy-5 gx-4">
                        <!-- Left Content -->
                        <div class="col-lg-12">
                            <h4 class="mb-4 text-center">Foto Hunian</h4>
                            <div id="kostCarousel" class="carousel slide" data-bs-ride="carousel" style="margin: auto;">
                                <div class="carousel-inner">
                                    @php
                                    $images = json_decode($hunianLain->foto, true);
                                    @endphp

                                    @foreach ($images as $key => $image)
                                    <div class="carousel-item {{ $key == 0 ? 'active' : '' }}" data-bs-interval="false">
                                        <a href="{{ asset('storage/' . $image) }}" class="glightbox" data-gallery="kost-gallery">
                                            <div class="carousel-image-wrapper">
                                                <img src="{{ asset('storage/' . $image) }}"
                                                    alt="Foto Hunian {{ $key + 1 }}"
                                                    class="d-block w-100 rounded img-fluid" />
                                            </div>
                                        </a>
                                    </div>
                                    @endforeach
                                </div>

                                <!-- Navigasi -->
                                <button class="carousel-control-prev" type="button" data-bs-target="#kostCarousel" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#kostCarousel" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>
                            </div>
                        </div>
                        <!-- End Left Content -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Detail End -->


    <!-- Detail Start -->
    <div class="container-xxl py-2 mb-5 wow fadeInUp" data-wow-delay="0.1s">
        <div class="container">
            <div class="row gy-5 gx-4">
                <!-- Left Content -->
                <div class="col-lg-8 mb-4"> <!-- Added mb-4 for margin-bottom -->
                    <div class="card shadow rounded">
                        <div class="card-body">
                            <div class="mb-5">
                                <!-- Deskripsi -->
                                <h4 class="mb-3">Deskripsi</h4>
                                <p>{{ $hunianLain->deskripsi }}</p>

                                <hr class="my-4"> <!-- Garis pembatas -->

                                <!-- Fasilitas -->
                                <h4 class="mb-3">Fasilitas</h4>
                                <ul class="list-unstyled">
                                    @php
                                    $fasilitas = is_string($hunianLain->fasilitas) ? json_decode($hunianLain->fasilitas, true) : $hunianLain->fasilitas;
                                    @endphp

                                    @foreach ($fasilitas as $facility)
                                    <li class="d-flex align-items-center mb-3">
                                        <i class="fa fa-circle text-primary" style="margin-right: 15px;"></i>
                                        <span>{{ $facility }}</span>
                                    </li>
                                    @endforeach
                                </ul>

                                <hr class="my-4"> <!-- Garis pembatas -->

                                <!-- Detail Hunian -->
                                <h4 class="mb-3">Detail Hunian</h4>
                                <ul class="list-unstyled">
                                    @php
                                    $detail_hunian = is_string($hunianLain->detail_hunian) ? json_decode($hunianLain->detail_hunian, true) : $hunianLain->detail_hunian;
                                    @endphp

                                    @foreach ($detail_hunian as $details)
                                    <li class="d-flex align-items-center mb-3">
                                        <i class="fa fa-circle text-primary" style="margin-right: 15px;"></i>
                                        <span>{{ $details }}</span>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Content -->
                <div class="col-lg-4 mb-4">
                    <!-- Informasi -->
                    <div class="card shadow rounded bg-white p-4 mb-4 wow slideInUp" data-wow-delay="0.1s">
                        <h4 class="mb-4">Informasi</h4>

                        <!-- Nama Pemilik -->
                        <div class="card-item mb-3 d-flex align-items-center">
                            <i class="fa fa-user text-primary" style="margin-right: 10px;"></i>
                            <span>Nama Pemilik: {{ ucfirst($hunianLain->nama_pemilik) }}</span>
                        </div>

                        <!-- Telepom -->
                        <div class="card-item mb-3 d-flex align-items-center">
                            <i class="fa fa-phone text-primary" style="margin-right: 10px;"></i>
                            <span>Nomor Telepon: <span id="phone">{{ $hunianLain->telepon }}</span></span>
                            <button class="btn btn-sm ms-2 p-0" onclick="copyToClipboard('#phone')" style="border: none; background: none;">
                                <i class="bi bi-clipboard-check" style="font-size: 16px;"></i>
                            </button>
                        </div>

                        <!-- Tipe Hunian -->
                        <div class="card-item mb-3 d-flex align-items-center">
                            <i class="fa fa-building text-primary" style="margin-right: 10px;"></i>
                            <span>Tipe Hunian: {{ ucfirst($hunianLain->tipe_hunian) }}</span>
                        </div>

                        <!-- Status Hunian -->
                        <div class="card-item mb-3 d-flex align-items-center">
                            <i class="fa fa-tag text-primary" style="margin-right: 10px;"></i>
                            <span>Status: {{ strtoupper($hunianLain->status) }}</span>
                        </div>

                        <!-- Lokasi Kecamatan -->
                        <div class="card-item mb-3 d-flex align-items-center">
                            <i class="fa fa-map-marker-alt text-primary" style="margin-right: 10px;"></i>
                            <span>Lokasi Kecamatan: {{ ucfirst($hunianLain->location) }}</span>
                        </div>

                        <!-- Alamat Lengkap -->
                        <div class="card-item mb-3 d-flex align-items-center">
                            <i class="fa fa-home text-primary" style="margin-right: 10px;"></i>
                            <span>Alamat Lengkap: {{ ucfirst($hunianLain->alamat) }}</span>
                        </div>

                        <!-- Harga -->
                        <div class="card-item mb-3 d-flex align-items-center">
                            <i class="fa fa-money-bill-wave text-primary" style="margin-right: 10px;"></i>
                            <span>Harga: <strong>Rp{{ number_format((int) preg_replace('/[^0-9]/', '', $hunianLain->harga), 0, ',', '.') }}</strong></span>
                        </div>

                        <!-- Terverifikasi -->
                        <div class="card-item mb-3 d-flex align-items-center">
                            <i class="verified fa fa-check-circle text-primary" style="margin-right: 10px; cursor: pointer;"></i>
                            <span class="verified" style="cursor: pointer;">{{ ucfirst($hunianLain->status_verifikasi) }}</span>
                        </div>

                        <!-- Tombol Tanya Pemilik -->
                        <!-- <div class="card-item d-flex align-items-center">
                            <a href="https://wa.me/{{ '62' . substr($hunianLain->telepon, 1) }}" target="_blank" class="btn btn-primary w-100">Tanya Pemilik</a>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Detail End -->



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

    <script src="https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js"></script>

    <!-- Inisialisasi GLightbox -->
    <script>
        const lightbox = GLightbox({
            selector: '.glightbox', // Select link with 'glightbox' class
            touchNavigation: true, // Enable touch gestures
            loop: true // Enable looping between images
        });
    </script>


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
        function copyToClipboard(elementId) {
            const textToCopy = document.querySelector(elementId).innerText;
            navigator.clipboard.writeText(textToCopy).then(function() {
                // SweetAlert2 success alert
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: 'Teks telah disalin ke clipboard!',
                    showConfirmButton: false,
                    timer: 2000
                });
            }, function(err) {
                console.error('Failed to copy text: ', err);
                Swal.fire({
                    icon: 'error',
                    title: 'Oops!',
                    text: 'Gagal menyalin teks!',
                });
            });
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>


@endpush