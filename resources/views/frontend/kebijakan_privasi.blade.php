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