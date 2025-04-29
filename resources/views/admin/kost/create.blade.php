<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Data') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden p-10 shadow-sm sm:rounded-lg">

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
                        <x-input-label for="harga" :value="__('Harga (per bulan)')" />
                        <x-text-input id="harga" class="block mt-1 w-full" type="text" name="harga" :value="old('harga')" placeholder="Masukkan Harga (per bulan)" required autocomplete="off" />
                        <x-input-error :messages="$errors->get('harga')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="facilities" :value="__('Fasilitas')" />
                        <div id="facilities-container" class="flex flex-col gap-y-2">
                            <!-- Input fasilitas baru akan ditambahkan di sini -->
                        </div>
                        <button type="button" id="add-facility" class="mt-2 bg-indigo-600 text-white px-4 py-2 rounded">Tambah Fasilitas</button>
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
                        input.name = 'facilities[]';
                        input.placeholder = 'Masukkan fasilitas hunian Anda';
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