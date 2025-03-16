<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detail Kost') }}
            </h2>
        </div>
    </x-slot>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css">


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8 max-w-5xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- Owner Details -->
                <div class="flex items-center mb-6">
                    <img class="flex-shrink-0 border rounded-full w-20 h-20 mr-5" src="{{ asset('storage/' . $kost->user->avatar) }}" alt="Foto Pemilik Kost">
                    <div class="text-start">
                        <h5 class="mb-2 font-medium">Dikelola Oleh <span class="font-semibold">{{ $kost->user->name }}</span></h5>
                        <span class="text-gray-500">Pemilik Hunian</span>
                    </div>
                </div>

                <!-- Photo Gallery -->
                <div class="col-span-1 md:col-span-2">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Gambar 1 -->
                        <div class="mb-3">
                            <a href="{{ asset('assets/foto.jpg') }}" class="glightbox" data-gallery="kost-gallery">
                                <img src="{{ asset('assets/foto.jpg') }}" class="img-fluid rounded" alt="Foto Hunian Kost 1" style="max-width: 100%; height: auto;">
                            </a>
                        </div>
                        <!-- Gambar 2 -->
                        <div class="mb-3">
                            <a href="{{ asset('assets/foto.jpg') }}" class="glightbox" data-gallery="kost-gallery">
                                <img src="{{ asset('assets/foto.jpg') }}" class="img-fluid rounded" alt="Foto Hunian Kost 2" style="max-width: 100%; height: auto;">
                            </a>
                        </div>
                        <!-- Gambar 3 -->
                        <div class="mb-3">
                            <a href="{{ asset('assets/foto.jpg') }}" class="glightbox" data-gallery="kost-gallery">
                                <img src="{{ asset('assets/foto.jpg') }}" class="img-fluid rounded" alt="Foto Hunian Kost 3" style="max-width: 100%; height: auto;">
                            </a>
                        </div>
                        <!-- Gambar 4 -->
                        <div class="mb-3">
                            <a href="{{ asset('assets/foto.jpg') }}" class="glightbox" data-gallery="kost-gallery">
                                <img src="{{ asset('assets/foto.jpg') }}" class="img-fluid rounded" alt="Foto Hunian Kost 4" style="max-width: 100%; height: auto;">
                            </a>
                        </div>
                    </div>
                </div>


                <!-- Kost Details -->
                <div class="col-span-1 md:col-span-2">
                    <h3 class="text-3xl font-bold text-gray-900 mb-4">{{ $kost->nama }}</h3>
                    <div class="mb-4">
                        <span class="font-semibold text-gray-700">Deskripsi: </span>
                        <p class="text-gray-600">{!! nl2br(e($kost->deskripsi)) !!}</p>
                    </div>
                    <div class="mb-4">
                        <span class="font-semibold text-gray-700">Tipe: </span>
                        <span class="text-gray-600">{{ $kost->type }}</span>
                    </div>
                    <div class="mb-4">
                        <span class="font-semibold text-gray-700">Jumlah Kamar: </span>
                        <span class="text-gray-600">{{ $kost->jumlah_kamar }}</span>
                    </div>
                    <div class="mb-4">
                        <span class="font-semibold text-gray-700">Lokasi Kecamatan: </span>
                        <span class="text-gray-600">{{ $kost->location }}</span>
                    </div>
                    <div class="mb-4">
                        <span class="font-semibold text-gray-700">Alamat Lengkap: </span>
                        <span class="text-gray-600">{{ $kost->alamat }}</span>
                    </div>
                    <div class="mb-4">
                        <span class="font-semibold text-gray-700">Harga: </span>
                        <span class="text-gray-600">Rp{{ number_format($kost->harga, 0, ',', '.') }} / bulan</span>
                    </div>
                    <div class="mb-4">
                        <span class="font-semibold text-gray-700">Telepon: </span>
                        <span class="text-gray-600">{{ $kost->user->phone }}</span>
                    </div>
                </div>

                <!-- Facilities Section -->
                <div class="col-span-1 md:col-span-2">
                    <span class="font-semibold text-gray-700">Fasilitas: </span>
                    <ul class="mt-1 text-gray-600 list-disc pl-6">
                        @forelse ($kost->facilities as $facility)
                        <li>{{ $facility }}</li>
                        @empty
                        <li>Fasilitas tidak tersedia</li>
                        @endforelse
                    </ul>
                </div>

                <!-- Rules Section -->
                <div class="col-span-1 md:col-span-2">
                    <span class="font-semibold text-gray-700">Peraturan: </span>
                    <ul class="mt-1 text-gray-600 list-disc pl-6">
                        @forelse ($kost->rules as $rule)
                        <li>{{ $rule }}</li>
                        @empty
                        <li>Peraturan tidak tersedia</li>
                        @endforelse
                    </ul>
                </div>

                <!-- Pemberitahuan Verifikasi -->
                <div class="col-span-1 md:col-span-2 p-4 mb-2 text-sm text-yellow-800 bg-yellow-200 rounded-lg flex items-center" role="alert">
                    <svg class="w-6 h-6 mr-2 text-yellow-800" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M4.93 19h14.14a2 2 0 001.74-2.77l-7.07-12.14a2 2 0 00-3.48 0L3.19 16.23A2 2 0 004.93 19z" />
                    </svg>
                    <div>
                        <strong>Perhatian!</strong> Tempat kost atau kontrakan Anda belum terverifikasi. Segera upload bukti kepemilikan untuk proses verifikasi.
                    </div>
                </div>


                <!-- Wrapper Alpine.js -->
                <div x-data="{ openModal: false }" class="col-span-1 md:col-span-2 flex justify-end gap-4 mt-6">
                    <!-- Button Bukti Kepemilikan -->
                    <button @click="openModal = true" type="button" class="px-6 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 2a8 8 0 100 16 8 8 0 000-16zM9 13V7h2v6H9zm0 2h2v2H9v-2z" clip-rule="evenodd" />
                        </svg>
                        Upload Bukti Kepemilikan
                    </button>

                    <!-- Modal Upload Bukti Kepemilikan -->
                    <div x-show="openModal" class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 z-50">
                        <div class="bg-white rounded-lg shadow-lg w-full max-w-2xl p-8">
                            <h2 class="text-lg font-semibold mb-4">Upload Bukti Kepemilikan</h2>
                            <form method="POST" action="#" enctype="multipart/form-data">
                                @csrf

                                <!-- Upload SHM / HGB -->
                                <div class="mb-4">
                                    <label for="shm_hgb" class="block text-sm font-medium text-gray-700">Sertifikat Hak Milik (SHM) / Hak Guna Bangunan (HGB)</label>
                                    <input type="file" name="shm_hgb" id="shm_hgb" accept=".pdf,.jpg,.png" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                </div>

                                <!-- Upload SIUK / IMB -->
                                <div class="mb-4">
                                    <label for="siuk_imb" class="block text-sm font-medium text-gray-700">Surat Izin Usaha Kost (SIUK) / Izin Mendirikan Bangunan (IMB)</label>
                                    <input type="file" name="siuk_imb" id="siuk_imb" accept=".pdf,.jpg,.png" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                </div>

                                <!-- Upload KTP Pemilik -->
                                <div class="mb-4">
                                    <label for="ktp_pemilik" class="block text-sm font-medium text-gray-700">Kartu Identitas Pemilik (KTP/SIM)</label>
                                    <input type="file" name="ktp_pemilik" id="ktp_pemilik" accept=".pdf,.jpg,.png" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                </div>

                                <p class="text-xs text-gray-500 mb-4">Format: PDF, JPG, PNG (Max 5MB per file)</p>

                                <!-- Tombol Aksi -->
                                <div class="flex justify-end gap-2">
                                    <button type="button" @click="openModal = false" class="px-4 py-2 bg-gray-400 text-white rounded hover:bg-gray-500">Batal</button>
                                    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Kirim</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>


    <!-- Tambahkan Alpine.js -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <script src="https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js"></script>

    <!-- Inisialisasi GLightbox -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const lightbox = GLightbox({
                selector: '.glightbox', // Select link with 'glightbox' class
                touchNavigation: true, // Enable touch gestures
                loop: true // Enable looping between images
            });
        });
    </script>


</x-app-layout>