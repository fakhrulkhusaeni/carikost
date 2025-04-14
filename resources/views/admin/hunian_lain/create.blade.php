<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Data') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden p-10 shadow-sm sm:rounded-lg">

                <form method="POST" action="{{ route('admin.hunian_lain.store') }}" enctype="multipart/form-data">
                    @csrf

                    <!-- Nama Pemilik -->
                    <div>
                        <x-input-label for="nama_pemilik" :value="__('Nama Pemilik')" />
                        <x-text-input id="nama_pemilik" class="block mt-1 w-full" type="text" name="nama_pemilik" :value="old('nama_pemilik')" placeholder="Nama pemilik hunian" required autofocus autocomplete="nama_pemilik" />
                        <x-input-error :messages="$errors->get('nama_pemilik')" class="mt-2" />
                    </div>

                    <!-- Deskripsi -->
                    <div class="mt-4">
                        <x-input-label for="deskripsi" :value="__('Deskripsi')" />
                        <textarea name="deskripsi" id="deskripsi" cols="30" rows="3" class="border border-slate-300 rounded-xl w-full" placeholder="Deskripsi hunian" required>{{ old('deskripsi') }}</textarea>
                        <x-input-error :messages="$errors->get('deskripsi')" class="mt-2" />
                    </div>

                    <!-- Tipe Hunian -->
                    <div class="mt-4">
                        <x-input-label for="tipe_hunian" :value="__('Tipe Hunian')" />
                        <select name="tipe_hunian" id="tipe_hunian" class="py-3 rounded-lg pl-3 w-full border border-slate-300">
                            <option value="" disabled selected>Pilih Tipe Hunian</option>
                            <option value="ruko">Ruko</option>
                            <option value="kios">Kios</option>
                        </select>
                        <x-input-error :messages="$errors->get('tipe_hunian')" class="mt-2" />
                    </div>

                    <!-- Harga -->
                    <div class="mt-4">
                        <x-input-label for="harga" :value="__('Harga')" />
                        <x-text-input id="harga" class="block mt-1 w-full" type="text" name="harga" :value="old('harga')" placeholder="Harga (Dijual/Disewakan)" required autocomplete="off" />
                        <x-input-error :messages="$errors->get('harga')" class="mt-2" />
                    </div>

                    <!-- Status (Dijual / Disewakan) -->
                    <div class="mt-4">
                        <x-input-label for="status" :value="__('Status')" />
                        <select name="status" id="status" class="py-3 rounded-lg pl-3 w-full border border-slate-300">
                            <option value="" disabled selected>Pilih Status</option>
                            <option value="dijual">Dijual</option>
                            <option value="disewakan">Disewakan</option>
                        </select>
                        <x-input-error :messages="$errors->get('status')" class="mt-2" />
                    </div>

                    <!-- Lokasi Kecamatan -->
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

                    <!-- Alamat Lengkap -->
                    <div class="mt-4">
                        <x-input-label for="alamat" :value="__('Alamat Lengkap')" />
                        <textarea name="alamat" id="alamat" cols="30" rows="3" class="border border-slate-300 rounded-xl w-full" placeholder="Alamat Lengkap" required>{{ old('alamat') }}</textarea>
                        <x-input-error :messages="$errors->get('alamat')" class="mt-2" />
                    </div>

                    <!-- Nomor Telepon -->
                    <div class="mt-4">
                        <x-input-label for="telepon" :value="__('Nomor Telepon')" />
                        <x-text-input inputmode="numeric" id="telepon" class="block mt-1 w-full" type="number" name="telepon" :value="old('telepon')" placeholder="Nomor telepon" required autocomplete="telepon" />
                        <x-input-error :messages="$errors->get('telepon')" class="mt-2" />
                    </div>

                    <!-- Detail Hunian -->
                    <div class="mt-4">
                        <x-input-label for="detail_hunian" :value="__('Detail Hunian')" />
                        <div id="detail-hunian-container" class="flex flex-col gap-y-2">
                            <!-- Input detail hunian baru akan ditambahkan di sini -->
                        </div>
                        <button type="button" id="add-detail-hunian" class="mt-2 bg-indigo-600 text-white px-4 py-2 rounded">Tambah Detail Hunian</button>
                        <x-input-error :messages="$errors->get('detail_hunian')" class="mt-2" />
                    </div>

                    <!-- Fasilitas -->
                    <div class="mt-4">
                        <x-input-label for="fasilitas" :value="__('Fasilitas')" />
                        <div id="facilities-container" class="flex flex-col gap-y-2">
                            <!-- Input fasilitas baru akan ditambahkan di sini -->
                        </div>
                        <button type="button" id="add-facility" class="mt-2 bg-indigo-600 text-white px-4 py-2 rounded">Tambah Fasilitas</button>
                        <x-input-error :messages="$errors->get('fasilitas')" class="mt-2" />
                    </div>

                    <!-- Foto Hunian -->
                    <div class="mt-4">
                        <x-input-label for="foto" :value="__('Foto Hunian')" />
                        <div id="foto-container" class="flex flex-col gap-y-2">
                            <!-- Input foto baru akan ditambahkan di sini -->
                        </div>
                        <button type="button" id="add-foto" class="mt-2 bg-indigo-600 text-white px-4 py-2 rounded">Tambah Foto</button>
                        <x-input-error :messages="$errors->get('foto')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="bukti_kepemilikan" :value="__('Bukti Kepemilikan')" />
                        <div id="bukti-container" class="flex flex-col gap-y-2">
                            <!-- Input bukti baru akan ditambahkan di sini -->
                        </div>
                        <button type="button" id="add-bukti" class="mt-2 bg-indigo-600 text-white px-4 py-2 rounded">Tambah Bukti</button>
                        <x-input-error :messages="$errors->get('bukti_kepemilikan')" class="mt-2" />
                    </div>

                    <!-- Status Verifikasi -->
                    <div class="mt-4">
                        <x-input-label for="status_verifikasi" :value="__('Status Verifikasi')" />
                        <div class="flex items-center">
                            <label for="terverifikasi" class="flex items-center">
                                <input type="checkbox" id="terverifikasi" name="status_verifikasi" value="terverifikasi" required class="mr-2" {{ old('status_verifikasi') == 'terverifikasi' ? 'checked' : '' }} />
                                Terverifikasi
                            </label>
                        </div>
                        <x-input-error :messages="$errors->get('status_verifikasi')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <button type="submit" class="font-bold py-4 px-6 bg-indigo-700 text-white rounded-full">
                            Tambah Baru
                        </button>
                    </div>
                </form>


                <!-- SweetAlert2 CSS -->
                <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.11/dist/sweetalert2.min.css" rel="stylesheet">

                <!-- SweetAlert2 JS -->
                <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.11/dist/sweetalert2.min.js"></script>


                <script>
                    document.getElementById('add-facility').addEventListener('click', function() {
                        const facilityDiv = document.createElement('div');
                        facilityDiv.className = 'flex items-center gap-x-2 mt-2';
                        const input = document.createElement('input');
                        input.type = 'text';
                        input.name = 'fasilitas[]';
                        input.placeholder = 'Masukkan fasilitas hunian';
                        input.className = 'block w-full p-2 border border-gray-300 rounded';
                        const deleteButton = document.createElement('button');
                        deleteButton.type = 'button';
                        deleteButton.className = 'bg-red-500 text-white px-2 py-1 rounded';
                        deleteButton.textContent = 'Hapus';
                        deleteButton.addEventListener('click', function() {
                            facilityDiv.remove();
                        });
                        facilityDiv.appendChild(input);
                        facilityDiv.appendChild(deleteButton);
                        document.getElementById('facilities-container').appendChild(facilityDiv);
                    });

                    document.getElementById('add-detail-hunian').addEventListener('click', function() {
                        const detailDiv = document.createElement('div');
                        detailDiv.className = 'flex items-center gap-x-2 mt-2';

                        // Membuat input untuk detail hunian
                        const input = document.createElement('input');
                        input.type = 'text';
                        input.name = 'detail_hunian[]';
                        input.placeholder = 'Masukkan detail hunian';
                        input.className = 'block w-full p-2 border border-gray-300 rounded';

                        // Membuat tombol hapus
                        const deleteButton = document.createElement('button');
                        deleteButton.type = 'button';
                        deleteButton.className = 'bg-red-500 text-white px-2 py-1 rounded';
                        deleteButton.textContent = 'Hapus';

                        deleteButton.addEventListener('click', function() {
                            detailDiv.remove();
                        });

                        detailDiv.appendChild(input);
                        detailDiv.appendChild(deleteButton);
                        document.getElementById('detail-hunian-container').appendChild(detailDiv);
                    });


                    document.getElementById('add-foto').addEventListener('click', function() {
                        const fotoContainer = document.getElementById('foto-container');
                        const currentFotos = fotoContainer.querySelectorAll('input[type="file"]').length;

                        // Batasi penambahan foto hingga 10
                        if (currentFotos < 10) {
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
                                title: 'Maksimal 10 Foto!',
                                text: 'Anda sudah mencapai batas maksimum foto yang dapat diunggah.',
                                icon: 'warning',
                                confirmButtonText: 'OK'
                            });
                        }
                    });

                    document.getElementById('add-bukti').addEventListener('click', function() {
                        const buktiContainer = document.getElementById('bukti-container');

                        const buktiDiv = document.createElement('div');
                        buktiDiv.className = 'flex items-center gap-x-2 mt-2';

                        const input = document.createElement('input');
                        input.type = 'file';
                        input.name = 'bukti_kepemilikan[]';
                        input.className = 'block w-full p-2 border border-gray-300 rounded';
                        input.accept = 'image/*';

                        const deleteButton = document.createElement('button');
                        deleteButton.type = 'button';
                        deleteButton.className = 'bg-red-500 text-white px-2 py-1 rounded';
                        deleteButton.textContent = 'Hapus';

                        deleteButton.addEventListener('click', function() {
                            buktiDiv.remove();
                        });

                        buktiDiv.appendChild(input);
                        buktiDiv.appendChild(deleteButton);
                        buktiContainer.appendChild(buktiDiv);
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

            </div>
        </div>
    </div>
</x-app-layout>