<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detail Verifikasi Kost') }}
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

                <div class="mb-4">
                    <span class="font-semibold text-gray-700">Bukti Kepemilikan Kost/Kontrakan: </span>
                    <span class="text-gray-600">#</span>
                </div>

                <!-- Buttons: Verifikasi and Hapus -->
                <div class="col-span-1 md:col-span-2 flex justify-end gap-4 mt-6">
                    <!-- Button Verifikasi -->
                    <form action="{{ route('admin.verifikasi.verifikasi', $kost->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="px-6 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
                            Verifikasi
                        </button>
                    </form>

                    <!-- Button Hapus -->
                    <form action="{{ route('admin.verifikasi.destroy', $kost->id) }}" method="POST" class="inline-block delete-form">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-6 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600">
                            Tolak
                        </button>
                    </form>
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
    <script>
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
    </script>


</x-app-layout>