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

                <form method="POST" action="{{ route('admin.hunian_lain.update', $hunianLain->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Nama Pemilik -->
                    <div>
                        <x-input-label for="nama_pemilik" :value="__('Nama Pemilik')" />
                        <x-text-input id="nama_pemilik" class="block mt-1 w-full" type="text" name="nama_pemilik" :value="$hunianLain->nama_pemilik" placeholder="Nama pemilik hunian" required autofocus autocomplete="nama_pemilik" />
                        <x-input-error :messages="$errors->get('nama_pemilik')" class="mt-2" />
                    </div>

                    <!-- Deskripsi -->
                    <div class="mt-4">
                        <x-input-label for="deskripsi" :value="__('Deskripsi')" />
                        <textarea name="deskripsi" id="deskripsi" cols="30" rows="3" class="border border-slate-300 rounded-xl w-full" placeholder="Deskripsi hunian" required>{{ $hunianLain->deskripsi }}</textarea>
                        <x-input-error :messages="$errors->get('deskripsi')" class="mt-2" />
                    </div>

                    <!-- Tipe Hunian -->
                    <div class="mt-4">
                        <x-input-label for="tipe_hunian" :value="__('Tipe Hunian')" />
                        <select name="tipe_hunian" id="tipe_hunian" class="py-3 rounded-lg pl-3 w-full border border-slate-300">
                            <option value="" disabled>Pilih Jenis Hunian</option>
                            <option value="ruko" {{ $hunianLain->tipe_hunian == 'ruko' ? 'selected' : '' }}>Ruko</option>
                            <option value="kios" {{ $hunianLain->tipe_hunian == 'kios' ? 'selected' : '' }}>Kios</option>
                        </select>
                        <x-input-error :messages="$errors->get('tipe_hunian')" class="mt-2" />
                    </div>

                    <!-- Harga -->
                    <div class="mt-4">
                        <x-input-label for="harga" :value="__('Harga (Dijual/Disewakan)')" />
                        <x-text-input id="harga" class="block mt-1 w-full" type="text" name="harga" :value="old('harga', $hunianLain->harga)" required autocomplete="harga" />
                        <x-input-error :messages="$errors->get('harga')" class="mt-2" />
                    </div>

                    <!-- Status -->
                    <div class="mt-4">
                        <x-input-label for="status" :value="__('Status')" />
                        <select name="status" id="status" class="py-3 rounded-lg pl-3 w-full border border-slate-300">
                            <option value="" disabled>Pilih Status</option>
                            <option value="dijual" {{ $hunianLain->status == 'dijual' ? 'selected' : '' }}>Dijual</option>
                            <option value="disewakan" {{ $hunianLain->status == 'disewakan' ? 'selected' : '' }}>Disewakan</option>
                        </select>
                        <x-input-error :messages="$errors->get('status')" class="mt-2" />
                    </div>

                    <!-- Lokasi -->
                    <div class="mt-4">
                        <x-input-label for="location" :value="__('Lokasi Kecamatan')" />
                        <select name="location" id="location" class="py-3 rounded-lg pl-3 w-full border border-slate-300" required>
                            <option value="" disabled selected>Pilih Lokasi Kecamatan</option>

                            <!-- Kota Tegal -->
                            <optgroup label="Kota Tegal">
                                <option value="Margadana" {{ old('location', $hunianLain->location) == 'Margadana' ? 'selected' : '' }}>Margadana</option>
                                <option value="Tegal Barat" {{ old('location', $hunianLain->location) == 'Tegal Barat' ? 'selected' : '' }}>Tegal Barat</option>
                                <option value="Tegal Timur" {{ old('location', $hunianLain->location) == 'Tegal Timur' ? 'selected' : '' }}>Tegal Timur</option>
                                <option value="Tegal Selatan" {{ old('location', $hunianLain->location) == 'Tegal Selatan' ? 'selected' : '' }}>Tegal Selatan</option>
                            </optgroup>

                            <!-- Kabupaten Tegal -->
                            <optgroup label="Kabupaten Tegal">
                                <option value="Adiwerna" {{ old('location', $hunianLain->location) == 'Adiwerna' ? 'selected' : '' }}>Adiwerna</option>
                                <option value="Balapulang" {{ old('location', $hunianLain->location) == 'Balapulang' ? 'selected' : '' }}>Balapulang</option>
                                <option value="Bojong" {{ old('location', $hunianLain->location) == 'Bojong' ? 'selected' : '' }}>Bojong</option>
                                <option value="Bumijawa" {{ old('location', $hunianLain->location) == 'Bumijawa' ? 'selected' : '' }}>Bumijawa</option>
                                <option value="Dukuhturi" {{ old('location', $hunianLain->location) == 'Dukuhturi' ? 'selected' : '' }}>Dukuhturi</option>
                                <option value="Dukuhwaru" {{ old('location', $hunianLain->location) == 'Dukuhwaru' ? 'selected' : '' }}>Dukuhwaru</option>
                                <option value="Jatinegara" {{ old('location', $hunianLain->location) == 'Jatinegara' ? 'selected' : '' }}>Jatinegara</option>
                                <option value="Kedungbanteng" {{ old('location', $hunianLain->location) == 'Kedungbanteng' ? 'selected' : '' }}>Kedungbanteng</option>
                                <option value="Kramat" {{ old('location', $hunianLain->location) == 'Kramat' ? 'selected' : '' }}>Kramat</option>
                                <option value="Lebaksiu" {{ old('location', $hunianLain->location) == 'Lebaksiu' ? 'selected' : '' }}>Lebaksiu</option>
                                <option value="Margasari" {{ old('location', $hunianLain->location) == 'Margasari' ? 'selected' : '' }}>Margasari</option>
                                <option value="Pagerbarang" {{ old('location', $hunianLain->location) == 'Pagerbarang' ? 'selected' : '' }}>Pagerbarang</option>
                                <option value="Pangkah" {{ old('location', $hunianLain->location) == 'Pangkah' ? 'selected' : '' }}>Pangkah</option>
                                <option value="Slawi" {{ old('location', $hunianLain->location) == 'Slawi' ? 'selected' : '' }}>Slawi</option>
                                <option value="Surodadi" {{ old('location', $hunianLain->location) == 'Surodadi' ? 'selected' : '' }}>Surodadi</option>
                                <option value="Talang" {{ old('location', $hunianLain->location) == 'Talang' ? 'selected' : '' }}>Talang</option>
                                <option value="Tarub" {{ old('location', $hunianLain->location) == 'Tarub' ? 'selected' : '' }}>Tarub</option>
                                <option value="Warureja" {{ old('location', $hunianLain->location) == 'Warureja' ? 'selected' : '' }}>Warureja</option>
                            </optgroup>
                        </select>
                        <x-input-error :messages="$errors->get('location')" class="mt-2" />
                    </div>

                    <!-- Alamat -->
                    <div class="mt-4">
                        <x-input-label for="alamat" :value="__('Alamat')" />
                        <textarea name="alamat" id="alamat" cols="30" rows="3" class="border border-slate-300 rounded-xl w-full" required>{{ old('alamat', $hunianLain->alamat) }}</textarea>
                        <x-input-error :messages="$errors->get('alamat')" class="mt-2" />
                    </div>

                    <!-- Telepon -->
                    <div class="mt-4">
                        <x-input-label for="telepon" :value="__('Nomor Telepon')" />
                        <x-text-input id="telepon" class="block mt-1 w-full" type="number" name="telepon" :value="old('telepon', $hunianLain->telepon)" required />
                        <x-input-error :messages="$errors->get('telepon')" class="mt-2" />
                    </div>

                    <!-- Fasilitas -->
                    <div class="mt-4">
                        <x-input-label for="fasilitas" :value="__('Fasilitas')" />
                        <div id="fasilitas-container" class="flex flex-col gap-y-2">
                            @foreach(old('fasilitas', $hunianLain->fasilitas ?? []) as $facility)
                            <div class="flex items-center gap-2">
                                <x-text-input name="fasilitas[]" class="w-full" type="text" value="{{ $facility }}" placeholder="Masukkan fasilitas" />
                                <button type="button" class="remove-facility bg-red-600 text-white px-2 py-1 rounded">Hapus</button>
                            </div>
                            @endforeach
                        </div>
                        <button type="button" id="add-facility" class="mt-2 bg-indigo-600 text-white px-4 py-2 rounded">Tambah Fasilitas</button>
                        <x-input-error :messages="$errors->get('fasilitas')" class="mt-2" />
                    </div>

                    <!-- Detail -->
                    <div class="mt-4">
                        <x-input-label for="detail_hunian" :value="__('Detail Hunian')" />
                        <div id="detail-hunian-container" class="flex flex-col gap-y-2">
                            @foreach(old('detail_hunian', $hunianLain->detail_hunian ?? []) as $detail)
                            <div class="flex items-center gap-2">
                                <x-text-input name="detail_hunian[]" class="w-full" type="text" value="{{ $detail }}" placeholder="Masukkan detail hunian" />
                                <button type="button" class="remove-detail bg-red-600 text-white px-2 py-1 rounded">Hapus</button>
                            </div>
                            @endforeach
                        </div>
                        <button type="button" id="add-detail" class="mt-2 bg-indigo-600 text-white px-4 py-2 rounded">Tambah Detail Hunian</button>
                        <x-input-error :messages="$errors->get('detail_hunian')" class="mt-2" />
                    </div>

                    <!-- Foto -->
                    <div class="mt-4">
                        <x-input-label for="foto" :value="__('Foto Hunian')" />
                        <div id="foto-container" class="flex flex-col gap-y-2">
                            @foreach(old('foto', json_decode($hunianLain->foto ?? '[]', true)) as $photo)
                            <div class="flex items-center gap-2">
                                <img src="{{ asset('storage/' . $photo) }}" alt="Foto Hunian" class="w-16 h-16 rounded-lg object-cover" />
                                <input type="hidden" name="existing_foto[]" value="{{ $photo }}">
                                <button type="button" class="remove-photo bg-red-600 text-white px-2 py-1 rounded">Hapus</button>
                            </div>
                            @endforeach
                        </div>
                        <button type="button" id="add-foto" class="mt-2 bg-indigo-600 text-white px-4 py-2 rounded">Tambah Foto</button>
                        <x-input-error :messages="$errors->get('foto')" class="mt-2" />
                    </div>

                    <!-- Bukti -->
                    <div class="mt-4">
                        <x-input-label for="bukti_kepemilikan" :value="__('Bukti Kepemilikan')" />
                        <div id="bukti-container" class="flex flex-col gap-y-2">
                            @foreach(old('bukti_kepemilikan', json_decode($hunianLain->bukti_kepemilikan ?? '[]', true)) as $bukti)
                            <div class="flex items-center gap-2">
                                <img src="{{ asset('storage/' . $bukti) }}" alt="Bukti Kepemilikan" class="w-16 h-16 rounded-lg object-cover" />
                                <input type="hidden" name="existing_bukti[]" value="{{ $bukti }}">
                                <button type="button" class="remove-bukti bg-red-600 text-white px-2 py-1 rounded">Hapus</button>
                            </div>
                            @endforeach
                        </div>
                        <button type="button" id="add-bukti" class="mt-2 bg-indigo-600 text-white px-4 py-2 rounded">Tambah Bukti</button>
                        <x-input-error :messages="$errors->get('bukti_kepemilikan')" class="mt-2" />
                    </div>

                    <!-- Status Verifikasi -->
                    <div class="mt-4">
                        <x-input-label for="status_verifikasi" :value="__('Status Verifikasi')" />
                        <div class="flex items-center">
                            <label for="terverifikasi" class="flex items-center">
                                <input type="checkbox" id="terverifikasi" name="status_verifikasi" value="terverifikasi" required class="mr-2"
                                    {{ old('status_verifikasi', $hunianLain->status_verifikasi) == 'terverifikasi' ? 'checked' : '' }} />
                                Terverifikasi
                            </label>
                        </div>
                        <x-input-error :messages="$errors->get('status_verifikasi')" class="mt-2" />
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
            document.getElementById('add-facility').addEventListener('click', () => {
                const container = document.getElementById('fasilitas-container');
                const inputHTML = `
                <div class="flex items-center gap-2">
                    <input type="text" name="fasilitas[]" class="w-full border border-slate-300 rounded-lg" placeholder="Masukkan fasilitas" required>
                    <button type="button" class="remove-facility bg-red-600 text-white px-2 py-1 rounded">Hapus</button>
                </div>`;
                container.insertAdjacentHTML('beforeend', inputHTML);
            });

            // Hapus fasilitas
            document.getElementById('fasilitas-container').addEventListener('click', (event) => {
                if (event.target.classList.contains('remove-facility')) {
                    event.target.closest('div').remove();
                }
            });

            // Tambah detail hunian
            document.getElementById('add-detail').addEventListener('click', () => {
                const container = document.getElementById('detail-hunian-container');
                const inputHTML = `
                <div class="flex items-center gap-2">
                    <input type="text" name="detail_hunian[]" class="w-full border border-slate-300 rounded-lg" placeholder="Masukkan detail hunian" required>
                    <button type="button" class="remove-detail bg-red-600 text-white px-2 py-1 rounded">Hapus</button>
                </div>`;
                container.insertAdjacentHTML('beforeend', inputHTML);
            });

            // Hapus detail hunian
            document.getElementById('detail-hunian-container').addEventListener('click', (event) => {
                if (event.target.classList.contains('remove-detail')) {
                    event.target.closest('div').remove();
                }
            });


            // Tambah foto hunian
            document.getElementById('add-foto').addEventListener('click', () => {
                const container = document.getElementById('foto-container');

                // Hitung jumlah foto yang sudah ada (img) dan input file baru
                const existingPhotos = container.querySelectorAll('img').length;
                const addedInputs = container.querySelectorAll('input[type="file"]').length;

                const totalPhotos = existingPhotos + addedInputs;

                if (totalPhotos < 10) {
                    const inputHTML = `
                    <div class="flex items-center gap-2">
                        <input type="file" name="foto[]" class="w-full border border-slate-300 rounded-lg" accept="image/*" required>
                        <button type="button" class="remove-photo bg-red-600 text-white px-2 py-1 rounded">Hapus</button>
                    </div>`;
                    container.insertAdjacentHTML('beforeend', inputHTML);
                } else {
                    Swal.fire({
                        title: 'Maksimal 10 Foto Hunian!',
                        text: 'Anda sudah mencapai batas maksimum foto yang dapat diunggah.',
                        icon: 'warning',
                        confirmButtonText: 'OK'
                    });
                }
            });

            // Hapus foto
            document.addEventListener('click', (event) => {
                if (event.target.classList.contains('remove-photo')) {
                    event.target.closest('div').remove();
                }
            });

            // Tambah foto bukti
            document.getElementById('add-bukti').addEventListener('click', () => {
                const container = document.getElementById('bukti-container');

                // Hitung jumlah bukti yang sudah ada (img) dan input file baru
                const existingBukti = container.querySelectorAll('img').length;
                const addedInputs = container.querySelectorAll('input[type="file"]').length;

                const totalBukti = existingBukti + addedInputs;

                if (totalBukti < 5) {
                    const inputHTML = `
                    <div class="flex items-center gap-2">
                        <input type="file" name="bukti_kepemilikan[]" class="w-full border border-slate-300 rounded-lg" accept="image/*" required>
                        <button type="button" class="remove-bukti bg-red-600 text-white px-2 py-1 rounded">Hapus</button>
                    </div>`;
                    container.insertAdjacentHTML('beforeend', inputHTML);
                } else {
                    Swal.fire({
                        title: 'Maksimal 5 Bukti Kepemilikan!',
                        text: 'Anda sudah mencapai batas maksimum bukti kepemilikan yang dapat diunggah.',
                        icon: 'warning',
                        confirmButtonText: 'OK'
                    });
                }
            });

            // Hapus foto bukti
            document.addEventListener('click', (event) => {
                if (event.target.classList.contains('remove-bukti')) {
                    event.target.closest('div').remove();
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

</x-app-layout>