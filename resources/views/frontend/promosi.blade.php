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
                <a class="nav-link" href="{{ route('frontend.hunian_lain') }}">Hunian Lain</a>
              </li>
              <li class="nav-item active">
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

  <!-- why section -->

  <section class="package_and_howto_section layout_padding">
    <div class="container">

      <!-- Cara Pasang Hunian -->
      <div class="heading_container heading_center mb-5">
        <h2 class="mb-2">
          Cara Pasang <span>Iklan Hunian</span>
        </h2>
        <p>Panduan untuk mempublikasikan hunian ruko dan kios Anda untuk Dijual atau Disewakan.</p>
      </div>
      <div class="row">
        <!-- Step 1 -->
        <div class="col-md-3 col-sm-6 mb-4">
          <div class="card text-center shadow-sm h-100">
            <div class="card-body">
              <img src="assets/cara-pasang-1.svg" alt="Step 1" class="img-fluid mb-3" style="max-height: 100px;">
              <h5 class="card-title">Klik Tombol</h5>
              <p class="card-text">
                Klik tombol "Pasang Iklan" untuk menghubungi kami melalui WhatsApp.
              </p>
            </div>
          </div>
        </div>
        <!-- Step 2 -->
        <div class="col-md-3 col-sm-6 mb-4">
          <div class="card text-center shadow-sm h-100">
            <div class="card-body">
              <img src="assets/cara-pasang-2.svg" alt="Step 2" class="img-fluid mb-3" style="max-height: 100px;">
              <h5 class="card-title">Kirim Informasi</h5>
              <p class="card-text">
                Kirimkan informasi detail hunian ruko atau kios Anda melalui chat WhatsApp.
              </p>
            </div>
          </div>
        </div>
        <!-- Step 3 -->
        <div class="col-md-3 col-sm-6 mb-4">
          <div class="card text-center shadow-sm h-100">
            <div class="card-body">
              <img src="assets/cara-pasang-3.svg" alt="Step 3" class="img-fluid mb-3" style="max-height: 100px;">
              <h5 class="card-title">Pembayaran</h5>
              <p class="card-text">
                Setelah informasi dikirim, Anda akan menerima instruksi pembayaran <strong>Rp30.000</strong>.
              </p>
            </div>
          </div>
        </div>
        <!-- Step 4 -->
        <div class="col-md-3 col-sm-6 mb-4">
          <div class="card text-center shadow-sm h-100">
            <div class="card-body">
              <img src="assets/cara-pasang-4.svg" alt="Step 4" class="img-fluid mb-3" style="max-height: 100px;">
              <h5 class="card-title">Publikasi Hunian</h5>
              <p class="card-text">
                Apabila pembayaran sudah dilakukan, hunian ruko atau kios Anda akan dipublikasikan.
              </p>
            </div>
          </div>
        </div>
      </div>

      <!-- Button di bawah -->
      <div class="text-center mt-3">
        <a href="https://wa.me/62895704307742?text=Halo,%20saya%20tertarik%20untuk%20pasang%20iklan%20hunian.%0A
          Mohon%20informasikan%20syarat%20dan%20biayanya.%0A
          Terima%20kasih."
          class="btn btn-primary" target="_blank">
          Pasang Iklan Hunian Anda
        </a>
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
            <h4>Info</h4>
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
              <a href="https://wa.me/nomor_telepon_anda" target="_blank">
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