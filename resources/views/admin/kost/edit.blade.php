<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Data') }}
        </h2>
    </x-slot>

    <!-- SweetAlert2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.11/dist/sweetalert2.min.css" rel="stylesheet">

    <div class="py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 sm:p-8 max-w-5xl mx-auto grid grid-cols-1 gap-6">

                <form method="POST" action="{{ route('admin.kost.update', $kost->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div>
                        <x-input-label for="hunian_id" :value="__('Nama Hunian')" />
                        <select name="hunian_id" id="hunian_id" class="block mt-1 w-full border border-slate-300 rounded-lg" required>
                            <option value="" disabled selected>Pilih hunian...</option>
                            @foreach ($hunians as $hunian)
                                <option value="{{ $hunian->id }}" {{ old('hunian_id', $kost->hunian_id ?? '') == $hunian->id ? 'selected' : '' }}>
                                    {{ $hunian->nama }}
                                </option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('hunian_id')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="nama_kamar" :value="__('Nama Hunian')" />
                        <x-text-input id="nama_kamar" class="block mt-1 w-full" type="text" name="nama_kamar"
                            :value="old('nama_kamar', $kost->nama_kamar)" required autofocus autocomplete="nama_kamar"
                            placeholder="Nama tipe kamar Anda" />
                        <x-input-error :messages="$errors->get('nama_kamar')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="type" :value="__('Jenis Hunian')" />
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
                                @foreach($facilities as $facility)
                                <div class="col-md-6 col-12 mb-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" 
                                            name="facilities[]" 
                                            value="{{ $facility->nama_fasilitas }}" 
                                            {{ in_array($facility->nama_fasilitas, $selectedFacilities) ? 'checked' : '' }}>
                                        <label class="form-check-label">{{ strtoupper($facility->nama_fasilitas) }}</label>
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

        // Ambil alamat dalam Bahasa Indonesia
        function ambilAlamat(lat, lng) {
            fetch(`https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${lat}&lon=${lng}&accept-language=id`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('alamat').textContent = data.display_name || 'Alamat tidak ditemukan';
                })
                .catch(error => {
                    document.getElementById('alamat').textContent = 'Gagal mengambil alamat';
                });
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

        if (document.getElementById('latitude').value && document.getElementById('longitude').value) {
            ambilAlamat(lat, lng);
        }
    </script>


</x-app-layout>