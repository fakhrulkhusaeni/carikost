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
                        <span class="text-gray-500">{{ $kost->user->email }}</span>
                    </div>
                </div>

                <!-- Photo Gallery -->
                <div
                    x-data="{
                        currentIndex: 0,
                        images: {{ json_encode(json_decode($kost->foto, true)) }},
                        interval: null,
                        startAutoplay() {
                            this.interval = setInterval(() => this.next(), 5000);
                        },
                        stopAutoplay() {
                            clearInterval(this.interval);
                        },
                        next() {
                            this.currentIndex = (this.currentIndex + 1) % this.images.length;
                        },
                        prev() {
                            this.currentIndex = (this.currentIndex - 1 + this.images.length) % this.images.length;
                        }
                    }"
                    x-init="startAutoplay()"
                    @mouseover="stopAutoplay()"
                    @mouseleave="startAutoplay()"
                    class="relative w-full overflow-hidden">
                    <!-- Container Carousel -->
                    <div class="relative w-full h-[500px] rounded-lg shadow overflow-hidden">
                        <div
                            class="flex transition-transform duration-700 ease-in-out"
                            :style="`transform: translateX(-${currentIndex * 100}%);`">
                            <!-- Gambar-gambar -->
                            <template x-for="(image, index) in images" :key="index">
                                <div class="min-w-full h-[500px]">
                                    <a
                                        :href="'{{ asset('storage/') }}/' + image"
                                        class="glightbox"
                                        data-gallery="kost-gallery">
                                        <img
                                            :src="'{{ asset('storage/') }}/' + image"
                                            class="w-full h-full object-cover rounded-lg"
                                            alt="Foto Hunian">
                                    </a>
                                </div>
                            </template>
                        </div>
                    </div>

                    <!-- Tombol Navigasi -->
                    <button
                        @click="prev()"
                        class="absolute top-1/2 left-2 transform -translate-y-1/2 bg-gray-800 bg-opacity-50 p-2 rounded-full text-white hover:bg-opacity-75">
                        &#10094;
                    </button>
                    <button
                        @click="next()"
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
                        <div><span class="font-semibold">Harga:</span> Rp{{ number_format((int) preg_replace('/[^0-9]/', '', $kost->harga), 0, ',', '.') }} / bulan</div>
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

                    @if ($bukti)
                    <ul class="mt-2 text-blue-600 list-disc pl-6">
                        @if ($bukti->siuk_imb)
                        <li>
                            <a href="{{ asset('storage/' . $bukti->siuk_imb) }}" target="_blank" class="underline hover:text-blue-800">
                                Lihat Surat Izin Usaha Kost/Kontrakan
                            </a>
                        </li>
                        @endif

                        @if ($bukti->ktp_pemilik)
                        <li>
                            <a href="{{ asset('storage/' . $bukti->ktp_pemilik) }}" target="_blank" class="underline hover:text-blue-800">
                                Lihat KTP Pemilik
                            </a>
                        </li>
                        @endif
                    </ul>
                    @else
                    <p class="text-gray-600 mt-2">Belum ada bukti kepemilikan diunggah.</p>
                    @endif
                </div>

                <div class="mb-4">
                    <span class="font-semibold block mb-3">Daftar Penghuni ({{ $penghuni->count() }}):</span>

                    @forelse ($penghuni as $item)
                    <div class="flex justify-between items-center mb-3">
                        <div class="flex flex-row items-center gap-x-3">
                            <img src="{{ asset('storage/' . $item->user->avatar) }}" alt="User Avatar" class="rounded-full object-cover w-[70px] h-[70px]">
                            <div class="flex flex-col">
                                <h4 class="text-indigo-950 text-l font-bold">
                                    {{ $item->user->name }}
                                </h4>
                                <p class="text-slate-500 text-sm">
                                    {{ $item->user->phone }}
                                </p>
                            </div>
                        </div>

                        <!-- Tombol Aksi -->
                        <div class="flex gap-x-2">
                            <form action="{{ route('admin.kost.keluar', $item->id) }}" method="POST" class="form-keluar">
                                @csrf
                                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white text-sm px-4 py-2 rounded-md">
                                    Keluar
                                </button>
                            </form>
                        </div>
                    </div>
                    @empty
                    <p class="text-gray-500">Belum ada daftar penghuni.</p>
                    @endforelse
                </div>


                <!-- Pemberitahuan Verifikasi -->
                @if (!$sudahUpload)
                <!-- Kondisi: Belum Upload -->
                <div class="p-4 mb-2 text-sm text-yellow-800 bg-yellow-200 rounded-lg flex items-center" role="alert">
                    <span class="mr-2">&#9888;</span>
                    <div>
                        <strong>Perhatian!</strong> Tempat kost atau kontrakan Anda belum terverifikasi. Segera upload bukti kepemilikan untuk proses verifikasi. <br>
                        Jika tidak melakukan upload bukti kepemilikan maka tempat kost atau kontrakan Anda tidak akan tampil di website.
                    </div>
                </div>
                @elseif ($verifikasiDitolak)
                <!-- Kondisi: Ditolak -->
                <div class="p-4 mb-2 text-sm text-red-800 bg-red-200 rounded-lg flex items-center" role="alert">
                    <span class="mr-2">&#10060;</span>
                    <div>
                        <strong>Verifikasi Ditolak!</strong> Bukti kepemilikan Anda ditolak. Silakan unggah ulang dokumen yang valid agar tempat kost/kontrakan Anda dapat tampil di website.
                    </div>
                </div>
                @elseif ($sudahUpload && !$sudahTerverifikasi)
                <!-- Kondisi: Sudah upload tapi belum diverifikasi -->
                <div class="p-4 mb-2 text-sm text-green-800 bg-green-200 rounded-lg flex items-center" role="alert">
                    <span class="mr-2">&#9989;</span>
                    <div>
                        <strong>Terima kasih!</strong> Bukti kepemilikan sudah berhasil diupload dan sedang dalam proses verifikasi oleh Admin. <br>
                        Tempat kost atau Kontrakan Anda akan segera tampil di website.
                    </div>
                </div>
                @elseif ($sudahUpload && $sudahTerverifikasi)
                <!-- Kondisi: Terverifikasi -->
                <div class="p-4 mb-2 text-sm text-blue-800 bg-blue-200 rounded-lg flex items-center" role="alert">
                    <span class="mr-2">&#10004;</span>
                    <div>
                        <strong>Sudah Terverifikasi!</strong> Tempat kost atau kontrakan Anda telah diverifikasi dan sekarang sudah tampil di website.
                    </div>
                </div>
                @endif


                <!-- Modal Upload Bukti Kepemilikan -->
                <div x-data="{ openModal: false }" class="flex justify-end gap-4 mt-6">

                    @if (!$sudahUpload || $verifikasiDitolak)
                    <button @click="openModal = true" type="button" class="px-6 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 flex items-center">
                        {{ $verifikasiDitolak ? 'Upload Ulang Bukti Kepemilikan' : 'Upload Bukti Kepemilikan' }}
                    </button>
                    @else
                    <button type="button" onclick="showAlreadyUploadedAlert()" class="px-6 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 flex items-center">
                        Sudah Upload Bukti Kepemilikan
                    </button>
                    @endif


                    <div x-show="openModal" class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 z-50">
                        <div class="bg-white rounded-lg shadow-lg w-full max-w-2xl p-8">
                            <h2 class="text-lg font-semibold mb-4">Upload Bukti Kepemilikan</h2>
                            <form method="POST" action="{{ route('bukti-kepemilikan.store') }}" enctype="multipart/form-data">
                                @csrf

                                <input type="hidden" name="kost_id" value="{{ $kost->id }}">

                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700">Surat Izin Usaha Kost/Kontrakan</label>
                                    <input type="file" name="siuk_imb" accept=".pdf,.jpg,.png" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                                </div>
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700">KTP Pemilik</label>
                                    <input type="file" name="ktp_pemilik" accept=".pdf,.jpg,.png" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                                </div>
                                <p class="text-xs text-gray-500 mb-4">Format: PDF, JPG, PNG (Max 5MB per file)</p>
                                <div class="flex justify-end gap-2">
                                    <button type="button" @click="openModal = false" class="px-4 py-2 bg-gray-400 text-white rounded">Batal</button>
                                    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
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
        function showAlreadyUploadedAlert() {
            Swal.fire({
                icon: 'info',
                title: 'Sudah Diunggah',
                text: 'Anda sudah mengunggah bukti kepemilikan.',
                confirmButtonText: 'OK'
            });
        }
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const forms = document.querySelectorAll('.form-keluar');

            forms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault(); // stop form submit

                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        text: "Tindakan ini akan mengeluarkan penghuni dari kost/kontrakan.",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Ya, keluar!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit(); // lanjut submit
                        }
                    });
                });
            });
        });
    </script>


</x-app-layout>