<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Data') }}
        </h2>
    </x-slot>

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
                        <x-input-label for="harga" :value="__('Harga (per bulan)')" />
                        <x-text-input id="harga" class="block mt-1 w-full" type="number" name="harga" :value="old('harga', $kost->harga)" required />
                        <x-input-error :messages="$errors->get('harga')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="facilities" :value="__('Fasilitas')" />
                        <div id="facilities-container" class="flex flex-col gap-y-2">
                            @foreach(old('facilities', $kost->facilities ?? []) as $facility)
                            <div class="flex items-center gap-2">
                                <x-text-input name="facilities[]" class="w-full" type="text" value="{{ $facility }}" placeholder="Masukkan fasilitas" />
                                <button type="button" class="remove-facility bg-red-600 text-white px-2 py-1 rounded">Hapus</button>
                            </div>
                            @endforeach
                        </div>
                        <button type="button" id="add-facility" class="mt-2 bg-indigo-600 text-white px-4 py-2 rounded">Tambah Fasilitas</button>
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
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <button type="submit" class="font-bold py-4 px-6 bg-indigo-700 text-white rounded-full">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>


                <!-- SweetAlert2 CSS -->
                <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.11/dist/sweetalert2.min.css" rel="stylesheet">

                <!-- SweetAlert2 JS -->
                <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.11/dist/sweetalert2.min.js"></script>


                <script>
                    document.addEventListener('DOMContentLoaded', () => {
                        // Tambah fasilitas
                        document.getElementById('add-facility').addEventListener('click', () => {
                            const container = document.getElementById('facilities-container');
                            const inputHTML = `
                                <div class="flex items-center gap-2">
                                    <input type="text" name="facilities[]" class="w-full border border-slate-300 rounded-lg" placeholder="Masukkan fasilitas" required>
                                    <button type="button" class="remove-facility bg-red-600 text-white px-2 py-1 rounded">Hapus</button>
                                </div>`;
                            container.insertAdjacentHTML('beforeend', inputHTML);
                        });

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
                            const inputHTML = `
                                <div class="flex items-center gap-2">
                                    <input type="file" name="foto[]" class="w-full border border-slate-300 rounded-lg" accept="image/*" required>
                                    <button type="button" class="remove-photo bg-red-600 text-white px-2 py-1 rounded">Hapus</button>
                                </div>`;
                            container.insertAdjacentHTML('beforeend', inputHTML);
                        });

                        // Hapus elemen (fasilitas, peraturan, atau foto)
                        document.addEventListener('click', (event) => {
                            if (event.target.classList.contains('remove-facility') || event.target.classList.contains('remove-rule') || event.target.classList.contains('remove-photo')) {
                                event.target.parentElement.remove();
                            }
                        });
                    });
                </script>
            </div>
        </div>
    </div>
</x-app-layout>