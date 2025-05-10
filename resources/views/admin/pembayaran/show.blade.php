<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detail Booking Kost') }}
            </h2>
        </div>
    </x-slot>

    <!-- GLightbox CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css">

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-4 lg:px-6">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8 max-w-5xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- Details -->
                <div class="flex items-center mb-6">
                    <img class="flex-shrink-0 border rounded-full w-20 h-20 mr-5" src="{{ asset('storage/' . $pembayaran->user->avatar) }}" alt="Foto Pemilik Kost">
                    <div class="text-start">
                        <h5 class="mb-2 font-medium">{{ $pembayaran->user->name }}</h5>
                        <span class="text-gray-500">{{ $pembayaran->user->email }}</span>
                    </div>
                </div>


                <!-- Details -->
                <div class="col-span-1 md:col-span-2">
                    <div class="mb-4">
                        <span class="font-semibold text-gray-700">Jenis Kelamin: </span>
                        <span class="text-gray-600">{{ ucfirst($pembayaran->user->gender) }}</span>
                    </div>
                    <div class="mb-4">
                        <span class="font-semibold text-gray-700">Nomor Telepon: </span>
                        <span class="text-gray-600">{{ $pembayaran->user->phone }}</span>
                    </div>
                    <div class="mb-4">
                        <span class="font-semibold text-gray-700">Tanggal Mulai Sewa: </span>
                        <span class="text-gray-600">{{ \Carbon\Carbon::parse($pembayaran->tanggal_booking)->translatedFormat('d F Y') }}</span>
                    </div>
                    <div class="mb-4">
                        <span class="font-semibold text-gray-700">Status Konfirmasi: </span>
                        @if($pembayaran->status_konfirmasi == 'Disetujui')
                        <span class="text-green-600">Disetujui</span>
                        @elseif($pembayaran->status_konfirmasi == 'Ditolak')
                        <span class="text-red-600">Ditolak</span>
                        @else
                        <span class="text-yellow-600">Belum Disetujui</span>
                        @endif
                    </div>

                    <div class="mb-4">
                        <span class="font-semibold text-gray-700">Status Pembayaran: </span>
                        <span class="text-{{ $pembayaran->status_pembayaran == 'Berhasil' ? 'green' : 'yellow' }}-600">{{$pembayaran->status_pembayaran}}</span>
                    </div>

                    <div class="mb-4">
                        <span class="font-semibold text-gray-700">Bukti Identitas: </span>
                        <br>
                        @if (pathinfo($pembayaran->kartu_identitas, PATHINFO_EXTENSION) == 'pdf')
                        <a href="{{ asset('storage/' . $pembayaran->kartu_identitas) }}" target="_blank" class="text-blue-600 hover:underline">
                            Lihat Kartu Identitas (PDF)
                        </a>
                        @else
                        <a href="{{ asset('storage/' . $pembayaran->kartu_identitas) }}" class="glightbox">
                            <img src="{{ asset('storage/' . $pembayaran->kartu_identitas) }}"
                                alt="Kartu Identitas"
                                class="mt-2 w-full max-w-lg border rounded-lg shadow cursor-pointer">
                        </a>
                        @endif
                    </div>
                </div>

                <!-- Button -->
                <div class="col-span-1 md:col-span-2 flex justify-end mt-6 space-x-4">
                    <!-- Tombol Disetujui -->
                    @if ($pembayaran->status_konfirmasi === 'Disetujui')
                    <button type="button" onclick="showAlreadyApprovedAlert()" class="px-6 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Sudah Disetujui
                    </button>
                    @else
                    <form action="{{ route('admin.pembayaran.approve', $pembayaran->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="px-6 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Disetujui
                        </button>
                    </form>
                    @endif

                    <!-- Tombol Ditolak -->
                    <!-- <form action="{{ route('admin.pembayaran.reject', $pembayaran->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="px-6 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            Ditolak
                        </button>
                    </form> -->
                </div>
            </div>
        </div>
    </div>

    <!-- GLightbox JS -->
    <script src="https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const lightbox = GLightbox({
                selector: '.glightbox'
            });
        });
    </script>

    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function showAlreadyApprovedAlert() {
            Swal.fire({
                icon: 'info',
                title: 'Sudah Disetujui',
                text: 'Sudah disetujui dan tidak bisa disetujui lagi.',
                confirmButtonText: 'OK'
            });
        }
    </script>


</x-app-layout>