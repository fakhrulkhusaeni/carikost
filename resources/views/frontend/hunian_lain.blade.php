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
                <a class="nav-link" href="{{ route('frontend.hunian_lain') }}">Hunian Lain</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="{{ route('frontend.promosi') }}">Pasang Hunian</a>
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

  <!-- service section -->
  <section class="service_section layout_padding">
    <div class="service_container">
      <div class="container">
        <div class="container search-form-container">
          <div class="heading_container heading_center mb-4">
            <h2>
              <span>Cari Hunian Lain</span>
            </h2>
            <p>
              Temukan rumah dan ruko terbaik yang sesuai dengan kebutuhan Anda.
            </p>
          </div>
          <div class="row justify-content-center">
            <div class="col-lg-10 col-md-12">
              <div class="card-cari shadow h-100 border-0 rounded" style="background-color: white;">
                <form action="{{ route('frontend.hunian_lain') }}" method="GET">
                  <div class="row g-3 align-items-center p-4">
                    <!-- Input search untuk toko atau rumah -->
                    <div class="col-lg-4 col-md-6 col-12">
                      <input type="text" id="search" name="search" class="form-control"
                        placeholder="Cari disini.." style="border-radius: 5px;">
                    </div>

                    <!-- Dropdown lokasi -->
                    <div class="col-lg-2 col-md-3 col-6">
                      <select id="location" name="location" class="form-control" style="border-radius: 5px;">
                        <option value="" selected disabled>Lokasi</option>
                        <!-- Kota Tegal -->
                        <optgroup label="Kota Tegal">
                          <option value="Margadana">Margadana</option>
                          <option value="Tegal Barat">Tegal Barat</option>
                          <option value="Tegal Timur">Tegal Timur</option>
                          <option value="Tegal Selatan">Tegal Selatan</option>
                        </optgroup>
                        <!-- Kabupaten Tegal -->
                        <optgroup label="Kabupaten Tegal">
                          <option value="Adiwerna">Adiwerna</option>
                          <option value="Balapulang">Balapulang</option>
                          <option value="Bojong">Bojong</option>
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
                          <option value="Suradadi">Suradadi</option>
                          <option value="Talang">Talang</option>
                          <option value="Tarub">Tarub</option>
                          <option value="Warureja">Warureja</option>
                        </optgroup>
                      </select>
                    </div>

                    <!-- Dropdown Jenis Hunian -->
                    <div class="col-lg-2 col-md-3 col-6">
                      <select id="tipe_hunian" name="tipe_hunian" class="form-control" style="border-radius: 5px;">
                        <option value="" selected disabled>Tipe</option>
                        <option value="rumah">Rumah</option>
                        <option value="ruko">Ruko</option>
                      </select>
                    </div>

                    <!-- Dropdown status -->
                    <div class="col-lg-2 col-md-3 col-12">
                      <select id="status" name="status" class="form-control" style="border-radius: 5px;">
                        <option value="" selected disabled>Status</option>
                        <option value="Dijual">Dijual</option>
                        <option value="Disewakan">Disewakan</option>
                      </select>
                    </div>

                    <!-- Tombol pencarian -->
                    <div class="col-lg-2 col-md-4 col-12 mt-lg-0 mt-md-3">
                      <button type="submit" class="btn w-100" style="background-color: #007bff; border-radius: 10px;">
                        <i class="fa fa-search text-white"></i> <span class="text-white">Cari</span>
                      </button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>

        <div class="row mt-5">
          @forelse ($hunians as $hunianLain)
          <div class="col-md-4 mb-4">
            <div class="card h-90 shadow">
              <img src="{{ asset('storage/' . json_decode($hunianLain->foto)[0]) }}"
                class="img-fluid w-100 rounded-top"
                style="height: 200px; object-fit: cover;"
                alt="{{ $hunianLain->tipe_hunian }}">
              <div class="card-body text-start">
                <h6 class="card-title mb-2" style="color: #007bff;">{{ ucfirst($hunianLain->tipe_hunian) }}</h6>
                <p class="card-text mb-3">{{ strtoupper($hunianLain->status) }}</p>
                <ul class="list-unstyled mb-3">
                  <li><i class="bi bi-geo-alt me-2"></i> <span class="ms-2">Lokasi: {{ ucfirst($hunianLain->location) }}</span></li>
                  <li><i class="bi bi-cash me-2"></i> <span class="ms-2">Harga: Rp {{ number_format($hunianLain->harga, 0, ',', '.') }}</span></li>
                </ul>
                <!-- Skor Rekomendasi (Hidden) -->
                <p class="card-text text-muted d-none">
                  Skor Rekomendasi: <strong>{{ number_format($hunianLain->weightedScore, 2) }}</strong>
                </p>
                <!-- Tanggal Posting -->
                <div class="d-flex align-items-center mb-3">
                  <i class="bi bi-clock text-secondary" style="margin-right: 5px;"></i>
                  <span class="text-muted ms-2" style="font-size: 0.8rem;">
                    {{ $hunianLain->created_at->locale('id')->diffForHumans() }}
                  </span>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                  <a href="{{ route('frontend.detail_hunianlain', $hunianLain->id) }}" class="btn btn-primary">Lihat Detail</a>
                  <span class="verified text-primary" style="font-size: 0.80rem; cursor: pointer;">{{ ucfirst($hunianLain->status_verifikasi) }}</span>
                </div>
              </div>
            </div>
          </div>
          @empty
          <div class="col-12">
            <div class="alert alert-warning" role="alert">
              <i class="bi bi-exclamation-triangle"></i> Tidak ada data yang ditemukan.
            </div>
          </div>
          @endforelse
        </div>
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