<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Data') }}
        </h2>
    </x-slot>

    <!-- SweetAlert2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.11/dist/sweetalert2.min.css" rel="stylesheet">

    <div class="py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 sm:p-8 max-w-5xl mx-auto grid grid-cols-1 gap-6">

                <form method="POST" action="{{ route('admin.kost.store') }}" enctype="multipart/form-data">
                    @csrf

                    <div>
                        <x-input-label for="nama" :value="__('Nama Hunian')" />
                        <x-text-input id="nama" class="block mt-1 w-full" type="text" name="nama" :value="old('nama')" placeholder="Nama hunian Anda" required autofocus autocomplete="nama" />
                        <x-input-error :messages="$errors->get('nama')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="deskripsi" :value="__('Deskripsi')" />
                        <textarea name="deskripsi" id="deskripsi" cols="30" rows="3" class="border border-slate-300 rounded-xl w-full" placeholder="Deskripsi tentang hunian Anda" required>{{ old('deskripsi') }}</textarea>
                        <x-input-error :messages="$errors->get('deskripsi')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="type" :value="__('Jenis Kost')" />
                        <select name="type" id="type" class="py-3 rounded-lg pl-3 w-full border border-slate-300">
                            <option value="" disabled selected>Pilih Jenis Hunian</option>
                            <option value="putra">Kost Putra</option>
                            <option value="putri">Kost Putri</option>
                            <option value="campur">Kost Campur</option>
                            <option value="kontrakan">Kontrakan</option>
                        </select>
                        <x-input-error :messages="$errors->get('type')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="jumlah_kamar" :value="__('Jumlah Kamar')" />
                        <x-text-input inputmode="numeric" id="jumlah_kamar" class="block mt-1 w-full" type="number" name="jumlah_kamar" :value="old('jumlah_kamar')" placeholder="Jumlah kamar hunian Anda" required autofocus autocomplete="jumlah_kamar" />
                        <x-input-error :messages="$errors->get('jumlah_kamar')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="location" :value="__('Lokasi Kecamatan')" />
                        <select name="location" id="location" class="py-3 rounded-lg pl-3 w-full border border-slate-300" required>
                            <option value="" disabled selected>Pilih Lokasi Kecamatan</option>

                            <!-- Kota Tegal -->
                            <optgroup label="Kota Tegal">
                                <option value="Margadana">Margadana</option>
                                <option value="Tegal Barat">Tegal Barat</option>
                                <option value="Tegal Selatan">Tegal Selatan</option>
                                <option value="Tegal Timur">Tegal Timur</option>
                            </optgroup>

                            <!-- Kabupaten Tegal -->
                            <optgroup label="Kabupaten Tegal">
                                <option value="Adiwerna">Adiwerna</option>
                                <option value="Balapulang">Balapulang</option>
                                <option value="Bojong">Bojong</option>
                                <option value="Bumijawa">Bumijawa</option>
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
                                <option value="Surodadi">Surodadi</option>
                                <option value="Talang">Talang</option>
                                <option value="Tarub">Tarub</option>
                                <option value="Warureja">Warureja</option>
                            </optgroup>
                        </select>
                        <x-input-error :messages="$errors->get('location')" class="mt-2" />
                    </div>


                    <div class="mt-4">
                        <x-input-label for="alamat" :value="__('Alamat Lengkap')" />
                        <textarea name="alamat" id="alamat" cols="30" rows="3" class="border border-slate-300 rounded-xl w-full" placeholder="Masukkan Alamat Lengkap" required>{{ old('alamat') }}</textarea>
                        <x-input-error :messages="$errors->get('alamat')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="map" :value="__('Tentukan Lokasi Hunian di Peta')" />

                        <!-- Tombol lokasi saat ini -->
                        <button type="button" id="lokasiSekarang" class="btn btn-sm btn-primary mt-2 mb-2">
                            Gunakan Lokasi Saat Ini
                        </button>

                        <div id="map" style="height: 400px;" class="rounded border border-slate-300"></div>

                        <input type="hidden" name="latitude" id="latitude" value="{{ old('latitude') }}">
                        <input type="hidden" name="longitude" id="longitude" value="{{ old('longitude') }}">

                        <p class="text-sm text-gray-600 mt-2">Klik pada peta untuk memilih lokasi hunian.</p>
                    </div>


                    <div class="mt-4">
                        <x-input-label for="harga" :value="__('Harga (per bulan)')" />
                        <x-text-input id="harga" class="block mt-1 w-full" type="text" name="harga" :value="old('harga')" placeholder="Masukkan Harga (per bulan)" required autocomplete="off" />
                        <x-input-error :messages="$errors->get('harga')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="facilities" :value="__('Fasilitas')" />

                        <select id="facilityDropdown" class="form-control mt-2 py-3 rounded-lg pl-3 w-full border border-slate-300">
                            <option value="" disabled selected>Pilih Fasilitas</option>
                        </select>

                        <!-- Checkbox Fasilitas dalam Dua Kolom -->
                        <div id="checkboxContainer" class="mt-3 p-4 border rounded-md" style="display: none;">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-1">
                                @php
                                $allFacilities = [
                                "Kamar Mandi Dalam", "Air Panas", "Shower", "Lemari Baju", "AC",
                                "Kursi", "Meja", "TV", "Kasur", "Mesin Cuci", "Dapur Bersama", "Parkir Mobil",
                                "Kloset Duduk", "Kloset Jongkok", "Kipas Angin", "Wifi", "Parkir Motor", "CCTV", "Dispenser", "Kulkas", "Teras",
                                "Ruang Tamu", "Ruang Makan", "Tempat Jemuran", "Kamar Mandi Luar", "Mushola"
                                ];
                                $selectedFacilities = $facilities ?? []; // Pastikan array selalu tersedia
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
                            <!-- Input peraturan baru akan ditambahkan di sini -->
                        </div>
                        <button type="button" id="add-rule" class="mt-2 bg-indigo-600 text-white px-4 py-2 rounded">Tambah Peraturan</button>
                        <x-input-error :messages="$errors->get('rules')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="foto" :value="__('Foto Hunian')" />
                        <div id="foto-container" class="flex flex-col gap-y-2">
                            <!-- Input foto baru akan ditambahkan di sini -->
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
                            Tambah Baru
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.11/dist/sweetalert2.min.js"></script>

    <script>
        // document.getElementById('add-facility').addEventListener('click', function() {
        //     const facilityDiv = document.createElement('div');
        //     facilityDiv.className = 'flex items-center gap-x-2 mt-2';
        //     const input = document.createElement('input');
        //     input.type = 'text';
        //     input.name = 'facilities[]';
        //     input.placeholder = 'Masukkan fasilitas hunian Anda';
        //     input.className = 'block w-full p-2 border border-gray-300 rounded';
        //     const deleteButton = document.createElement('button');
        //     deleteButton.type = 'button';
        //     deleteButton.className = 'bg-red-500 text-white px-2 py-1 rounded';
        //     deleteButton.textContent = 'Hapus';
        //     deleteButton.addEventListener('click', function() {
        //         facilityDiv.remove();
        //     });
        //     facilityDiv.appendChild(input);
        //     facilityDiv.appendChild(deleteButton);
        //     document.getElementById('facilities-container').appendChild(facilityDiv);
        // });

        document.getElementById('add-rule').addEventListener('click', function() {
            const ruleDiv = document.createElement('div');
            ruleDiv.className = 'flex items-center gap-x-2 mt-2';

            const input = document.createElement('input');
            input.type = 'text';
            input.name = 'rules[]';
            input.placeholder = 'Masukkan tata tertib hunian Anda';
            input.className = 'block w-full p-2 border border-gray-300 rounded';

            const deleteButton = document.createElement('button');
            deleteButton.type = 'button';
            deleteButton.className = 'bg-red-500 text-white px-2 py-1 rounded';
            deleteButton.textContent = 'Hapus';
            deleteButton.addEventListener('click', function() {
                ruleDiv.remove();
            });

            ruleDiv.appendChild(input);
            ruleDiv.appendChild(deleteButton);
            document.getElementById('rules-container').appendChild(ruleDiv);
        });

        document.getElementById('add-foto').addEventListener('click', function() {
            const fotoContainer = document.getElementById('foto-container');
            const currentFotos = fotoContainer.querySelectorAll('input[type="file"]').length;

            // Batasi penambahan foto hingga 15
            if (currentFotos < 15) {
                // Membuat div baru untuk foto dan tombol hapus
                const fotoDiv = document.createElement('div');
                fotoDiv.className = 'flex items-center gap-x-2 mt-2';

                // Membuat input file
                const input = document.createElement('input');
                input.type = 'file';
                input.name = 'foto[]';
                input.className = 'block w-full p-2 border border-gray-300 rounded';
                input.accept = 'image/*';

                // Membuat tombol hapus
                const deleteButton = document.createElement('button');
                deleteButton.type = 'button';
                deleteButton.className = 'bg-red-500 text-white px-2 py-1 rounded';
                deleteButton.textContent = 'Hapus';

                // Menambahkan event untuk tombol hapus
                deleteButton.addEventListener('click', function() {
                    fotoDiv.remove();
                });

                // Menambahkan input dan tombol hapus ke dalam div fotoDiv
                fotoDiv.appendChild(input);
                fotoDiv.appendChild(deleteButton);

                // Menambahkan div fotoDiv ke dalam foto-container
                fotoContainer.appendChild(fotoDiv);
            } else {
                // Menampilkan pop-up SweetAlert2 jika sudah mencapai batas 10 foto
                Swal.fire({
                    title: 'Maksimal 15 Foto!',
                    text: 'Anda sudah mencapai batas maksimum foto yang dapat diunggah.',
                    icon: 'warning',
                    confirmButtonText: 'OK'
                });
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