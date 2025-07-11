<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detail Data Ruko/Kios') }}
            </h2>
        </div>
    </x-slot>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css">


    <div class="py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 sm:p-8 max-w-5xl mx-auto grid grid-cols-1 gap-6">

                <!-- Photo Gallery -->
                <div
                    x-data="{
                        currentIndex: 0,
                        images: {{ json_encode(json_decode($hunianLain->foto, true)) }},
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
                    class="relative w-full overflow-hidden rounded-lg shadow">
                    <!-- Kontainer gambar -->
                    <div class="relative w-full h-60 sm:h-[400px] md:h-[500px] rounded-lg overflow-hidden">
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

                    <!-- Navigasi kiri -->
                    <button
                        @click="prev()"
                        class="absolute top-1/2 left-2 transform -translate-y-1/2 bg-gray-800 bg-opacity-50 p-2 rounded-full text-white hover:bg-opacity-75 z-10">
                        &#10094;
                    </button>

                    <!-- Navigasi kanan -->
                    <button
                        @click="next()"
                        class="absolute top-1/2 right-2 transform -translate-y-1/2 bg-gray-800 bg-opacity-50 p-2 rounded-full text-white hover:bg-opacity-75 z-10">
                        &#10095;
                    </button>
                </div>


                <!-- Details -->
                <div>
                    <p class="text-gray-700 text-sm sm:text-base">{!! nl2br(e($hunianLain->deskripsi)) !!}</p>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-4 text-sm sm:text-base">
                        <div><span class="font-semibold">Nama Pemilik:</span> {{ $hunianLain->nama_pemilik }}</div>
                        <div><span class="font-semibold">Tipe:</span> {{ $hunianLain->tipe_hunian }}</div>
                        <div><span class="font-semibold">Status:</span> {{ $hunianLain->status }}</div>
                        <div><span class="font-semibold">Lokasi Kecamatan:</span> {{ $hunianLain->location }}</div>
                        <div><span class="font-semibold">Alamat Lengakp:</span> {{ $hunianLain->alamat }}</div>
                        <div><span class="font-semibold">Harga:</span> Rp{{ number_format((int) preg_replace('/[^0-9]/', '', $hunianLain->harga), 0, ',', '.') }}</div>
                        <div><span class="font-semibold">Telepon:</span> {{ $hunianLain->telepon }}</div>
                        <div>
                            <span class="font-semibold">Status Verifikasi:</span>
                            <span class="text-blue-500">{{ $hunianLain->status_verifikasi }}</span>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-4 text-sm sm:text-base">
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

                <div class="text-sm sm:text-base">
                    <span class="font-semibold">Bukti Kepemilikan:</span>

                    @if ($hunianLain->bukti_kepemilikan && is_array(json_decode($hunianLain->bukti_kepemilikan)))
                    <ul class="list-disc list-inside mt-2 text-blue-600">
                        @foreach (json_decode($hunianLain->bukti_kepemilikan) as $index => $file)
                        @php
                        $fileUrl = asset('storage/' . $file);
                        @endphp
                        <li>
                            <a href="{{ $fileUrl }}" target="_blank" class="hover:underline">
                                Bukti Kepemilikan {{ $index + 1 }}
                            </a>
                        </li>
                        @endforeach
                    </ul>
                    @else
                    <p class="text-gray-500 mt-2">Belum ada bukti kepemilikan.</p>
                    @endif
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