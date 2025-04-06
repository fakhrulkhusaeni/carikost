<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detail Data Ruko/Kios') }}
            </h2>
        </div>
    </x-slot>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css">


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8 max-w-5xl mx-auto grid grid-cols-1 gap-6">

                <!-- Photo Gallery -->
                <div x-data="{ currentIndex: 0 }" class="relative w-full">
                    <div class="relative w-full overflow-hidden rounded-lg shadow">
                        @php
                        $images = json_decode($hunianLain->foto, true);
                        @endphp

                        <template x-for="(image, index) in {{ json_encode($images) }}" :key="index">
                            <div x-show="currentIndex === index" class="w-full">
                                <a :href="'{{ asset('storage/') }}/' + image" class="glightbox" data-gallery="kost-gallery">
                                    <img :src="'{{ asset('storage/') }}/' + image" class="w-full h-[400px] object-cover rounded-lg" alt="Foto Hunian">
                                </a>
                            </div>
                        </template>
                    </div>

                    <!-- Navigasi Gambar -->
                    <button @click="currentIndex = (currentIndex - 1 + {{ count($images) }}) % {{ count($images) }}"
                        class="absolute top-1/2 left-2 transform -translate-y-1/2 bg-gray-800 bg-opacity-50 p-2 rounded-full text-white hover:bg-opacity-75">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" viewBox="0 0 24 24" stroke="currentColor" fill="none">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                    </button>

                    <button @click="currentIndex = (currentIndex + 1) % {{ count($images) }}"
                        class="absolute top-1/2 right-2 transform -translate-y-1/2 bg-gray-800 bg-opacity-50 p-2 rounded-full text-white hover:bg-opacity-75">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" viewBox="0 0 24 24" stroke="currentColor" fill="none">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </button>
                </div>

                <!-- Kost Details -->
                <div>
                    <p class="text-gray-700">{!! nl2br(e($hunianLain->deskripsi)) !!}</p>

                    <div class="grid grid-cols-2 gap-4 mt-4">
                        <div><span class="font-semibold">Nama Pemilik:</span> {{ $hunianLain->nama_pemilik }}</div>
                        <div><span class="font-semibold">Tipe:</span> {{ $hunianLain->tipe_hunian }}</div>
                        <div><span class="font-semibold">Status:</span> {{ $hunianLain->status }}</div>
                        <div><span class="font-semibold">Lokasi Kecamatan:</span> {{ $hunianLain->location }}</div>
                        <div><span class="font-semibold">Alamat Lengakp:</span> {{ $hunianLain->alamat }}</div>
                        <div><span class="font-semibold">Harga:</span> Rp{{ number_format($hunianLain->harga, 0, ',', '.') }}</div>
                        <div><span class="font-semibold">Telepon:</span> {{ $hunianLain->telepon }}</div>
                        <div>
                            <span class="font-semibold">Status Verifikasi:</span>
                            <span class="text-blue-500">{{ $hunianLain->status_verifikasi }}</span>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4 mt-4">
                    <!-- Facilities -->
                    <div>
                        <span class="font-semibold">Fasilitas:</span>
                        <ul class="mt-1 text-gray-600 list-disc pl-6">
                            @forelse ($hunianLain->fasilitas as $facility)
                            <li>{{ $facility }}</li>
                            @empty
                            <li>Fasilitas tidak tersedia</li>
                            @endforelse
                        </ul>
                    </div>

                    <!-- Rules -->
                    <div>
                        <span class="font-semibold">Detail Hunian:</span>
                        <ul class="mt-1 text-gray-600 list-disc pl-6">
                            @forelse ($hunianLain->detail_hunian as $detail)
                            <li>{{ $detail }}</li>
                            @empty
                            <li>Detail Hunian tidak tersedia</li>
                            @endforelse
                        </ul>
                    </div>
                </div>

                <div>
                    <span class="font-semibold">Bukti Kepemilikan:</span>
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


</x-app-layout>