@extends('../layouts.master')

@section('content')

<body class="sub_page">

    <!-- Tambahkan GLightbox atau Fancybox ke dalam proyek Anda -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">


    <div class="hero_area">

        <div class="hero_bg_box">

        </div>

        <x-navbar />

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
                            <div id="kostCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="3000" style="margin: auto;">
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
                                    @if ($kost->verifikasi && $kost->verifikasi->status_verifikasi === 'terverifikasi')
                                    <span class="verified text-primary" style="font-size: 0.85rem; cursor: pointer; display: block; margin-top: 5px;">Terverifikasi</span>
                                    @endif
                                </div>
                            </div>

                            <!-- Bagian Kost -->
                            <div class="d-flex align-items-center mb-3">
                                <div class="text-start">
                                    <h4 class="mb-2" style="font-weight: bold;">{{ $kost->hunian->nama }}</h4>
                                    <span>{{ ucfirst($kost->type) }}</span>
                                </div>
                            </div>

                            <hr class="my-4">

                            <!-- Bagian Deskripsi -->
                            <div class="mb-5">
                                <h4 class="mb-3">Deskripsi</h4>
                                <p>{{ $kost->hunian->deskripsi }}</p>

                                <hr class="my-4">

                                <h4 class="mb-3">Fasilitas</h4>
                                @php
                                $facilities = is_string($kost->facilities) ? json_decode($kost->facilities, true) : $kost->facilities;
                                $chunks = array_chunk($facilities, ceil(count($facilities) / 2));
                                @endphp
                                <div class="row">
                                    @foreach ($chunks as $chunk)
                                    <div class="col-md-6">
                                        <ul class="list-unstyled">
                                            @foreach ($chunk as $facility)
                                            <li class="d-flex align-items-center mb-3">
                                                <i class="fa fa-circle text-primary me-2"></i>
                                                <span>{{ strtoupper($facility) }}</span>
                                            </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    @endforeach
                                </div>

                                <hr class="my-4">

                                <h4 class="mb-3">Peraturan</h4>
                                @php
                                $rules = is_string($kost->rules) ? json_decode($kost->rules, true) : $kost->rules;
                                $ruleChunks = array_chunk($rules, ceil(count($rules) / 2));
                                @endphp
                                <div class="row">
                                    @foreach ($ruleChunks as $chunk)
                                    <div class="col-md-6">
                                        <ul class="list-unstyled">
                                            @foreach ($chunk as $rule)
                                            <li class="d-flex align-items-center mb-3">
                                                <i class="fa fa-circle text-primary me-2"></i>
                                                <span>{{ ucwords($rule) }}</span>
                                            </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    @endforeach
                                </div>
                            </div>

                            <hr class="my-4">

                            <h4 class="mb-3">Peta Lokasi</h4>
                            <div id="map" style="height: 400px; border-radius: 8px;"></div>
                        </div>
                    </div>
                </div>


                <!-- Right Content -->
                <div class="col-lg-4 mb-4">
                    <!-- Informasi -->
                    <div class="card shadow rounded bg-white p-4 mb-4 wow slideInUp" data-wow-delay="0.1s">
                        <h4 class="mb-4">Informasi</h4>

                        <!-- Jumlah Kamar -->
                        <div class="card-item mb-3 d-flex align-items-center">
                            <i class="fa fa-door-closed text-primary" style="margin-right: 10px;"></i>
                            <span class="text-success">Jumlah Kamar: {{ $kost->jumlah_kamar }}</span>
                        </div>

                        <!-- Sisa Kamar -->
                        <div class="card-item mb-3 d-flex align-items-center">
                            <i class="fa fa-bed text-primary" style="margin-right: 10px;"></i>
                            @if ($kost->sisaKamar() <= 0)
                                <span class="text-danger fw-bold">Sisa Kamar: Penuh</span>
                                @else
                                <span class="text-danger">Sisa Kamar: {{ $kost->sisaKamar() }}</span>
                                @endif
                        </div>

                        <!-- Lokasi -->
                        <div class="card-item mb-3 d-flex align-items-center">
                            <i class="fa fa-map-marker-alt text-primary" style="margin-right: 10px;"></i>
                            <span>Lokasi Kecamatan: {{ $kost->hunian->location }}</span>
                        </div>

                        <!-- Alamat Lengkap -->
                        <div class="card-item mb-3 d-flex align-items-center">
                            <i class="fa fa-home text-primary" style="margin-right: 10px;"></i>
                            <span>Alamat Lengkap: {{ $kost->hunian->alamat }}</span>
                        </div>

                        <!-- Nomor Telepon -->
                        <div class="card-item mb-3 d-flex align-items-center">
                            <i class="fa fa-phone text-primary" style="margin-right: 10px;"></i>
                            <span>Nomor Telepon: <span id="phone">{{ $kost->user->phone }}</span></span>
                            <button class="btn btn-sm ms-2 p-0" onclick="copyToClipboard('#phone')" style="border: none; background: none;">
                                <i class="bi bi-clipboard-check" style="font-size: 16px;"></i>
                            </button>
                        </div>

                        <!-- Harga -->
                        <div class="card-item mb-4 d-flex align-items-center">
                            <i class="fa fa-money-bill-wave text-primary" style="margin-right: 10px;"></i>
                            <span>Harga: <strong id="harga-total" data-harga="{{ (int) preg_replace('/[^0-9]/', '', $kost->harga) }}">
                                Rp{{ number_format((int) preg_replace('/[^0-9]/', '', $kost->harga), 0, ',', '.') }}
                            </strong></span>
                        </div>

                        <!-- Form Booking -->
                        <form action="{{ route('admin.pembayaran.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <!-- Tanggal Booking -->
                            <div class="card-item mb-3">
                                <label for="booking-date" class="form-label">Pilih Tanggal Mulai Sewa:</label>
                                <input type="date" class="form-control" id="booking-date" name="tanggal_booking" onkeydown="return false" required>
                            </div>

                            <!-- Durasi Sewa -->
                            <div class="card-item mb-3 position-relative">
                                <label for="durasi_sewa" class="form-label">Pilih Durasi Sewa:</label>
                                <div class="position-relative">
                                    <select class="form-control pe-5" id="durasi_sewa" name="durasi_sewa" required>
                                        <option value="" disabled selected>Pilih Durasi</option>
                                        <option value="1 bulan">1 Bulan</option>
                                        <option value="3 bulan">3 Bulan</option>
                                        <option value="1 tahun">1 Tahun</option>
                                    </select>
                                    <i class="bi bi-caret-down-fill position-absolute top-50 end-0 translate-middle-y me-3 text-secondary"></i>
                                </div>
                            </div>

                            <!-- Hidden Kost ID -->
                            <input type="hidden" name="kost_id" value="{{ $kost->id }}">

                            <!-- Tombol Tanya Pemilik -->
                            <div class="mb-3">
                                <a href="https://wa.me/{{ '62' . substr($kost->user->phone, 1) }}" target="_blank" class="btn btn-primary w-100">Tanya Pemilik</a>
                            </div>

                            <!-- Tombol Booking -->
                            <div class="card-item">
                                @if(Auth::check() && auth()->user()->hasRole('pencari_kost'))
                                @if($userHasBooked)
                                <button type="button" onclick="showAlreadyBookingAlert()" class="btn btn-success w-100">
                                    Pesan Sekarang
                                </button>
                                @elseif($kost->sisaKamar() <= 0)
                                    <button type="button" onclick="showFullBookingAlert()" class="btn btn-success w-100">
                                    Pesan Sekarang
                                    </button>
                                    @else
                                    <button type="button" class="btn btn-success w-100" data-bs-toggle="modal" data-bs-target="#uploadModal">
                                        Pesan Sekarang
                                    </button>
                                    @endif
                                    @else
                                    <button type="button" class="btn btn-success w-100" data-bs-toggle="modal" data-bs-target="#accessModal">
                                        Pesan Sekarang
                                    </button>
                                    @endif
                            </div>
                        </form>
                    </div>

                    <!-- Card Rating -->
                    <div class="card shadow rounded bg-white p-4 mb-4 wow slideInUp" data-wow-delay="0.2s">
                        <h4 class="mb-3">Rating Pengguna</h4>
                        <div class="d-flex align-items-center mb-4">
                            <div class="text-center" style="margin-right: 30px;">
                                <h2 style="font-weight: bold;">{{ number_format($averageRating ?? 0, 1) }}</h2>
                                <div class="text-warning">
                                    @php $rating = $averageRating ?? 0; @endphp
                                    @for ($i = 1; $i <= 5; $i++)
                                        @if ($i <=floor($rating))
                                        <i class="fa fa-star"></i>
                                        @elseif ($i - 0.5 <= $rating)
                                            <i class="fa fa-star-half-o"></i>
                                            @else
                                            <i class="fa fa-star-o"></i>
                                            @endif
                                            @endfor
                                </div>
                                <small>{{ $totalRatings ?? 0 }} Penilaian</small>
                            </div>
                            <div style="flex-grow: 1;">
                                <ul class="list-unstyled mb-0">
                                    @foreach ([5, 4, 3, 2, 1] as $bintang)
                                    <li class="d-flex align-items-center mb-2">
                                        <span style="width: 20px; font-weight: bold;">{{ $bintang }}</span>
                                        <div class="progress flex-grow-1 mx-2" style="height: 8px;">
                                            <div class="progress-bar bg-warning" role="progressbar"
                                                style="width: {{ $totalRatings > 0 ? (($distribution[$bintang] ?? 0) / $totalRatings) * 100 : 0 }}%;"
                                                aria-valuenow="{{ $distribution[$bintang] ?? 0 }}"
                                                aria-valuemin="0"
                                                aria-valuemax="100">
                                            </div>
                                        </div>
                                        <span>{{ $distribution[$bintang] ?? 0 }}</span>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
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
                                    <h5 class="modal-title" id="accessModalLabel">Peringatan!</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    @if(Auth::check())
                                    <!-- Jika pengguna sudah login, tetapi tidak memiliki peran pencari_kost -->
                                    @if(!auth()->user()->hasRole('pencari_kost'))
                                    <p>Anda harus menjadi <strong>pencari kost</strong> untuk mengajukan sewa.</p>
                                    @else
                                    <!-- Jika pengguna sudah login dan memiliki peran pencari_kost -->
                                    <p>Anda sudah mengajukan sewa kost/kontrakan.</p>
                                    @endif
                                    @else
                                    <!-- Jika pengguna belum login -->
                                    <p>Untuk melanjutkan, silakan login terlebih dahulu sebagai pencari hunian.</p>
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
                                    <h5 class="modal-title" id="uploadModalLabel">Upload Bukti Identitas (KTP)</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form id="uploadForm" method="POST" action="{{ route('admin.pembayaran.store') }}" enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" name="durasi_sewa" id="hiddenDurasiSewa">
                                        <input type="hidden" name="kost_id" value="{{ $kost->id }}">
                                        <input type="hidden" name="tanggal_booking" id="modalBookingDate">
                                        <div class="mb-3">
                                            <label for="kartu_identitas" class="form-label">Unggah KTP (PDF/JPG/PNG, max 2MB)</label>
                                            <input type="file" class="form-control" id="kartu_identitas" name="kartu_identitas" accept=".pdf,.jpg,.png" required>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-success">Pesan Sekarang</button>
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

    <!-- footer section -->
    <x-footer />
    <!-- footer section -->

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const durasiSelect = document.getElementById('durasi_sewa');
            const hargaText = document.getElementById('harga-total');
            const hargaPerBulan = parseInt(hargaText.getAttribute('data-harga'));

            durasiSelect.addEventListener('change', function () {
                let multiplier = 1;
                let diskon = 0;

                switch (this.value) {
                    case "1 bulan":
                        multiplier = 1;
                        break;
                    case "3 bulan":
                        multiplier = 3;
                        break;
                    case "1 tahun":
                        multiplier = 12;
                        diskon = 0.10; // diskon 10%
                        break;
                }

                let total = hargaPerBulan * multiplier;
                if (diskon > 0) {
                    total = total - (total * diskon);
                }

                hargaText.textContent = "Rp" + total.toLocaleString('id-ID');
            });
        });
    </script>


    <script src="https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js"></script>

    <!-- Inisialisasi GLightbox -->
    <script>
        const lightbox = GLightbox({
            selector: '.glightbox',
            touchNavigation: true,
            loop: true // 
        });
    </script>

    <script>
        const durasiSewaSelect = document.getElementById('durasi_sewa');
        const bookingDateInput = document.getElementById('booking-date');
        const hiddenDurasiInput = document.getElementById('hiddenDurasiSewa');
        const hiddenBookingInput = document.getElementById('modalBookingDate');

        // Update nilai saat tanggal atau durasi diubah
        function updateHiddenFields() {
            hiddenDurasiInput.value = durasiSewaSelect.value;
            hiddenBookingInput.value = bookingDateInput.value;
        }

        // Trigger saat input berubah
        durasiSewaSelect.addEventListener('change', updateHiddenFields);
        bookingDateInput.addEventListener('change', updateHiddenFields);

        // Saat modal dibuka, pastikan input tersembunyi diperbarui juga
        const uploadModal = document.getElementById('uploadModal');
        uploadModal.addEventListener('show.bs.modal', function () {
            updateHiddenFields();
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
        function showAlreadyBookingAlert() {
            Swal.fire({
                icon: 'info',
                title: 'Sudah Mengajukan Sewa',
                text: 'Anda sudah mengajukan sewa untuk hunian ini sebelumnya.'
            });
        }

        function showFullBookingAlert() {
            Swal.fire({
                icon: 'info',
                title: 'Kamar Sudah Penuh',
                text: 'Mohon Maaf, Semua kamar telah terisi. Silakan coba pilih tempat kost/kontrakan yang lain.'
            });
        }
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

    <!-- Tambahkan Leaflet JS & CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const latitude = {{ $kost->hunian->latitude ?? -6.9 }};
            const longitude = {{ $kost->hunian->longitude ?? 109.1 }};

            const map = L.map('map').setView([latitude, longitude], 16);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(map);

            L.marker([latitude, longitude]).addTo(map)
                .bindPopup("{{ $kost->hunian->nama }}<br>{{ $kost->hunian->alamat }}")
                .openPopup();
        });
    </script>

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