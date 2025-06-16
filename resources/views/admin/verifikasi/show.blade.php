<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detail Verifikasi Kost/Kontrakan') }}
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
                        <div><span class="font-semibold">Alamat Lengakp:</span> {{ $kost->alamat }}</div>
                        <div><span class="font-semibold">Harga:</span> Rp{{ number_format((int) preg_replace('/[^0-9]/', '', $kost->harga), 0, ',', '.') }} / bulan</div>
                        <div><span class="font-semibold">Telepon:</span> {{ $kost->user->phone }}</div>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4 mt-4">
                    <!-- Facilities -->
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

                    <!-- Rules -->
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

                    @if($kost->buktiKepemilikan)
                    <ul class="mt-2 text-blue-600 list-disc pl-6">

                        @if($kost->buktiKepemilikan->siuk_imb)
                        <li>
                            <a href="{{ asset('storage/' . $kost->buktiKepemilikan->siuk_imb) }}" target="_blank" class="underline hover:text-blue-800">
                                Lihat Surat Izin Usaha Kost/Kontrakan
                            </a>
                        </li>
                        @endif

                        @if($kost->buktiKepemilikan->ktp_pemilik)
                        <li>
                            <a href="{{ asset('storage/' . $kost->buktiKepemilikan->ktp_pemilik) }}" target="_blank" class="underline hover:text-blue-800">
                                Lihat KTP Pemilik
                            </a>
                        </li>
                        @endif
                    </ul>
                    @else
                    <p class="text-gray-600 mt-2">Belum ada bukti kepemilikan yang diunggah.</p>
                    @endif
                </div>


                <!-- Buttons -->
                <div class="flex justify-end gap-4 mt-6">
                    @php
                    $statusVerifikasi = $kost->verifikasi->status_verifikasi ?? null;
                    $memenuhiSyaratDokumen = $kost->buktiKepemilikan && (
                    $kost->buktiKepemilikan->siuk_imb ||
                    $kost->buktiKepemilikan->ktp_pemilik
                    );
                    @endphp

                    <div class="flex justify-end gap-4 mt-6">
                        <!-- Tombol Verifikasi atau Sudah Diverifikasi -->
                        @if ($statusVerifikasi === 'terverifikasi')
                        <button type="button" onclick="showAlreadyVerifiedAlert()" class="px-6 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 flex items-center gap-2">
                            Sudah Diverifikasi
                        </button>
                        @else
                        <form action="{{ route('admin.verifikasi.verifikasi', $kost->id) }}" method="POST">
                            @if ($statusVerifikasi === 'ditolak')
                            <!--  -->
                            @else
                            @csrf
                            <button
                                type="submit"
                                class="px-6 py-2 rounded-lg text-white {{ $memenuhiSyaratDokumen ? 'bg-blue-500 hover:bg-blue-600' : 'bg-gray-400 cursor-not-allowed' }}"
                                {{ !$memenuhiSyaratDokumen ? 'disabled' : '' }}>
                                Verifikasi
                            </button>
                            @endif
                        </form>
                        @endif

                        <!-- Tombol Tolak atau Sudah Ditolak -->
                        @if ($statusVerifikasi === 'ditolak')
                        <button type="button" onclick="showAlreadyRejectAlert()" class="px-6 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 flex items-center gap-2">
                            Sudah Ditolak
                        </button>
                        @else
                        <form action="{{ route('admin.verifikasi.tolak', $kost->id) }}" method="POST" class="form-tolak">
                            @if ($statusVerifikasi === 'terverifikasi')
                            <!--  -->
                            @else
                            @csrf
                            <button
                                type="submit"
                                class="px-6 py-2 rounded-lg text-white {{ $memenuhiSyaratDokumen ? 'bg-red-500 hover:bg-red-600' : 'bg-gray-400 cursor-not-allowed' }}"
                                {{ !$memenuhiSyaratDokumen ? 'disabled' : '' }}>
                                Tolak
                            </button>
                            @endif
                        </form>
                        @endif

                        <!-- <form action="{{ route('admin.verifikasi.destroy', $kost->id) }}" method="POST" class="inline-block delete-form">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-6 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600">Tolak</button>
                        </form> -->
                    </div>
                </div>
            </div>
        </div>


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

        <!-- SweetAlert2 Script -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <!-- <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.delete-form').forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault(); // Prevent the default form submission

                    const form = this;

                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        text: "Data ini akan dihapus dan tidak dapat dikembalikan!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit(); // Submit the form if confirmed
                        }
                    });
                });
            });
        });
        </script> -->

        <script>
            function showAlreadyVerifiedAlert() {
                Swal.fire({
                    icon: 'info',
                    title: 'Sudah Diverifikasi',
                    text: 'Tempat kost atau kontrakan ini telah diverifikasi sebelumnya.'
                });
            }

            function showAlreadyRejectAlert() {
                Swal.fire({
                    icon: 'info',
                    title: 'Sudah Ditolak',
                    text: 'Tempat kost atau kontrakan ini telah ditolak sebelumnya.'
                });
            }
        </script>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const forms = document.querySelectorAll('.form-tolak');

                forms.forEach(form => {
                    form.addEventListener('submit', function(e) {
                        e.preventDefault(); // stop form submit

                        Swal.fire({
                            title: 'Tolak Kost?',
                            text: "Apakah Anda yakin ingin menolak kost ini?",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#d33',
                            cancelButtonColor: '#3085d6',
                            confirmButtonText: 'Ya, Tolak',
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