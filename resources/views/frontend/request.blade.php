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
                            <li class="nav-item active">
                                <a class="nav-link" href="{{ route('frontend.request') }}">Request</a>
                            </li>
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

    <!-- why section -->

    <section class="request_section layout_padding">
        <div class="container">
            <div class="heading_container heading_center mb-4">
                <h2>
                    Request <span>Tempat Kost dan Kontrakan</span>
                </h2>
                <p>Isi form berikut untuk mengirim permintaan Anda ke admin.</p>
            </div>
            <div class="card shadow">
                <div class="card-body">
                    <form id="requestForm" action="#" method="get" onsubmit="sendToWhatsApp(event)">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Anda</label>
                            <input type="text" class="form-control" id="name" placeholder="Masukkan nama Anda" required>
                        </div>

                        <div class="mb-3">
                            <label for="type" class="form-label">Jenis Hunian</label>
                            <select class="form-control" id="type" required>
                                <option value="" disabled selected>Pilih jenis hunian</option>
                                <option value="putra">Kost Putra</option>
                                <option value="putri">Kost Putri</option>
                                <option value="campur">Kost Campur</option>
                                <option value="kontrakan">Kontrakan</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="location" class="form-label">Lokasi</label>
                            <input type="text" class="form-control" id="location" placeholder="Masukkan lokasi yang diinginkan" required>
                        </div>
                        <div class="mb-3">
                            <label for="budget" class="form-label">Kisaran Harga</label>
                            <input type="number" class="form-control" id="budget" placeholder="Masukkan kisaran harga (contoh: Rp 500.000)" required>
                        </div>
                        <div class="mb-3">
                            <label for="facility" class="form-label">Fasilitas</label>
                            <textarea class="form-control" id="facility" placeholder="Masukkan fasilitas yang diinginkan" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="notes" class="form-label">Catatan Tambahan</label>
                            <textarea class="form-control" id="notes" rows="3" placeholder="Masukkan catatan tambahan"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Kirim Permintaan</button>
                    </form>
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

<!-- SweetAlert2 Script -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function sendToWhatsApp(event) {
        event.preventDefault(); // Mencegah reload halaman
        const name = document.getElementById("name").value.trim();
        const facility = document.getElementById("facility").value.trim();
        const type = document.getElementById("type").value.trim();
        const location = document.getElementById("location").value.trim();
        const budget = document.getElementById("budget").value.trim();
        const notes = document.getElementById("notes").value.trim();

        const adminNumber = "62895704307742"; // Ganti dengan nomor WhatsApp admin
        let message = `Halo Admin, saya ingin mengajukan permintaan tempat kost dengan detail berikut:%0A`;
        message += `Nama: ${name}%0A`;
        message += `Jenis Hunian: ${type}%0A`;
        message += `Lokasi yang Diinginkan: ${location}%0A`;
        message += `Kisaran Harga: ${budget}%0A`;
        message += `Fasilitas yang Diinginkan: ${facility}%0A`;
        message += `Catatan Tambahan: ${notes || "Tidak ada"}%0A`;

        // Konfirmasi dengan SweetAlert2
        Swal.fire({
            title: 'Konfirmasi',
            text: 'Apakah Anda yakin ingin mengirim permintaan ini ke admin?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya, Kirim!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // Jika user menekan "Ya, Kirim"
                const whatsappURL = `https://wa.me/${adminNumber}?text=${encodeURIComponent(message)}`;
                window.open(whatsappURL, "_blank");

                // Tampilkan pesan sukses
                Swal.fire(
                    'Terkirim!',
                    'Permintaan Anda telah berhasil dikirim. Menunggu respon dari Admin',
                    'success'
                );

                // Clear semua input di dalam form
                document.getElementById("requestForm").reset();
            }
        });
    }
</script>

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