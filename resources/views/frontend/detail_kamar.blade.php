@extends('../layouts.master')

@section('content')

<body class="sub_page">


    <div class="hero_area">

        <div class="hero_bg_box">

        </div>

        <x-navbar />

    </div>


    <!-- service section -->
    <section class="service_section layout_padding">
        <div class="service_container">
            <div class="container">

                <div class="heading_container heading_center mb-5">
                    <h2 class="mb-2">
                        Pilih <span>Tipe Kamar</span>
                    </h2>
                </div>

                <div class="row mt-5">
                    @forelse ($kosts as $kost)
                        <div class="col-md-4 mb-4">
                            <div class="card h-100 shadow">
                                <img src="{{ asset('storage/' . json_decode($kost->foto)[0]) }}"
                                    class="img-fluid w-100 rounded-top"
                                    style="height: 200px; object-fit: cover;"
                                    alt="{{ $kost->nama_kamar }}">
                                <div class="card-body text-start">
                                    <h6 class="card-title mb-2 text-primary">{{ ucfirst($kost->type) }}</h6>
                                    <p class="card-text mb-3">{{ $kost->nama_kamar }}</p>
                                    <ul class="list-unstyled mb-3">
                                        <li><i class="bi bi-cash me-2"></i> <span class="ms-2">Harga: Rp{{ number_format((int) preg_replace('/[^0-9]/', '', $kost->harga), 0, ',', '.') }}/bulan</span></li>
                                        <li><i class="bi bi-door-closed me-2"></i>
                                            <span class="ms-2">
                                                @if ($kost->sisaKamar() <= 0)
                                                    <span class="text-danger fw-bold">Sisa Kamar: Penuh</span>
                                                @else
                                                    <span class="text-danger">Sisa Kamar: {{ $kost->sisaKamar() }}</span>
                                                @endif
                                            </span>
                                        </li>
                                    </ul>

                                    <div class="d-flex align-items-center mb-3">
                                        <span class="me-2" style="color: #ffc107;">
                                            @php
                                            $rating = $kost->ratings_avg_rating ?? 0;
                                            @endphp

                                            @for ($i = 1; $i <= 5; $i++)
                                                @if ($i <=floor($rating))
                                                <i class="bi bi-star-fill"></i> <!-- Bintang penuh -->
                                                @elseif ($i - $rating < 1 && $i - $rating> 0)
                                                    <i class="bi bi-star-half"></i> <!-- Bintang setengah -->
                                                    @else
                                                    <i class="bi bi-star"></i> <!-- Bintang kosong -->
                                                    @endif
                                                    @endfor
                                        </span>
                                        <small>({{ number_format($rating, 1) }})</small>
                                    </div>

                                    <div class="d-flex justify-content-end align-items-center">
                                        <a href="{{ route('frontend.detail', $kost->id) }}" class="btn btn-primary">Lihat Detail</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <p class="text-center">Belum ada kost yang ditambahkan.</p>
                        </div>
                    @endforelse
                </div>

            </div>
        </div>
    </section>

    <!-- end service section -->

    <!-- footer section -->
    <x-footer />
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