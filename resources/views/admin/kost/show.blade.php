<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detail Data Kost/Kontrakan') }}
            </h2>
        </div>
    </x-slot>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css">


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8 max-w-5xl mx-auto grid grid-cols-1 gap-6">

                <!-- Owner Details -->
                <div class="flex items-center gap-4">
                    <img class="border rounded-full w-20 h-20" src="{{ asset('storage/' . $kost->user->avatar) }}" alt="Foto Pemilik Kost">
                    <div class="text-start">
                        <h5 class="mb-1 font-medium">Dikelola Oleh <span class="font-semibold">{{ $kost->user->name }}</span></h5>
                        <span class="text-gray-500">Pemilik Hunian</span>
                    </div>
                </div>

                <!-- Photo Gallery -->
                <div x-data="{ currentIndex: 0, images: {{ json_encode(json_decode($kost->foto, true)) }} }" class="relative w-full">
                    <div class="relative w-full overflow-hidden rounded-lg shadow">
                        <!-- Menampilkan hanya satu gambar aktif -->
                        <a :href="'{{ asset('storage/') }}/' + images[currentIndex]" class="glightbox" data-gallery="kost-gallery">
                            <img :src="'{{ asset('storage/') }}/' + images[currentIndex]" class="w-full h-[400px] object-cover rounded-lg" alt="Foto Hunian">
                        </a>

                        <!-- Menyertakan semua gambar ke dalam glightbox agar bisa dibuka dalam galeri -->
                        <template x-for="(image, index) in images" :key="index">
                            <a :href="'{{ asset('storage/') }}/' + image" class="hidden glightbox" data-gallery="kost-gallery"></a>
                        </template>
                    </div>

                    <!-- Navigasi Gambar -->
                    <button @click="currentIndex = (currentIndex - 1 + images.length) % images.length"
                        class="absolute top-1/2 left-2 transform -translate-y-1/2 bg-gray-800 bg-opacity-50 p-2 rounded-full text-white hover:bg-opacity-75">
                        &#10094;
                    </button>
                    <button @click="currentIndex = (currentIndex + 1) % images.length"
                        class="absolute top-1/2 right-2 transform -translate-y-1/2 bg-gray-800 bg-opacity-50 p-2 rounded-full text-white hover:bg-opacity-75">
                        &#10095;
                    </button>
                </div>


                <!-- Kost Details -->
                <div>
                    <h4 class="text-3xl font-bold text-gray-900 mb-3">{{ $kost->nama }}</h4>
                    <p class="text-gray-700">{!! nl2br(e($kost->deskripsi)) !!}</p>

                    <div class="grid grid-cols-2 gap-4 mt-4">
                        <div><span class="font-semibold">Tipe:</span> {{ $kost->type }}</div>
                        <div><span class="font-semibold">Jumlah Kamar:</span> {{ $kost->jumlah_kamar }}</div>
                        <div><span class="font-semibold">Lokasi Kecamatan:</span> {{ $kost->location }}</div>
                        <div><span class="font-semibold">Alamat Lengkap:</span> {{ $kost->alamat }}</div>
                        <div><span class="font-semibold">Harga:</span> Rp{{ number_format($kost->harga, 0, ',', '.') }} / bulan</div>
                        <div><span class="font-semibold">Telepon:</span> {{ $kost->user->phone }}</div>
                    </div>
                </div>

                <!-- Facilities & Rules -->
                <div class="grid grid-cols-2 gap-4 mt-4">
                    <div>
                        <span class="font-semibold">Fasilitas:</span>
                        <ul class="mt-1 text-gray-600 list-disc pl-6">
                            @forelse ($kost->facilities as $facility)
                            <li>{{ $facility }}</li>
                            @empty
                            <li>Fasilitas tidak tersedia</li>
                            @endforelse
                        </ul>
                    </div>
                    <div>
                        <span class="font-semibold">Peraturan:</span>
                        <ul class="mt-1 text-gray-600 list-disc pl-6">
                            @forelse ($kost->rules as $rule)
                            <li>{{ $rule }}</li>
                            @empty
                            <li>Peraturan tidak tersedia</li>
                            @endforelse
                        </ul>
                    </div>
                </div>

                <div>
                    <span class="font-semibold">Bukti Kepemilikan:</span>
                </div>

                <!-- Pemberitahuan Verifikasi -->
                @if (!$sudahUpload)
                <div class="p-4 mb-2 text-sm text-yellow-800 bg-yellow-200 rounded-lg flex items-center" role="alert">
                    <span class="mr-2">&#9888;</span>
                    <div>
                        <strong>Perhatian!</strong> Tempat kost atau kontrakan Anda belum terverifikasi. Segera upload bukti kepemilikan untuk proses verifikasi. <br>
                        Jika tidak melakukan upload bukti kepemilikan maka tempat kost atau kontrakan Anda tidak akan tampil di website.
                    </div>
                </div>
                @else
                <div class="p-4 mb-2 text-sm text-green-800 bg-green-200 rounded-lg flex items-center" role="alert">
                    <span class="mr-2">&#9989;</span>
                    <div>
                        <strong>Terima kasih!</strong> Bukti kepemilikan sudah berhasil diupload dan sedang dalam proses verifikasi oleh Admin. <br>
                        Tempat kost atau Kontrakan Anda akan segera tampil di website.
                    </div>
                </div>
                @endif


                <!-- Modal Upload Bukti Kepemilikan -->
                <div x-data="{ openModal: false }" class="flex justify-end gap-4 mt-6">
                    <button @click="openModal = true" type="button" class="px-6 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 flex items-center">
                        Upload Bukti Kepemilikan
                    </button>

                    <div x-show="openModal" class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 z-50">
                        <div class="bg-white rounded-lg shadow-lg w-full max-w-2xl p-8">
                            <h2 class="text-lg font-semibold mb-4">Upload Bukti Kepemilikan</h2>
                            <form method="POST" action="{{ route('bukti-kepemilikan.store') }}" enctype="multipart/form-data">
                                @csrf

                                <input type="hidden" name="kost_id" value="{{ $kost->id }}">

                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700">SHM / HGB</label>
                                    <input type="file" name="shm_hgb" accept=".pdf,.jpg,.png" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                </div>
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700">SIUK / IMB</label>
                                    <input type="file" name="siuk_imb" accept=".pdf,.jpg,.png" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                </div>
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700">KTP Pemilik</label>
                                    <input type="file" name="ktp_pemilik" accept=".pdf,.jpg,.png" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                </div>
                                <p class="text-xs text-gray-500 mb-4">Format: PDF, JPG, PNG (Max 5MB per file)</p>
                                <div class="flex justify-end gap-2">
                                    <button type="button" @click="openModal = false" class="px-4 py-2 bg-gray-400 text-white rounded">Batal</button>
                                    <button type="submit" id="submitButton" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                                        Kirim
                                    </button>
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

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sudahUpload = @json($sudahUpload);

            const submitBtn = document.getElementById('submitButton');
            const form = submitBtn.closest('form');

            if (sudahUpload) {
                submitBtn.addEventListener('click', function(e) {
                    e.preventDefault();

                    Swal.fire({
                        icon: 'info',
                        title: 'Sudah Upload!',
                        text: 'Bukti kepemilikan sudah diunggah.',
                        confirmButtonText: 'OK',
                    });
                });
            }
        });
    </script>

</x-app-layout>