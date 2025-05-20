@extends('../layouts.master')

@section('content')

<body class="sub_page">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">


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

    <!-- why section -->
    <section class="layout_padding">
        <div class="container">
            <div class="heading_container heading_center mb-5">
                <h2>Kebijakan <span>Privasi</span></h2>
                <p>Kami menghargai privasi Anda. Berikut adalah kebijakan privasi kami untuk penggunaan aplikasi CariHunian.</p>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="card shadow-sm p-4">
                        <h5>1. Data Pribadi</h5>
                        <p>Kami mengumpulkan data pribadi seperti nama lengkap, email, dan nomor telepon ketika Anda mendaftar, mengajukan pertanyaan, atau menggunakan fitur tertentu dalam website kami.</p>

                        <h5 class="mt-3">2. Penggunaan Informasi</h5>
                        <p>Informasi yang Anda berikan digunakan untuk mempermudah proses pencarian kost dan kontrakan, menampilkan rekomendasi yang sesuai, serta memberikan layanan dan informasi yang relevan kepada Anda.</p>

                        <h5 class="mt-3">3. Perlindungan Data</h5>
                        <p>Kami menjaga keamanan data pengguna melalui sistem yang terlindungi dan tidak membagikan informasi pribadi kepada pihak ketiga tanpa izin dari pengguna, kecuali jika diwajibkan oleh hukum.</p>

                        <h5 class="mt-3">4. Cookie</h5>
                        <p>Website kami menggunakan cookie untuk menyimpan preferensi pengguna, meningkatkan pengalaman saat menjelajah, serta membantu kami dalam menganalisis penggunaan layanan agar terus dapat berkembang.</p>

                        <h5 class="mt-3">5. Persetujuan</h5>
                        <p>Dengan menggunakan layanan pada website ini, Anda menyatakan telah membaca, memahami, dan menyetujui seluruh ketentuan dalam kebijakan privasi ini.</p>

                        <h5 class="mt-3">6. Perubahan Kebijakan</h5>
                        <p>Kami dapat memperbarui kebijakan privasi ini sewaktu-waktu. Setiap perubahan akan diumumkan melalui website agar pengguna dapat mengetahui informasi terbaru mengenai perlindungan data pribadi mereka.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- end why section -->


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
                &copy; <span id="displayYear"></span> Tegal Kost
            </p>
        </div>
    </section>
    <!-- footer section -->


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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


@endpush