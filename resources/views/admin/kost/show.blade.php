<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detail Data Kost/Kontrakan') }}
            </h2>
        </div>
    </x-slot>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css">


    <div class="py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 sm:p-8 max-w-5xl mx-auto grid grid-cols-1 gap-6">

                <!-- Owner Details -->
                <div class="flex flex-col sm:flex-row items-center gap-4">
                    <img class="border rounded-full w-20 h-20 object-cover" src="{{ asset('storage/' . $kost->user->avatar) }}" alt="Foto Pemilik Kost">
                    <div class="text-center sm:text-start">
                        <h5 class="mb-1 font-medium text-sm sm:text-base">Dikelola Oleh <span class="font-semibold">{{ $kost->user->name }}</span></h5>
                        <span class="text-gray-500 text-sm">{{ $kost->user->email }}</span>
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
                    <div class="relative w-full h-60 sm:h-[400px] md:h-[500px] rounded-lg shadow overflow-hidden">
                        <div class="flex transition-transform duration-700 ease-in-out"
                            :style="`transform: translateX(-${currentIndex * 100}%);`">
                            <template x-for="(image, index) in images" :key="index">
                                <div class="min-w-full h-60 sm:h-[400px] md:h-[500px]">
                                    <a :href="'{{ asset('storage/') }}/' + image" class="glightbox" data-gallery="kost-gallery">
                                        <img :src="'{{ asset('storage/') }}/' + image"
                                            class="w-full h-full object-cover rounded-lg"
                                            alt="Foto Hunian">
                                    </a>
                                </div>
                            </template>
                        </div>
                    </div>

                    <!-- Navigasi -->
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
                    <h4 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-3">{{ $kost->hunian->nama }}</h4>
                    <p class="text-gray-700 text-sm sm:text-base">{!! nl2br(e($kost->hunian->deskripsi)) !!}</p>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-4 text-sm sm:text-base">
                        <div><span class="font-semibold">Tipe Hunian:</span> {{ $kost->type }}</div>
                        <!-- <div><span class="font-semibold">Jumlah Kamar:</span> {{ $kost->jumlah_kamar }}</div> -->
                        <div><span class="font-semibold">Lokasi Kecamatan:</span> {{ $kost->hunian->location }}</div>
                        <div><span class="font-semibold">Telepon:</span> {{ $kost->user->phone }}</div>
                        <div><span class="font-semibold">Alamat Lengkap:</span> {{ $kost->hunian->alamat }}</div>
                        <!-- <div><span class="font-semibold">Harga:</span> Rp{{ number_format((int) preg_replace('/[^0-9]/', '', $kost->harga), 0, ',', '.') }}/bulan</div> -->
                    </div>
                </div>

                <!-- Fasilitas dan Peraturan -->
                <!-- <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-4 text-sm sm:text-base">
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
                </div> -->

                <!-- Bukti Kepemilikan -->
                <div class="text-sm sm:text-base">
                    <span class="font-semibold">Bukti Kepemilikan:</span>
                    @if ($bukti)
                    <ul class="mt-2 text-blue-600 list-disc pl-6">
                        @if ($bukti->siuk_imb)
                        <li><a href="{{ asset('storage/' . $bukti->siuk_imb) }}" target="_blank" class="underline hover:text-blue-800">Lihat Surat Izin Usaha Kost/Kontrakan</a></li>
                        @endif
                        @if ($bukti->ktp_pemilik)
                        <li><a href="{{ asset('storage/' . $bukti->ktp_pemilik) }}" target="_blank" class="underline hover:text-blue-800">Lihat KTP Pemilik</a></li>
                        @endif
                    </ul>
                    @else
                    <p class="text-gray-600 mt-2">Belum ada bukti kepemilikan diunggah.</p>
                    @endif
                </div>

                <!-- Daftar Penghuni -->
                <div class="text-sm sm:text-base">
                    <span class="font-semibold block mb-3">Daftar Penghuni ({{ $penghuni->count() }}):</span>
                    @forelse ($penghuni as $item)
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-3 gap-y-3 sm:gap-0">
                        <div class="flex flex-row items-center gap-x-3">
                            <img src="{{ asset('storage/' . $item->user->avatar) }}" alt="User Avatar" class="rounded-full object-cover w-[60px] h-[60px]">
                            <div class="flex flex-col">
                                <h4 class="text-indigo-950 font-bold">{{ $item->user->name }}</h4>
                                <p class="text-slate-500 text-sm">{{ $item->user->phone }}</p>
                            </div>
                        </div>
                        <form action="{{ route('admin.kost.keluar', $item->id) }}" method="POST" class="form-keluar">
                            @csrf
                            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white text-sm px-4 py-2 rounded-md">Keluar</button>
                        </form>
                    </div>
                    @empty
                    <p class="text-gray-500">Belum ada daftar penghuni.</p>
                    @endforelse
                </div>

                <!-- Alert Verifikasi -->
                <div class="text-sm">
                    @if (!$sudahUpload)
                    <div class="p-4 mb-2 text-yellow-800 bg-yellow-200 rounded-lg flex items-start sm:items-center gap-2" role="alert">
                        <span>&#9888;</span>
                        <div>
                            <strong>Perhatian!</strong> Tempat kost atau kontrakan belum terverifikasi. Upload bukti kepemilikan segera agar tampil di website.
                        </div>
                    </div>
                    @elseif ($verifikasiDitolak)
                    <div class="p-4 mb-2 text-red-800 bg-red-200 rounded-lg flex items-start sm:items-center gap-2" role="alert">
                        <span>&#10060;</span>
                        <div>
                            <strong>Verifikasi Ditolak!</strong> Upload ulang dokumen yang valid agar kost atau kontrakan Anda dapat tampil di website.
                        </div>
                    </div>
                    @elseif ($sudahUpload && !$sudahTerverifikasi)
                    <div class="p-4 mb-2 text-green-800 bg-green-200 rounded-lg flex items-start sm:items-center gap-2" role="alert">
                        <span>&#9989;</span>
                        <div>
                            <strong>Terima kasih!</strong> Dokumen Anda sedang diverifikasi oleh Admin.
                        </div>
                    </div>
                    @elseif ($sudahUpload && $sudahTerverifikasi)
                    <div class="p-4 mb-2 text-blue-800 bg-blue-200 rounded-lg flex items-start sm:items-center gap-2" role="alert">
                        <span>&#10004;</span>
                        <div>
                            <strong>Sudah Terverifikasi!</strong> Kost atau kontrakan Anda telah tampil di website.
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Upload Bukti -->
                <div x-data="{ openModal: false }" class="flex flex-col sm:flex-row justify-end gap-4 mt-6">
                    @if (!$sudahUpload || $verifikasiDitolak)
                    <button @click="openModal = true" class="px-6 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 text-sm">
                        {{ $verifikasiDitolak ? 'Upload Ulang Bukti Kepemilikan' : 'Upload Bukti Kepemilikan' }}
                    </button>
                    @else
                        <button type="button" disabled
                            class="px-6 py-2 bg-gray-400 text-white rounded-lg text-sm cursor-not-allowed opacity-70">
                            Sudah Upload Bukti Kepemilikan
                        </button>
                    @endif

                    <!-- Modal -->
                    <div x-show="openModal" class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 z-50">
                        <div class="bg-white rounded-lg shadow-lg w-full max-w-2xl p-6 sm:p-8">
                            <h2 class="text-lg font-semibold mb-4">Upload Bukti Kepemilikan</h2>
                            <form method="POST" action="{{ route('bukti-kepemilikan.store') }}" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="kost_id" value="{{ $kost->id }}">
                                <div class="mb-4">
                                    <label class="block text-sm font-medium">Surat Izin Usaha Kost/Kontrakan</label>
                                    <input type="file" name="siuk_imb" accept=".pdf,.jpg,.png" class="mt-1 w-full border-gray-300 rounded-md shadow-sm" required>
                                </div>
                                <div class="mb-4">
                                    <label class="block text-sm font-medium">KTP Pemilik</label>
                                    <input type="file" name="ktp_pemilik" accept=".pdf,.jpg,.png" class="mt-1 w-full border-gray-300 rounded-md shadow-sm" required>
                                </div>
                                <p class="text-xs text-gray-500 mb-4">Format: PDF, JPG, PNG (Max 5MB per file)</p>
                                <div class="flex justify-end gap-2">
                                    <button type="button" @click="openModal = false" class="px-4 py-2 bg-gray-400 text-white rounded">Batal</button>
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