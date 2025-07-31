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
                <div class="container search-form-container">
                    <div class="heading_container heading_center mb-4">
                        <h2>
                            <span>Rekomendasi Tempat Kost dan Kontrakan</span>
                        </h2>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-lg-10 col-md-12">
                            <div class="card-cari shadow h-100 border-0 rounded" style="background-color: white;">
                                <form action="{{ route('frontend.rekomendasi') }}" method="GET">
                                    @php
                                        $orderedCriteria = $kriteriaOrder ?: ['location', 'type', 'harga', 'facilities'];
                                    @endphp

                                    <div class="row g-3 align-items-center p-4" id="sortable-criteria">
                                        @foreach ($orderedCriteria as $criteria)
                                            @if ($criteria === 'location')
                                                <div class="col-lg-12 col-md-6 col-12 mb-3 draggable-item" data-kriteria="location">
                                                    {{-- === LOKASI === --}}
                                                    <select id="location" name="location" class="form-control" style="border-radius: 5px;" required
                                                        oninvalid="this.setCustomValidity('Silakan Pilih Lokasi')"
                                                        oninput="this.setCustomValidity('')">
                                                        <option value="" disabled {{ request('location') ? '' : 'selected' }}>Lokasi</option>
                                                        <optgroup label="Kota Tegal">
                                                            <option value="Margadana" {{ request('location') == 'Margadana' ? 'selected' : '' }}>Margadana</option>
                                                            <option value="Tegal Barat" {{ request('location') == 'Tegal Barat' ? 'selected' : '' }}>Tegal Barat</option>
                                                            <option value="Tegal Timur" {{ request('location') == 'Tegal Timur' ? 'selected' : '' }}>Tegal Timur</option>
                                                            <option value="Tegal Selatan" {{ request('location') == 'Tegal Selatan' ? 'selected' : '' }}>Tegal Selatan</option>
                                                        </optgroup>
                                                        <optgroup label="Kabupaten Tegal">
                                                            @foreach(['Adiwerna', 'Balapulang', 'Bojong', 'Dukuhturi', 'Dukuhwaru', 'Jatinegara',
                                                                    'Kedungbanteng', 'Kramat', 'Lebaksiu', 'Margasari', 'Pagerbarang', 'Pangkah',
                                                                    'Slawi', 'Suradadi', 'Talang', 'Tarub', 'Warureja'] as $area)
                                                                <option value="{{ $area }}" {{ request('location') == $area ? 'selected' : '' }}>{{ $area }}</option>
                                                            @endforeach
                                                        </optgroup>
                                                    </select>
                                                </div>
                                            @elseif ($criteria === 'type')
                                                <div class="col-lg-12 col-md-6 col-12 mb-3 draggable-item" data-kriteria="type">
                                                    {{-- === JENIS HUNIAN === --}}
                                                    <select id="type" name="type" class="form-control" style="border-radius: 5px;">
                                                        <option value="" disabled {{ request('type') ? '' : 'selected' }}>Tipe Hunian</option>
                                                        <option value="putra" {{ request('type') == 'putra' ? 'selected' : '' }}>Kost Putra</option>
                                                        <option value="putri" {{ request('type') == 'putri' ? 'selected' : '' }}>Kost Putri</option>
                                                        <option value="campur" {{ request('type') == 'campur' ? 'selected' : '' }}>Kost Campur</option>
                                                        <option value="kontrakan" {{ request('type') == 'kontrakan' ? 'selected' : '' }}>Kontrakan</option>
                                                    </select>
                                                </div>
                                            @elseif ($criteria === 'harga')
                                                <div class="col-lg-12 col-md-6 col-12 mb-3 draggable-item" data-kriteria="harga">
                                                    {{-- === HARGA === --}}
                                                    <div class="dropdown">
                                                        <select class="form-control" id="pilihanHarga" style="border-radius: 5px;">
                                                            <option value="" disabled selected>Harga</option>
                                                        </select>
                                                        <div id="inputHargaContainer" class="mt-2" style="display: none;">
                                                            <input type="text" id="harga" name="harga" class="form-control"
                                                                placeholder="Masukkan Harga (contoh: 500000)" value="{{ request('harga') }}"
                                                                style="border-radius: 5px; margin-top: 5px;">
                                                        </div>
                                                    </div>
                                                </div>
                                            @elseif ($criteria === 'facilities')
                                                <div class="col-lg-12 col-md-6 col-12 mb-3 draggable-item" data-kriteria="facilities">
                                                    {{-- === FASILITAS === --}}
                                                    <select id="facilityDropdown" class="form-control" style="border-radius: 5px;">
                                                        <option value="" disabled selected>Fasilitas</option>
                                                    </select>

                                                    <div id="checkboxContainer" class="border p-3 rounded mt-2" style="display: none;">
                                                        <div class="row">
                                                            @php
                                                                $allFacilities = [
                                                                    "Kamar Mandi Dalam", "Air Panas", "Shower", "Lemari Baju", "AC",
                                                                    "Kursi", "Meja", "TV", "Kasur", "Mesin Cuci", "Dapur Bersama", "Parkir Mobil",
                                                                    "Kloset Duduk", "Kloset Jongkok", "Kipas Angin", "Wifi", "Parkir Motor", "CCTV",
                                                                    "Dispenser", "Kulkas", "Teras", "Ruang Tamu", "Ruang Makan",
                                                                    "Tempat Jemuran", "Kamar Mandi Luar", "Mushola"
                                                                ];
                                                                $selectedFacilities = $facilities ?? [];
                                                            @endphp

                                                            @foreach($allFacilities as $facility)
                                                                <div class="col-md-6 col-12">
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="checkbox" name="facilities[]" value="{{ $facility }}"
                                                                            {{ in_array($facility, $selectedFacilities) ? 'checked' : '' }}>
                                                                        <label class="form-check-label">{{ strtoupper($facility) }}</label>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>


                                    <div id="kriteriaInputs"></div>

                                    <div class="row px-4">
                                        <div class="col-12">
                                            <p class="text-muted" style="font-size: 14px;">* Urutkan kriteria sesuai prioritas (Drag & Drop)</p>
                                        </div>
                                    </div>

                                    <!-- Tombol Submit -->
                                    <div class="row px-4 pb-4">
                                        <div class="col-lg-12 col-md-6 col-12 text-center mt-1">
                                            <input type="hidden" name="priority_order" id="priorityOrder">
                                            <button type="submit" class="btn w-100" style="background-color: #007bff; border-radius: 10px;">
                                                <i class="bi bi-magic text-white"></i> <span class="text-white">Cari Rekomendasi</span>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                @if(request()->has('location') || request()->has('type') || request()->has('harga') || request()->has('facilities'))
                @if(isset($kosts) && $kosts->count() > 0)
                <!-- tampilkan kost -->
                <div class="row mt-5">
                    @foreach ($kosts as $kost)
                    <div class="col-md-4 mb-4">
                        <div class="card h-90 shadow">
                            <img src="{{ asset('storage/' . json_decode($kost->foto)[0]) }}"
                                class="img-fluid w-100 rounded-top"
                                style="height: 200px; object-fit: cover;"
                                alt="{{ $kost->nama }}">
                            <div class="card-body text-start">
                                <h6 class="card-title mb-2" style="color: #007bff;">{{ ucfirst($kost->type) }}</h6>
                                <p class="card-text mb-3">{{ $kost->hunian->nama }}</p>
                                <ul class="list-unstyled mb-3">
                                    <li><i class="bi bi-geo-alt me-2"></i> <span class="ms-2">Lokasi: {{ $kost->hunian->location }}</span></li>
                                    <li>
                                        <i class="bi bi-door-closed me-2"></i>
                                        <span class="ms-2">
                                            Total Kamar: {{ $totalKamarPerHunian[$kost->hunian_id] ?? '0' }}
                                        </span>
                                    </li>
                                </ul>

                                <!-- Tampilkan jumlah skor -->
                                <!-- @isset($kost->bobotScore)
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="badge bg-info" style="font-size: 1rem;">Skor: {{ number_format($kost->bobotScore, 2) }}</span>
                                </div>
                                @endisset -->

                                <div class="d-flex justify-content-between align-items-center">
                                    @if ($kost->verifikasi && $kost->verifikasi->status_verifikasi === 'terverifikasi')
                                    <span class="verified text-primary" style="font-size: 0.80rem; cursor: pointer;">Terverifikasi</span>
                                    @endif
                                    <a href="{{ route('frontend.detail_kamar', $kost->hunian_id) }}" class="btn btn-primary">Pilih Kamar</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="row mt-5">
                    <div class="col-12">
                        <div class="alert alert-warning" role="alert">
                            <i class="bi bi-exclamation-triangle"></i> Tidak ada kost atau kontrakan yang direkomendasikan.
                        </div>
                    </div>
                </div>
                @endif
                @endif
            </div>
        </div>
    </section>
    <!-- end service section -->

    <!-- footer section -->
    <x-footer />
    <!-- footer section -->

    <!-- Bootstrap Icons (drag indicator) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <!-- SortableJS -->
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>

    <style>
        .draggable-item {
            cursor: move;
            border: 1px dashed #ddd;
            padding: 10px;
            border-radius: 8px;
            background-color: #f9f9f9;
            transition: background-color 0.2s ease;
        }

        .draggable-item:hover {
            background-color: #eef6ff;
        }

        .drag-indicator {
            font-size: 13px;
            margin-bottom: 6px;
        }
    </style>

    <script>
        const sortable = new Sortable(document.getElementById('sortable-criteria'), {
            animation: 150,
            handle: '.draggable-item',
            onEnd: function () {
                updatePriorityOrder();
            }
        });

        function updatePriorityOrder() {
            const container = document.getElementById('kriteriaInputs');
            container.innerHTML = ''; // Bersihkan dulu

            document.querySelectorAll('#sortable-criteria .draggable-item').forEach(el => {
                const kriteria = el.getAttribute('data-kriteria');
                if (kriteria) {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'kriteria[]';
                    input.value = kriteria;
                    container.appendChild(input);
                }
            });
        }

        window.addEventListener('DOMContentLoaded', updatePriorityOrder);
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
        document.getElementById('facilityDropdown').addEventListener('click', function() {
            let container = document.getElementById('checkboxContainer');
            container.style.display = container.style.display === 'none' ? 'block' : 'none';
        });
    </script>

    <script>
        const pilihanHarga = document.getElementById('pilihanHarga');
        const inputHargaContainer = document.getElementById('inputHargaContainer');

        pilihanHarga.addEventListener('click', function() {
            // Toggle visibility of the input field when dropdown is clicked
            if (inputHargaContainer.style.display === 'none' || inputHargaContainer.style.display === '') {
                inputHargaContainer.style.display = 'block'; // Show the input field
            } else {
                inputHargaContainer.style.display = 'none'; // Hide the input field
            }
        });
    </script>

    <script>
        const hargaInput = document.getElementById('harga');

        hargaInput.addEventListener('input', function(e) {
            let angka = e.target.value.replace(/[^0-9]/g, '');
            if (!angka) {
                e.target.value = '';
                return;
            }

            e.target.value = formatRupiah(angka);
        });

        function formatRupiah(angka) {
            let number_string = angka.toString(),
                sisa = number_string.length % 3,
                rupiah = number_string.substr(0, sisa),
                ribuan = number_string.substr(sisa).match(/\d{3}/g);

            if (ribuan) {
                let separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            return 'Rp ' + rupiah;
        }
    </script>

    <script>
        document.querySelector('form').addEventListener('submit', function(e) {
            const loc = parseInt(document.querySelector('[name="weight_location"]').value) || 0;
            const type = parseInt(document.querySelector('[name="weight_type"]').value) || 0;
            const harga = parseInt(document.querySelector('[name="weight_harga"]').value) || 0;
            const fasilitas = parseInt(document.querySelector('[name="weight_facilities"]').value) || 0;

            const total = loc + type + harga + fasilitas;

            if (total !== 100) {
                e.preventDefault();
                alert('Total bobot harus sama dengan 100%. Saat ini: ' + total + '%.');
            }
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