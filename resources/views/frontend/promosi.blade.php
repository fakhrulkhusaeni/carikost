@extends('../layouts.master')

@section('content')

<body class="sub_page">

  <div class="hero_area">

    <div class="hero_bg_box">

    </div>

    <x-navbar />

  </div>

  <!-- why section -->

  <section class="package_and_howto_section layout_padding">
    <div class="container">

      <!-- Cara Pasang Hunian -->
      <div class="heading_container heading_center mb-5">
        <h2 class="mb-2">
          Cara <span>Pasang Iklan</span> Tempat Usaha
        </h2>
        <p>Panduan untuk mempublikasikan tempat usaha ruko dan kios Anda untuk Dijual atau Disewakan.</p>
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
                Kirimkan informasi detail tempat usaha ruko atau kios Anda melalui chat WhatsApp.
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
                Apabila pembayaran sudah dilakukan, tempat usaha ruko atau kios Anda akan dipublikasikan.
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
          Pasang Iklan Disini...
        </a>
      </div>

    </div>
  </section>
  <!-- end why section -->

  <!-- footer section -->
  <x-footer />
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