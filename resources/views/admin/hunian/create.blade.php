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

                <form method="POST" action="{{ route('admin.hunian.store') }}" enctype="multipart/form-data">
                    @csrf

                    <!-- Nama Hunian -->
                    <div>
                        <x-input-label for="nama" :value="__('Nama Hunian')" />
                        <x-text-input id="nama" class="block mt-1 w-full" type="text" name="nama" :value="old('nama')" placeholder="Nama hunian Anda" required autofocus autocomplete="nama" />
                        <x-input-error :messages="$errors->get('nama')" class="mt-2" />
                    </div>

                    <!-- Deskripsi -->
                    <div class="mt-4">
                        <x-input-label for="deskripsi" :value="__('Deskripsi')" />
                        <textarea name="deskripsi" id="deskripsi" cols="30" rows="3" class="border border-slate-300 rounded-xl w-full" placeholder="Deskripsi tentang hunian Anda" required>{{ old('deskripsi') }}</textarea>
                        <x-input-error :messages="$errors->get('deskripsi')" class="mt-2" />
                    </div>

                    <!-- Lokasi Kecamatan -->
                    <div class="mt-4">
                        <x-input-label for="location" :value="__('Lokasi Kecamatan')" />
                        <select name="location" id="location" class="py-3 rounded-lg pl-3 w-full border border-slate-300" required>
                            <option value="" disabled {{ old('location') ? '' : 'selected' }}>Pilih Lokasi Kecamatan</option>

                            <!-- Kota Tegal -->
                            <optgroup label="Kota Tegal">
                                <option value="Margadana" {{ old('location') == 'Margadana' ? 'selected' : '' }}>Margadana</option>
                                <option value="Tegal Barat" {{ old('location') == 'Tegal Barat' ? 'selected' : '' }}>Tegal Barat</option>
                                <option value="Tegal Selatan" {{ old('location') == 'Tegal Selatan' ? 'selected' : '' }}>Tegal Selatan</option>
                                <option value="Tegal Timur" {{ old('location') == 'Tegal Timur' ? 'selected' : '' }}>Tegal Timur</option>
                            </optgroup>

                            <!-- Kabupaten Tegal -->
                            <optgroup label="Kabupaten Tegal">
                                @php
                                    $kecamatans = [
                                        "Adiwerna", "Balapulang", "Bojong", "Bumijawa", "Dukuhturi", "Dukuhwaru",
                                        "Jatinegara", "Kedungbanteng", "Kramat", "Lebaksiu", "Margasari",
                                        "Pagerbarang", "Pangkah", "Slawi", "Surodadi", "Talang", "Tarub", "Warureja"
                                    ];
                                @endphp
                                @foreach($kecamatans as $kecamatan)
                                    <option value="{{ $kecamatan }}" {{ old('location') == $kecamatan ? 'selected' : '' }}>{{ $kecamatan }}</option>
                                @endforeach
                            </optgroup>
                        </select>
                        <x-input-error :messages="$errors->get('location')" class="mt-2" />
                    </div>

                    <!-- Lokasi di Peta -->
                    <div class="mt-4">
                        <x-input-label for="map" :value="__('Tentukan Lokasi Hunian di Peta')" />
                        <button type="button" id="lokasiSekarang" class="btn btn-sm btn-primary mt-2 mb-2">
                            Gunakan Lokasi Saat Ini
                        </button>

                        <div id="map" style="height: 400px;" class="rounded border border-slate-300"></div>

                        <input type="hidden" name="latitude" id="latitude" value="{{ old('latitude') }}">
                        <input type="hidden" name="longitude" id="longitude" value="{{ old('longitude') }}">

                        <p class="text-sm text-gray-600 mt-2">Klik pada peta untuk memilih lokasi hunian.</p>
                        <x-input-error :messages="$errors->get('latitude')" class="mt-2" />
                        <x-input-error :messages="$errors->get('longitude')" class="mt-2" />
                    </div>

                    <!-- Alamat Lengkap -->
                    <div class="mt-4">
                        <x-input-label for="alamat" :value="__('Alamat Lengkap')" />
                        <textarea name="alamat" id="alamat" cols="30" rows="3" class="border border-slate-300 rounded-xl w-full" placeholder="Masukkan Alamat Lengkap" required>{{ old('alamat') }}</textarea>
                        <x-input-error :messages="$errors->get('alamat')" class="mt-2" />
                    </div>

                    <!-- Tombol Submit -->
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

    <!-- Leaflet CSS & JS (CDN) -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <script>
        let defaultLat = -6.869969; // Tegal
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

        // Ambil alamat dari koordinat
        function ambilAlamat(lat, lng) {
            fetch(`https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${lat}&lon=${lng}&accept-language=id`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('alamat').value = data.display_name || '';
                })
                .catch(() => {
                    document.getElementById('alamat').value = '';
                });
        }

        // Ambil koordinat dari alamat (forward geocoding)
        function cariKoordinatDariAlamat(alamat) {
            fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(alamat)}&accept-language=id&limit=1`)
                .then(response => response.json())
                .then(data => {
                    if (data.length > 0) {
                        let lokasi = data[0];
                        let lat = parseFloat(lokasi.lat);
                        let lng = parseFloat(lokasi.lon);

                        map.setView([lat, lng], 16);
                        marker.setLatLng([lat, lng]);
                        document.getElementById('latitude').value = lat;
                        document.getElementById('longitude').value = lng;
                    }
                })
                .catch(err => console.error('Geocoding error:', err));
        }

        marker.on('dragend', function () {
            let posisi = marker.getLatLng();
            document.getElementById('latitude').value = posisi.lat;
            document.getElementById('longitude').value = posisi.lng;
            ambilAlamat(posisi.lat, posisi.lng);
        });

        map.on('click', function (e) {
            let posisi = e.latlng;
            marker.setLatLng(posisi);
            document.getElementById('latitude').value = posisi.lat;
            document.getElementById('longitude').value = posisi.lng;
            ambilAlamat(posisi.lat, posisi.lng);
        });

        document.getElementById('lokasiSekarang').addEventListener('click', function () {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function (posisi) {
                    let lat = posisi.coords.latitude;
                    let lng = posisi.coords.longitude;

                    map.setView([lat, lng], 16);
                    marker.setLatLng([lat, lng]);
                    document.getElementById('latitude').value = lat;
                    document.getElementById('longitude').value = lng;
                    ambilAlamat(lat, lng);
                }, function () {
                    alert('Gagal mendapatkan lokasi. Pastikan izin lokasi diaktifkan.');
                }, {
                    enableHighAccuracy: true,
                    timeout: 10000,
                    maximumAge: 0
                });
            } else {
                alert("Browser tidak mendukung Geolocation.");
            }
        });

        // Deteksi perubahan input alamat → update peta
        let timeoutId;
        document.getElementById('alamat').addEventListener('input', function () {
            clearTimeout(timeoutId);
            const alamat = this.value;
            if (alamat.length > 5) {
                timeoutId = setTimeout(() => {
                    cariKoordinatDariAlamat(alamat);
                }, 600); // debounce 600ms
            }
        });

        // Jika data lama tersedia
        if (document.getElementById('latitude').value && document.getElementById('longitude').value) {
            ambilAlamat(lat, lng);
        }
    </script>


</x-app-layout>