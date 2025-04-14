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


    <!-- Kost Detail Start -->
    <div class="container-xxl py-5 wow fadeInUp" data-wow-delay="0.1s">
        <div class="container">
            <div class="card shadow rounded">
                <div class="card-body">
                    <div class="row gy-5 gx-4">
                        <!-- Left Content -->
                        <div class="col-12">
                            <h4 class="mb-4 text-center">Foto Hunian</h4>
                            <div id="kostCarousel" class="carousel slide" data-bs-ride="carousel" style="margin: auto;">
                                <div class="carousel-inner">
                                    @php
                                    $images = json_decode($kost->foto, true);
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

    <!-- Kost Detail End -->



    <!-- Detail Start -->
    <div class="container-xxl py-2 mb-5 wow fadeInUp" data-wow-delay="0.1s">
        <div class="container">
            <div class="row gy-5 gx-4">
                <!-- Left Content -->
                <div class="col-lg-8 mb-4">
                    <div class="card shadow rounded">
                        <div class="card-body">
                            <!-- Bagian Pemilik Kost -->
                            <div class="d-flex align-items-center mb-5">
                                <img class="flex-shrink-0 img-fluid border rounded-circle" src="{{ asset('storage/' . $kost->user->avatar) }}" alt="Foto Pemilik Kost" style="width: 80px; height: 80px; margin-right: 20px;">
                                <div class="text-start">
                                    <h5 class="mb-2">Dikelola Oleh {{ $kost->user->name }}</h5>
                                    <span class="text-muted">Pemilik Hunian</span>
                                    @if ($kost->verifikasi && $kost->verifikasi->status === 'terverifikasi')
                                    <span class="verified text-primary" style="font-size: 0.85rem; cursor: pointer; display: block; margin-top: 5px;">Terverifikasi</span>
                                    @endif
                                </div>
                            </div>

                            <!-- Bagian Kost -->
                            <div class="d-flex align-items-center mb-5">
                                <div class="text-start">
                                    <h4 class="mb-2" style="font-weight: bold;">{{ $kost->nama }}</h4>
                                    <span>{{ ucfirst($kost->type) }}</span>
                                </div>
                            </div>

                            <!-- Bagian Deskripsi -->
                            <div class="mb-5">
                                <h4 class="mb-3">Deskripsi</h4>
                                <p>{{ $kost->deskripsi }}</p>

                                <hr class="my-4">

                                <h4 class="mb-3">Fasilitas</h4>
                                <ul class="list-unstyled">
                                    @php
                                    $facilities = is_string($kost->facilities) ? json_decode($kost->facilities, true) : $kost->facilities;
                                    @endphp
                                    @foreach ($facilities as $facility)
                                    <li class="d-flex align-items-center mb-3">
                                        <i class="fa fa-circle text-primary" style="margin-right: 15px;"></i>
                                        <span>{{ $facility }}</span>
                                    </li>
                                    @endforeach
                                </ul>

                                <hr class="my-4">

                                <h4 class="mb-3">Peraturan</h4>
                                <ul class="list-unstyled">
                                    @php
                                    $rules = is_string($kost->rules) ? json_decode($kost->rules, true) : $kost->rules;
                                    @endphp
                                    @foreach ($rules as $rule)
                                    <li class="d-flex align-items-center mb-3">
                                        <i class="fa fa-circle text-primary" style="margin-right: 10px;"></i>
                                        <span>{{ $rule }}</span>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>

                            <hr class="my-4">

                            <!-- Bagian Rating Interaktif -->
                            <!-- <div class="rating-container">
                                <h4>Beri Penilaian Anda</h4>
                                <div class="stars">
                                    <i class="fa fa-star" data-value="1"></i>
                                    <i class="fa fa-star" data-value="2"></i>
                                    <i class="fa fa-star" data-value="3"></i>
                                    <i class="fa fa-star" data-value="4"></i>
                                    <i class="fa fa-star" data-value="5"></i>
                                </div>
                                <p id="rating-value">Nilai: 0</p>
                                <input type="hidden" name="kost_id" id="kost_id" value="{{ $kost->id }}">
                                <button id="submit-rating" class="btn btn-primary">Kirim Rating</button>
                            </div> -->


                            <!-- Bagian Rating -->
                            <h4 class="mb-3">Rating Masyarakat</h4>
                            <div class="d-flex align-items-center mb-4">
                                <div class="text-center" style="margin-right: 30px;">
                                    <h2 style="font-weight: bold;">{{ number_format($weightedRating ?? 0, 1) }}/5</h2> <!-- Menampilkan rata-rata rating -->
                                    <div class="text-warning">
                                        @for ($i = 1; $i <= 5; $i++)
                                            @if ($i <=floor($weightedRating))
                                            <i class="fa fa-star"></i> <!-- Bintang penuh -->
                                            @elseif ($i - 0.5 <= $weightedRating)
                                                <i class="fa fa-star-half-o"></i> <!-- Setengah bintang -->
                                                @else
                                                <i class="fa fa-star-o"></i> <!-- Bintang kosong -->
                                                @endif
                                                @endfor
                                    </div>
                                    <small>{{ $totalRatings ?? 0 }} Penilaian</small> <!-- Menampilkan jumlah penilaian -->
                                </div>
                                <div style="flex-grow: 1;">
                                    <ul class="list-unstyled mb-0">
                                        @foreach ([5, 4, 3, 2, 1] as $rating)
                                        <li class="d-flex align-items-center mb-2">
                                            <span style="width: 20px; font-weight: bold;">{{ $rating }}</span>
                                            <div class="progress flex-grow-1 mx-2" style="height: 8px;">
                                                <div class="progress-bar bg-warning" role="progressbar"
                                                    style="width: {{ $totalRatings > 0 ? (($distribution[$rating] ?? 0) / $totalRatings) * 100 : 0 }}%;"
                                                    aria-valuenow="{{ $distribution[$rating] ?? 0 }}"
                                                    aria-valuemin="0"
                                                    aria-valuemax="100">
                                                </div>
                                            </div>
                                            <span>{{ $distribution[$rating] ?? 0 }}</span>
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Right Content -->
                <div class="col-lg-4 mb-4"> <!-- Added mb-4 for margin-bottom -->
                    <!-- Informasi -->
                    <div class="card shadow rounded bg-white p-4 mb-4 wow slideInUp" data-wow-delay="0.1s">
                        <h4 class="mb-4">Informasi</h4>
                        <div class="card-item mb-3 d-flex align-items-center">
                            <i class="fa fa-door-closed text-primary" style="margin-right: 10px;"></i>
                            <span class="text-success">Jumlah Kamar: {{ $kost->jumlah_kamar }}</span>
                        </div>
                        <div class="card-item mb-3 d-flex align-items-center">
                            <i class="fa fa-bed text-primary" style="margin-right: 10px;"></i>
                            @if ($kost->sisaKamar() <= 0)
                                <span class="text-danger fw-bold">Penuh</span>
                                @else
                                <span class="text-danger">Sisa Kamar: {{ $kost->sisaKamar() }}</span>
                                @endif
                        </div>

                        <div class="card-item mb-3 d-flex align-items-center">
                            <i class="fa fa-map-marker-alt text-primary" style="margin-right: 10px;"></i>
                            <span>Lokasi Kecamatan: {{ $kost->location }}</span>
                        </div>
                        <div class="card-item mb-3 d-flex align-items-center">
                            <i class="fa fa-home text-primary" style="margin-right: 10px;"></i>
                            <span>Alamat Lengkap: {{ $kost->alamat }}</span>
                        </div>
                    </div>


                    <!-- Harga Kost -->
                    <div class="card shadow rounded bg-white p-4 mb-4 wow slideInUp" data-wow-delay="0.1s">
                        <h4 class="mb-4">Harga</h4>
                        <div class="card-item mb-3">
                            <p class="m-0">Harga per bulan: <strong>Rp{{ number_format((int) preg_replace('/[^0-9]/', '', $kost->harga), 0, ',', '.') }}</strong></p>
                        </div>

                        <!-- Form Booking -->
                        <form action="{{ route('admin.pembayaran.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <!-- Tanggal Booking -->
                            <div class="card-item mb-4">
                                <label for="booking-date" class="form-label">Pilih Tanggal Mulai:</label>
                                <input type="date" class="form-control" id="booking-date" name="tanggal_booking" required>
                            </div>

                            <!-- Input Tersembunyi untuk Kost ID -->
                            <input type="hidden" name="kost_id" value="{{ $kost->id }}">

                            <!-- Tombol Tanya Pemilik -->
                            <div class="mb-3">
                                <a href="https://wa.me/{{ '62' . substr($kost->user->phone, 1) }}" target="_blank" class="btn btn-primary w-100">Tanya Pemilik</a>
                            </div>

                            <!-- Tombol Booking -->
                            <div>
                                @if(Auth::check() && auth()->user()->hasRole('pencari_kost'))
                                @if($userHasBooked)
                                <button class="btn btn-secondary w-100" disabled>Sudah Booking</button>
                                @else
                                <!-- Tombol booking yang memicu modal validasi -->
                                <button type="button" class="btn btn-success w-100" data-bs-toggle="modal" data-bs-target="#uploadModal">
                                    Ajukan Sewa
                                </button>
                                @endif
                                @else
                                <button type="button" class="btn btn-success w-100" data-bs-toggle="modal" data-bs-target="#accessModal">
                                    Ajukan Sewa
                                </button>
                                @endif
                            </div>
                        </form>
                    </div>

                    @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <!-- Modal Login atau Akses Terbatas -->
                    <div class="modal fade" id="accessModal" tabindex="-1" aria-labelledby="accessModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="accessModalLabel">Akses Diperlukan</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    @if(Auth::check())
                                    <!-- Jika pengguna sudah login, tetapi tidak memiliki peran pencari_kost -->
                                    @if(!auth()->user()->hasRole('pencari_kost'))
                                    <p>Anda harus menjadi <strong>pencari kost</strong> untuk melakukan booking.</p>
                                    @else
                                    <!-- Jika pengguna sudah login dan memiliki peran pencari_kost -->
                                    <p>Anda sudah dapat melakukan booking.</p>
                                    @endif
                                    @else
                                    <!-- Jika pengguna belum login -->
                                    <p>Untuk melanjutkan, silakan login terlebih dahulu.</p>
                                    <a href="{{ route('login') }}" class="btn btn-primary w-100">Login</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Upload Surat Keterangan -->
                    <div class="modal fade" id="uploadModal" tabindex="-1" aria-labelledby="uploadModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="uploadModalLabel">Upload Kartu Identitas (KTP/SIM)</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form id="uploadForm" method="POST" action="{{ route('admin.pembayaran.store') }}" enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" name="kost_id" value="{{ $kost->id }}">
                                        <input type="hidden" name="tanggal_booking" id="modalBookingDate">
                                        <div class="mb-3">
                                            <label for="kartu_identitas" class="form-label">Unggah KTP/SIM (PDF/JPG/PNG, max 2MB)</label>
                                            <input type="file" class="form-control" id="kartu_identitas" name="kartu_identitas" accept=".pdf,.jpg,.png" required>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-success">Konfirmasi Booking</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
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

    <script src="https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js"></script>

    <!-- Inisialisasi GLightbox -->
    <script>
        const lightbox = GLightbox({
            selector: '.glightbox',
            touchNavigation: true,
            loop: true // 
        });
    </script>

    <!-- Script untuk menyimpan tanggal booking ke dalam modal -->
    <script>
        document.querySelector("#booking-date").addEventListener("change", function() {
            document.querySelector("#modalBookingDate").value = this.value;
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

    <!-- <script>
        const stars = document.querySelectorAll('.stars i');
        const ratingValue = document.getElementById('rating-value');
        const submitButton = document.getElementById('submit-rating');
        const kostId = document.getElementById('kost_id').value;
        let userRating = 0;

        // Event listener untuk setiap bintang
        stars.forEach(star => {
            star.addEventListener('click', function() {
                userRating = this.getAttribute('data-value');
                updateStars(userRating);
                ratingValue.textContent = `Nilai: ${userRating}`;
            });
        });

        // Fungsi untuk memperbarui tampilan bintang
        function updateStars(rating) {
            stars.forEach(star => {
                if (star.getAttribute('data-value') <= rating) {
                    star.classList.add('active');
                } else {
                    star.classList.remove('active');
                }
            });
        }

        // Event listener untuk tombol submit
        submitButton.addEventListener('click', function() {
            if (userRating > 0 && kostId) {
                fetch('{{ route("rating.store") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            rating: userRating,
                            kost_id: kostId
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.message) {
                            alert(data.message);
                            if (data.message === 'Anda sudah memberikan rating untuk kost ini.') {
                                submitButton.disabled = true;
                                stars.forEach(star => star.classList.add('disabled'));
                            }
                            setTimeout(() => {
                                location.reload(); // Refresh halaman setelah rating dikirim
                            }, 1000); // Delay 1 detik sebelum refresh agar pesan bisa terbaca
                        }
                    })
                    .catch(error => {
                        console.error('Terjadi kesalahan:', error);
                        alert('Gagal mengirim rating, coba lagi nanti.');
                    });
            } else {
                alert('Silakan pilih rating terlebih dahulu');
            }
        });
    </script> -->

</body>

@endsection


@push('after-scripts')

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
<script src="{{ asset('js/detail.js') }}"></script>


@endpush