<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Data') }}
        </h2>
    </x-slot>

    <!-- SweetAlert2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.11/dist/sweetalert2.min.css" rel="stylesheet">

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden p-10 shadow-sm sm:rounded-lg">

                <form method="POST" action="{{ route('admin.kost.update', $kost->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div>
                        <x-input-label for="nama" :value="__('Nama Kost/Kontrakan')" />
                        <x-text-input id="nama" class="block mt-1 w-full" type="text" name="nama" :value="old('nama', $kost->nama)" placeholder="Nama hunian Anda" required autofocus autocomplete="nama" />
                        <x-input-error :messages="$errors->get('nama')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="deskripsi" :value="__('Deskripsi')" />
                        <textarea name="deskripsi" id="deskripsi" cols="30" rows="3" class="border border-slate-300 rounded-xl w-full" required>{{ old('deskripsi', $kost->deskripsi) }}</textarea>
                        <x-input-error :messages="$errors->get('deskripsi')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="type" :value="__('Jenis Kost')" />
                        <select name="type" id="type" class="py-3 rounded-lg pl-3 w-full border border-slate-300">
                            <option value="" disabled>Pilih Jenis Hunian</option>
                            <option value="putra" {{ old('type', $kost->type) == 'putra' ? 'selected' : '' }}>Kost Putra</option>
                            <option value="putri" {{ old('type', $kost->type) == 'putri' ? 'selected' : '' }}>Kost Putri</option>
                            <option value="campur" {{ old('type', $kost->type) == 'campur' ? 'selected' : '' }}>Kost Campur</option>
                            <option value="kontrakan" {{ old('type', $kost->type) == 'kontrakan' ? 'selected' : '' }}>Kontrakan</option>
                        </select>
                        <x-input-error :messages="$errors->get('type')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="jumlah_kamar" :value="__('Jumlah Kamar')" />
                        <x-text-input id="jumlah_kamar" class="block mt-1 w-full" type="number" name="jumlah_kamar" :value="old('jumlah_kamar', $kost->jumlah_kamar)" required />
                        <x-input-error :messages="$errors->get('jumlah_kamar')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="location" :value="__('Lokasi Kecamatan')" />
                        <select name="location" id="location" class="py-3 rounded-lg pl-3 w-full border border-slate-300" required>
                            <option value="" disabled selected>Pilih Lokasi Kecamatan</option>

                            <!-- Kota Tegal -->
                            <optgroup label="Kota Tegal">
                                <option value="Margadana" {{ old('location', $kost->location) == 'Margadana' ? 'selected' : '' }}>Margadana</option>
                                <option value="Tegal Barat" {{ old('location', $kost->location) == 'Tegal Barat' ? 'selected' : '' }}>Tegal Barat</option>
                                <option value="Tegal Timur" {{ old('location', $kost->location) == 'Tegal Timur' ? 'selected' : '' }}>Tegal Timur</option>
                                <option value="Tegal Selatan" {{ old('location', $kost->location) == 'Tegal Selatan' ? 'selected' : '' }}>Tegal Selatan</option>
                            </optgroup>

                            <!-- Kabupaten Tegal -->
                            <optgroup label="Kabupaten Tegal">
                                <option value="Adiwerna" {{ old('location', $kost->location) == 'Adiwerna' ? 'selected' : '' }}>Adiwerna</option>
                                <option value="Balapulang" {{ old('location', $kost->location) == 'Balapulang' ? 'selected' : '' }}>Balapulang</option>
                                <option value="Bojong" {{ old('location', $kost->location) == 'Bojong' ? 'selected' : '' }}>Bojong</option>
                                <option value="Bumijawa" {{ old('location', $kost->location) == 'Bumijawa' ? 'selected' : '' }}>Bumijawa</option>
                                <option value="Dukuhturi" {{ old('location', $kost->location) == 'Dukuhturi' ? 'selected' : '' }}>Dukuhturi</option>
                                <option value="Dukuhwaru" {{ old('location', $kost->location) == 'Dukuhwaru' ? 'selected' : '' }}>Dukuhwaru</option>
                                <option value="Jatinegara" {{ old('location', $kost->location) == 'Jatinegara' ? 'selected' : '' }}>Jatinegara</option>
                                <option value="Kedungbanteng" {{ old('location', $kost->location) == 'Kedungbanteng' ? 'selected' : '' }}>Kedungbanteng</option>
                                <option value="Kramat" {{ old('location', $kost->location) == 'Kramat' ? 'selected' : '' }}>Kramat</option>
                                <option value="Lebaksiu" {{ old('location', $kost->location) == 'Lebaksiu' ? 'selected' : '' }}>Lebaksiu</option>
                                <option value="Margasari" {{ old('location', $kost->location) == 'Margasari' ? 'selected' : '' }}>Margasari</option>
                                <option value="Pagerbarang" {{ old('location', $kost->location) == 'Pagerbarang' ? 'selected' : '' }}>Pagerbarang</option>
                                <option value="Pangkah" {{ old('location', $kost->location) == 'Pangkah' ? 'selected' : '' }}>Pangkah</option>
                                <option value="Slawi" {{ old('location', $kost->location) == 'Slawi' ? 'selected' : '' }}>Slawi</option>
                                <option value="Surodadi" {{ old('location', $kost->location) == 'Surodadi' ? 'selected' : '' }}>Surodadi</option>
                                <option value="Talang" {{ old('location', $kost->location) == 'Talang' ? 'selected' : '' }}>Talang</option>
                                <option value="Tarub" {{ old('location', $kost->location) == 'Tarub' ? 'selected' : '' }}>Tarub</option>
                                <option value="Warureja" {{ old('location', $kost->location) == 'Warureja' ? 'selected' : '' }}>Warureja</option>
                            </optgroup>
                        </select>
                        <x-input-error :messages="$errors->get('location')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="alamat" :value="__('Alamat')" />
                        <textarea name="alamat" id="alamat" cols="30" rows="3" class="border border-slate-300 rounded-xl w-full" required>{{ old('alamat', $kost->alamat) }}</textarea>
                        <x-input-error :messages="$errors->get('alamat')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="map" :value="__('Tentukan Lokasi Hunian di Peta')" />

                        <!-- Tombol lokasi saat ini -->
                        <button type="button" id="lokasiSekarang" class="btn btn-sm btn-primary mt-2 mb-2">
                            Gunakan Lokasi Saat Ini
                        </button>

                        <div id="map" style="height: 400px;" class="rounded border border-slate-300"></div>

                        <input type="hidden" name="latitude" id="latitude" value="{{ old('latitude', $kost->latitude) }}">
                        <input type="hidden" name="longitude" id="longitude" value="{{ old('longitude', $kost->longitude) }}">

                        <p class="text-sm text-gray-600 mt-2">Klik pada peta untuk memilih lokasi hunian.</p>
                    </div>

                    <div class="mt-4">
                        <x-input-label for="harga" :value="__('Harga (per bulan)')" />
                        <x-text-input id="harga" class="block mt-1 w-full" type="text" name="harga" :value="old('harga', $kost->harga)" required />
                        <x-input-error :messages="$errors->get('harga')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="facilities" :value="__('Fasilitas')" />

                        <select id="facilityDropdown" class="form-control mt-2 py-3 rounded-lg pl-3 w-full border border-slate-300">
                            <option value="" disabled selected>Pilih Fasilitas</option>
                        </select>

                        <!-- Checkbox Fasilitas -->
                        <div id="checkboxContainer" class="mt-3 p-4 border rounded-md">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-1">
                                @php
                                $allFacilities = [
                                "Kamar Mandi Dalam", "Air Panas", "Shower", "Lemari Baju", "AC",
                                "Kursi", "Meja", "TV", "Kasur", "Mesin Cuci", "Dapur Bersama", "Parkir Mobil",
                                "Kloset Duduk", "Kloset Jongkok", "Kipas Angin", "Wifi", "Parkir Motor", "CCTV", "Dispenser", "Kulkas", "Teras",
                                "Ruang Tamu", "Ruang Makan", "Tempat Jemuran", "Kamar Mandi Luar", "Mushola"
                                ];
                                $selectedFacilities = old('facilities', $kost->facilities ?? []);
                                @endphp

                                @foreach($allFacilities as $facility)
                                <div class="col-md-6 col-12 mb-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="facilities[]" value="{{ $facility }}"
                                            {{ in_array($facility, $selectedFacilities) ? 'checked' : '' }}>
                                        <label class="form-check-label">{{ strtoupper($facility) }}</label>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        <x-input-error :messages="$errors->get('facilities')" class="mt-2" />
                    </div>


                    <div class="mt-4">
                        <x-input-label for="rules" :value="__('Peraturan')" />
                        <div id="rules-container" class="flex flex-col gap-y-2">
                            @foreach(old('rules', $kost->rules ?? []) as $rule)
                            <div class="flex items-center gap-2">
                                <x-text-input name="rules[]" class="w-full" type="text" value="{{ $rule }}" placeholder="Masukkan peraturan" />
                                <button type="button" class="remove-rule bg-red-600 text-white px-2 py-1 rounded">Hapus</button>
                            </div>
                            @endforeach
                        </div>
                        <button type="button" id="add-rule" class="mt-2 bg-indigo-600 text-white px-4 py-2 rounded">Tambah Peraturan</button>
                        <x-input-error :messages="$errors->get('rules')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="foto" :value="__('Foto Hunian')" />
                        <div id="foto-container" class="flex flex-col gap-y-2">
                            @foreach(old('foto', json_decode($kost->foto ?? '[]', true)) as $photo)
                            <div class="flex items-center gap-2">
                                <img src="{{ asset('storage/' . $photo) }}" alt="Foto Hunian" class="w-16 h-16 rounded-lg object-cover" />
                                <input type="hidden" name="existing_foto[]" value="{{ $photo }}">
                                <button type="button" class="remove-photo bg-red-600 text-white px-2 py-1 rounded">Hapus</button>
                            </div>
                            @endforeach
                        </div>
                        <button type="button" id="add-foto" class="mt-2 bg-indigo-600 text-white px-4 py-2 rounded">Tambah Foto</button>
                        <x-input-error :messages="$errors->get('foto')" class="mt-2" />
                        <!-- Keterangan tegas mengenai orientasi landscape -->
                        <p class="text-sm text-gray-600 mt-1">
                            *Foto hunian <strong>di sarankan menggunakan orientasi landscape</strong> agar tampilan sesuai di aplikasi.
                        </p>
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <button type="submit" class="font-bold py-4 px-6 bg-indigo-700 text-white rounded-full">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.11/dist/sweetalert2.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Tambah fasilitas
            // document.getElementById('add-facility').addEventListener('click', () => {
            //     const container = document.getElementById('facilities-container');
            //     const inputHTML = `
            //     <div class="flex items-center gap-2">
            //         <input type="text" name="facilities[]" class="w-full border border-slate-300 rounded-lg" placeholder="Masukkan fasilitas" required>
            //         <button type="button" class="remove-facility bg-red-600 text-white px-2 py-1 rounded">Hapus</button>
            //     </div>`;
            //     container.insertAdjacentHTML('beforeend', inputHTML);
            // });

            // Tambah peraturan
            document.getElementById('add-rule').addEventListener('click', () => {
                const container = document.getElementById('rules-container');
                const inputHTML = `
                <div class="flex items-center gap-2">
                    <input type="text" name="rules[]" class="w-full border border-slate-300 rounded-lg" placeholder="Masukkan peraturan" required>
                    <button type="button" class="remove-rule bg-red-600 text-white px-2 py-1 rounded">Hapus</button>
                </div>`;
                container.insertAdjacentHTML('beforeend', inputHTML);
            });

            // Tambah foto
            document.getElementById('add-foto').addEventListener('click', () => {
                const container = document.getElementById('foto-container');

                // Hitung jumlah foto yang sudah ada (img) dan input file baru
                const existingPhotos = container.querySelectorAll('img').length;
                const addedInputs = container.querySelectorAll('input[type="file"]').length;

                const totalPhotos = existingPhotos + addedInputs;

                if (totalPhotos < 15) {
                    const inputHTML = `
                    <div class="flex items-center gap-2">
                        <input type="file" name="foto[]" class="w-full border border-slate-300 rounded-lg" accept="image/*" required>
                        <button type="button" class="remove-photo bg-red-600 text-white px-2 py-1 rounded">Hapus</button>
                    </div>`;
                    container.insertAdjacentHTML('beforeend', inputHTML);
                } else {
                    Swal.fire({
                        title: 'Maksimal 15 Foto Hunian!',
                        text: 'Anda sudah mencapai batas maksimum foto yang dapat diunggah.',
                        icon: 'warning',
                        confirmButtonText: 'OK'
                    });
                }
            });

            // Hapus elemen (fasilitas, peraturan, atau foto)
            document.addEventListener('click', (event) => {
                if (event.target.classList.contains('remove-facility') || event.target.classList.contains('remove-rule') || event.target.classList.contains('remove-photo')) {
                    event.target.parentElement.remove();
                }
            });
        });
    </script>

    <script>
        // Mengambil elemen input harga
        const hargaInput = document.getElementById('harga');

        // Format input untuk menambahkan "Rp" dan pemisah ribuan
        hargaInput.addEventListener('input', function(e) {
            let value = hargaInput.value;

            // Menghapus semua karakter non-numerik kecuali titik (.) untuk desimal
            value = value.replace(/[^0-9]/g, '');

            // Menambahkan "Rp" di depan dan format pemisah ribuan
            if (value) {
                value = 'Rp ' + value.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
            }

            // Menampilkan kembali nilai dengan format yang benar
            hargaInput.value = value;
        });
    </script>

    <script>
        document.getElementById('facilityDropdown').addEventListener('click', function() {
            let container = document.getElementById('checkboxContainer');
            container.style.display = container.style.display === 'none' ? 'block' : 'none';
        });
    </script>

    <!-- Leaflet CSS & JS (CDN) -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <script>
        let defaultLat = -6.869969;
        let defaultLng = 109.125595;

        let lat = parseFloat(document.getElementById('latitude').value) || defaultLat;
        let lng = parseFloat(document.getElementById('longitude').value) || defaultLng;

        let map = L.map('map').setView([lat, lng], 13);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        let marker = L.marker([lat, lng], {
            draggable: true
        }).addTo(map);

        // Saat marker digeser
        marker.on('dragend', function (e) {
            let posisi = marker.getLatLng();
            document.getElementById('latitude').value = posisi.lat;
            document.getElementById('longitude').value = posisi.lng;
        });

        // Saat map diklik
        map.on('click', function (e) {
            let posisi = e.latlng;
            marker.setLatLng(posisi);
            document.getElementById('latitude').value = posisi.lat;
            document.getElementById('longitude').value = posisi.lng;
        });

        // Tombol lokasi saat ini
        document.getElementById('lokasiSekarang').addEventListener('click', function () {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function (posisi) {
                    let lat = posisi.coords.latitude;
                    let lng = posisi.coords.longitude;

                    map.setView([lat, lng], 16);
                    marker.setLatLng([lat, lng]);
                    document.getElementById('latitude').value = lat;
                    document.getElementById('longitude').value = lng;
                }, function () {
                    alert('Gagal mendapatkan lokasi. Pastikan izin lokasi diaktifkan.');
                });
            } else {
                alert("Browser tidak mendukung Geolocation.");
            }
        });
    </script>



</x-app-layout>