   <!-- jQery -->
   <script type="text/javascript" src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>
   <script type="text/javascript"
       src="{{ env('MIDTRANS_FRONT_ENDPOINT') }}"
       data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}">
   </script>

   <script>
       const midtransToken = "{{ $midtransToken }}";
   </script>

   <x-app-layout>
       <x-slot name="header">
           <div class="flex justify-between items-center">
               <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                   {{ __('Detail Pemesanan') }}
               </h2>
           </div>
       </x-slot>

       <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

       <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css">

       <div class="py-12 px-4 sm:px-6 lg:px-8">
            <div class="max-w-7xl mx-auto">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 sm:p-8 max-w-5xl mx-auto grid grid-cols-1 gap-6">

                    <!-- Owner Details -->
                    <div class="flex flex-col sm:flex-row items-center gap-4">
                        <img class="border rounded-full w-20 h-20 object-cover" src="{{ asset('storage/' . $riwayat->kost->user->avatar) }}" alt="Foto Pemilik Kost">
                        <div class="text-center sm:text-start">
                            <h5 class="mb-1 font-medium">Dikelola Oleh <span class="font-semibold">{{ $riwayat->kost->user->name }}</span></h5>
                            <span class="text-gray-500">{{ $riwayat->kost->user->email }}</span>
                        </div>
                    </div>

                    <!-- Photo Gallery -->
                    <div
                        x-data="{
                            currentIndex: 0,
                            images: {{ json_encode(json_decode($riwayat->kost->foto, true)) }},
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
                        <div class="relative w-full h-[250px] sm:h-[400px] md:h-[500px] rounded-lg shadow overflow-hidden">
                            <div
                                class="flex transition-transform duration-700 ease-in-out"
                                :style="`transform: translateX(-${currentIndex * 100}%);`">
                                <template x-for="(image, index) in images" :key="index">
                                    <div class="min-w-full h-60 sm:h-[400px] md:h-[500px]">
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

                    <hr class="border-t border-gray-300 my-3">

                    <!-- Booking Information -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        <p><span class="font-semibold">Tanggal Mulai Sewa:</span> {{ \Carbon\Carbon::parse($riwayat->tanggal_booking)->translatedFormat('l, d F Y') }}</p>
                        <p><span class="font-semibold">Tanggal Keluar:</span> {{ $riwayat->tanggal_keluar ? \Carbon\Carbon::parse($riwayat->tanggal_keluar)->translatedFormat('l, d F Y') : '-' }}</p>
                        <div>
                            <p>
                                <span class="font-semibold">Status Konfirmasi:</span>
                                @if($riwayat->status_konfirmasi == 'Disetujui')
                                <span class="text-green-600">Disetujui</span>
                                @elseif($riwayat->status_konfirmasi == 'Ditolak')
                                <span class="text-red-600">Ditolak</span>
                                @else
                                <span class="text-yellow-600">Pending</span>
                                @endif
                            </p>

                            @if($riwayat->status_konfirmasi == 'Ditolak' && $riwayat->catatan_penolakan)
                            <div class="bg-red-100 text-red-700 border border-red-300 rounded-md p-3 mt-2">
                                <strong>Catatan Penolakan:</strong>
                                <p class="mt-1">{{ $riwayat->catatan_penolakan }}</p>
                            </div>
                            @endif
                        </div>

                        <p>
                            <span class="font-semibold">Status Pembayaran:</span>
                            <span class="text-{{ $riwayat->status_pembayaran == 'Berhasil' ? 'green' : 'yellow' }}-600">{{ $riwayat->status_pembayaran }}</span>
                        </p>
                    </div>

                    <hr class="border-t border-gray-300 my-3">

                    <!-- Kost Details -->
                    <div class="space-y-4">
                        <h4 class="text-xl sm:text-3xl font-bold text-gray-900">{{ $riwayat->kost->hunian->nama }}</h4>
                        <p class="text-gray-700">{!! nl2br(e($riwayat->kost->hunian->deskripsi)) !!}</p>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                            <p><span class="font-semibold">Tipe Hunian:</span> {{ $riwayat->kost->type }}</p>
                            <p><span class="font-semibold">Jumlah Kamar:</span> {{ $riwayat->kost->jumlah_kamar }}</p>
                            <p><span class="font-semibold">Lokasi Kecamatan:</span> {{ $riwayat->kost->hunian->location }}</p>
                            <p>
                                <span class="font-semibold">Harga:</span>
                                @php
                                    $hargaRaw = $riwayat->kost->harga ?? '0';
                                    $hargaPerBulan = (int) preg_replace('/[^0-9]/', '', $hargaRaw);

                                    // Konversi durasi_sewa string ke angka bulan
                                    $durasiText = strtolower($riwayat->durasi_sewa ?? '1 bulan');
                                    $durasi = match ($durasiText) {
                                        '1 bulan' => 1,
                                        '3 bulan' => 3,
                                        '6 bulan' => 6,
                                        '1 tahun' => 12,
                                        default => 1,
                                    };

                                    $totalHarga = $hargaPerBulan * $durasi;

                                    // Diskon berdasarkan durasi
                                    if ($durasi === 6) {
                                        $totalHarga = round($totalHarga * 0.95); // diskon 5%
                                    } elseif ($durasi >= 12) {
                                        $totalHarga = round($totalHarga * 0.9); // diskon 10%
                                    }

                                    // Label durasi
                                    $durasiLabel = match ($durasi) {
                                        1 => '(1 Bulan)',
                                        3 => '(3 Bulan)',
                                        6 => '(6 Bulan)',
                                        12 => '(1 Tahun)',
                                        default => "({$durasi} Bulan)",
                                    };
                                @endphp
                                Rp{{ number_format($totalHarga, 0, ',', '.') }} {{ $durasiLabel }}
                            </p>
                            <p><span class="font-semibold">Alamat Lengkap:</span> {{ $riwayat->kost->hunian->alamat }}</p>
                            <p><span class="font-semibold">Nomor Telepon:</span> {{ $riwayat->kost->user->phone }}</p>
                        </div>
                    </div>

                    <!-- Facilities & Rules -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <span class="font-semibold">Fasilitas:</span>
                            <ul class="list-disc pl-6 text-gray-600 mt-1">
                                @forelse ($riwayat->kost->facilities as $facility)
                                <li>{{ $facility }}</li>
                                @empty
                                <li>Fasilitas tidak tersedia</li>
                                @endforelse
                            </ul>
                        </div>
                        <div>
                            <span class="font-semibold">Peraturan:</span>
                            <ul class="list-disc pl-6 text-gray-600 mt-1">
                                @forelse ($riwayat->kost->rules as $rule)
                                <li>{{ $rule }}</li>
                                @empty
                                <li>Peraturan tidak tersedia</li>
                                @endforelse
                            </ul>
                        </div>
                    </div>

                    <hr class="border-t border-gray-300 my-3">

                    <!-- Rating & Identitas -->
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6">
                        <!-- Bukti Identitas -->
                        <div class="w-full sm:w-1/2">
                            <p class="mb-3">
                                <span class="font-semibold">Bukti Identitas:</span><br>
                                @if (pathinfo($riwayat->kartu_identitas, PATHINFO_EXTENSION) == 'pdf')
                                <a href="{{ asset('storage/' . $riwayat->kartu_identitas) }}" target="_blank" class="text-blue-600 hover:underline">
                                    Lihat Kartu Identitas (PDF)
                                </a>
                                @else
                                <a href="{{ asset('storage/' . $riwayat->kartu_identitas) }}" class="glightbox">
                                    <img src="{{ asset('storage/' . $riwayat->kartu_identitas) }}"
                                        alt="Kartu Identitas"
                                        class="mt-2 w-full max-w-xs border rounded-lg shadow cursor-pointer">
                                </a>
                                @endif
                            </p>
                        </div>

                        <!-- Rating -->
                        <div class="w-full sm:w-1/2 flex flex-col items-center">
                            <h4 class="text-center text-base font-semibold mb-2">Beri Penilaian Anda Setelah Menempati<br> Tempat Kost/Kontrakan</h4>

                            @if ($riwayat && $riwayat->status_pembayaran === 'Berhasil')
                            <div class="flex justify-center space-x-2" id="stars">
                                @for ($i = 1; $i <= 5; $i++)
                                    <i class="fa fa-star cursor-pointer text-gray-300 text-2xl transition duration-200" data-value="{{ $i }}"></i>
                                @endfor
                            </div>
                            <p id="rating-value" class="text-center mt-2 text-gray-600 text-sm">Nilai: 0</p>
                            <input type="hidden" name="kost_id" id="kost_id" value="{{ $riwayat->kost->id }}">
                            <input type="hidden" name="rating" id="rating" value="0">

                            <input type="hidden" id="existing-rating" value="{{ $existingRating ?? 0 }}">

                            <button 
                                id="submit-rating" 
                                class="mt-3 px-3 py-2 text-white text-sm rounded w-full sm:w-auto 
                                    {{ $existingRating ? 'bg-gray-400 cursor-not-allowed' : 'bg-blue-500 hover:bg-blue-600' }}" 
                                {{ $existingRating ? 'disabled' : '' }}>
                                Kirim Rating
                            </button>
                            @else
                            <div class="flex justify-center space-x-2" id="stars-disabled">
                                @for ($i = 1; $i <= 5; $i++)
                                    <i class="fa fa-star text-gray-300 text-2xl transition duration-200"></i>
                                @endfor
                            </div>
                            <p class="text-center mt-2 text-gray-600 text-sm">Nilai: 0</p>
                            <button type="button" onclick="showPaymentAlert()" class="mt-3 px-3 py-2 bg-gray-400 text-white text-sm rounded cursor-not-allowed w-full sm:w-auto">Kirim Rating</button>
                            @endif
                        </div>
                    </div>

                    <!-- Payment Button -->
                    <div class="flex flex-col sm:flex-row justify-end gap-4 mt-6">
                        @if ($riwayat->status_konfirmasi == 'Disetujui' && $riwayat->status_pembayaran != 'Berhasil')
                        <button type="button" id="btn-bayar" class="px-6 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 flex items-center justify-center gap-2 w-full sm:w-auto">
                            <i class="fas fa-wallet"></i>
                            Bayar Sekarang
                        </button>
                        @elseif ($riwayat->status_pembayaran == 'Berhasil')
                            <button type="button" disabled
                                class="px-6 py-2 bg-gray-400 text-white rounded-lg flex items-center justify-center gap-2 w-full sm:w-auto cursor-not-allowed opacity-70">
                                <i class="fas fa-check-circle"></i>
                                Sudah Dibayar
                            </button>
                        @else
                        <button type="button" disabled class="px-6 py-2 bg-gray-400 text-white rounded-lg flex items-center justify-center gap-2 cursor-not-allowed w-full sm:w-auto">
                            <i class="fas fa-hourglass-half"></i>
                            Menunggu Persetujuan
                        </button>
                        @endif
                    </div>

                </div>
            </div>
        </div>


       <!-- <script>
           function bukaModal() {
               const modal = document.getElementById('metodePembayaranModal');
               modal.classList.remove('hidden');
               modal.classList.add('flex');
           }

           function tutupModal() {
               const modal = document.getElementById('metodePembayaranModal');
               modal.classList.add('hidden');
               modal.classList.remove('flex');
           }

           function showAlreadyBayarAlert() {
               alert("Pembayaran sudah berhasil.");
           }
       </script> -->

       <script src="https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js"></script>
       <script>
           document.addEventListener('DOMContentLoaded', function() {
               const lightbox = GLightbox({
                   selector: '.glightbox',
                   touchNavigation: true,
                   loop: true
               });
           });
       </script>

       <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

       <script>
            document.addEventListener("DOMContentLoaded", function () {
                const stars = document.querySelectorAll('#stars .fa-star');
                const ratingValue = document.getElementById('rating-value');
                const submitButton = document.getElementById('submit-rating');
                const kostId = document.getElementById('kost_id')?.value;
                const existingRating = parseInt(document.getElementById('existing-rating')?.value || 0);
                let userRating = existingRating;

                // Tampilkan rating yang sudah ada
                highlightStars(userRating);
                ratingValue.textContent = `Nilai: ${userRating}`;

                const ratingLocked = existingRating > 0;

                if (!ratingLocked) {
                    stars.forEach(star => {
                        star.addEventListener("mouseover", function () {
                            highlightStars(this.getAttribute("data-value"));
                        });

                        star.addEventListener("mouseout", function () {
                            highlightStars(userRating);
                        });

                        star.addEventListener("click", function () {
                            userRating = this.getAttribute("data-value");
                            ratingValue.textContent = `Nilai: ${userRating}`;
                        });
                    });

                    submitButton?.addEventListener("click", function () {
                        if (userRating > 0 && kostId) {
                            submitButton.innerHTML = "Mengirim...";
                            submitButton.disabled = true;

                            fetch('{{ route("rating.store") }}', {
                                method: "POST",
                                headers: {
                                    "Content-Type": "application/json",
                                    "X-CSRF-TOKEN": '{{ csrf_token() }}'
                                },
                                body: JSON.stringify({
                                    rating: userRating,
                                    kost_id: kostId
                                })
                            })
                                .then(response => response.json())
                                .then(data => {
                                    Swal.fire({
                                        icon: data.message.includes("sudah") ? 'warning' : 'success',
                                        title: data.message,
                                        showConfirmButton: false,
                                        timer: 3000
                                    });

                                    setTimeout(() => location.reload(), 1600);
                                })
                                .catch(error => {
                                    console.error("Terjadi kesalahan:", error);
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Oops...',
                                        text: 'Gagal mengirim rating, coba lagi nanti.'
                                    });
                                    submitButton.innerHTML = "Kirim Rating";
                                    submitButton.disabled = false;
                                });
                        } else {
                            Swal.fire({
                                icon: 'info',
                                title: 'Belum ada rating',
                                text: 'Silakan pilih rating terlebih dahulu.'
                            });
                        }
                    });
                } else {
                    stars.forEach(star => {
                        star.classList.add("cursor-not-allowed");
                    });
                }

                function highlightStars(rating) {
                    stars.forEach(star => {
                        if (parseInt(star.getAttribute("data-value")) <= rating) {
                            star.classList.add("text-yellow-400", "scale-110");
                            star.classList.remove("text-gray-300");
                        } else {
                            star.classList.add("text-gray-300");
                            star.classList.remove("text-yellow-400", "scale-110");
                        }
                    });
                }
            });

           function showPaymentAlert() {
               Swal.fire({
                   icon: 'info',
                   title: 'Belum Bisa Memberi Rating',
                   text: 'Silakan selesaikan pembayaran terlebih dahulu untuk memberikan penilaian.',
                   confirmButtonText: 'OK'
               });
           }

           const pembayaran = JSON.parse(`<?= json_encode($pembayaran) ?>`);
       </script>

       <script>
           function showAlreadyBayarAlert() {
               Swal.fire({
                   icon: 'info',
                   title: 'Sudah Dibayar',
                   text: 'Anda sudah melakukan pembayaran.'
               });
           }
       </script>

       <script type="text/javascript" src="{{ asset('js/pay.js') }}"></script>

   </x-app-layout>