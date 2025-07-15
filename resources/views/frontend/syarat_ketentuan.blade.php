@extends('../layouts.master')

@section('content')

<body class="sub_page">

    <div class="hero_area">

        <div class="hero_bg_box">

        </div>

        <x-navbar />

    </div>

    <!-- why section -->
    <section class="layout_padding">
        <div class="container">
            <div class="heading_container heading_center mb-5">
                <h2>Syarat & <span>Ketentuan</span></h2>
                <p>Dengan menggunakan layanan kami, Anda dianggap telah membaca, memahami, dan menyetujui syarat dan ketentuan berikut</p>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="card shadow-sm p-4">

                        <h5>1. Penggunaan Layanan</h5>
                        <p>Pengguna wajib menggunakan website ini untuk tujuan yang sah, yaitu mencari atau mempromosikan tempat kost dan kontrakan secara jujur dan bertanggung jawab.</p>

                        <h5 class="mt-3">2. Informasi Iklan</h5>
                        <p>Setiap informasi yang dicantumkan dalam iklan, seperti harga, fasilitas, dan lokasi, merupakan tanggung jawab penuh pemilik atau pengiklan. Kami tidak menjamin keakuratan data tersebut.</p>

                        <h5 class="mt-3">3. Hak Cipta</h5>
                        <p>Seluruh konten pada website, termasuk teks, gambar, dan logo, dilindungi oleh hak cipta. Penggunaan tanpa izin tertulis dari pemilik situs tidak diperbolehkan.</p>

                        <h5 class="mt-3">4. Perubahan Layanan</h5>
                        <p>Tim pengelola berhak melakukan perubahan, pembaruan, atau penghentian sebagian atau seluruh layanan website tanpa pemberitahuan terlebih dahulu.</p>

                        <h5 class="mt-3">5. Penangguhan Akun</h5>
                        <p>Kami berhak menangguhkan atau menghapus akun pengguna yang terbukti melakukan pelanggaran, seperti menyebarkan informasi palsu atau merugikan pihak lain.</p>

                        <h5 class="mt-3">6. Konten Terlarang</h5>
                        <p>Pengguna dilarang mempublikasikan konten yang mengandung unsur penipuan, pelecehan, diskriminasi, atau hal-hal yang bertentangan dengan hukum yang berlaku.</p>

                        <h5 class="mt-3">7. Tanggung Jawab</h5>
                        <p>Kami tidak bertanggung jawab atas kerugian atau masalah yang timbul dari transaksi atau interaksi antar pengguna yang terjadi di luar kendali kami.</p>

                        <h5 class="mt-3">8. Hukum yang Berlaku</h5>
                        <p>Syarat dan ketentuan ini tunduk serta diinterpretasikan sesuai dengan hukum yang berlaku di wilayah Republik Indonesia</p>
                    </div>
                </div>
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