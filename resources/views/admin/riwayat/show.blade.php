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

       <div class="py-12">
           <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
               <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8 max-w-5xl mx-auto grid grid-cols-1 gap-6">

                   <!-- Owner Details -->
                   <div class="flex items-center gap-4">
                       <img class="border rounded-full w-20 h-20" src="{{ asset('storage/' . $riwayat->kost->user->avatar) }}" alt="Foto Pemilik Kost">
                       <div class="text-start">
                           <h5 class="mb-1 font-medium">Dikelola Oleh <span class="font-semibold">{{ $riwayat->kost->user->name }}</span></h5>
                           <span class="text-gray-500">{{ $riwayat->kost->user->email }}</span>
                       </div>
                   </div>

                   <!-- Photo Gallery -->
                   <div x-data="{ currentIndex: 0 }" class="relative w-full mt-4">
                       <div class="relative w-full overflow-hidden rounded-lg shadow">
                           @php
                           $images = json_decode($riwayat->kost->foto, true);
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
                   <div class="space-y-4">
                       <h4 class="text-3xl font-bold text-gray-900">{{ $riwayat->kost->nama }}</h4>
                       <p class="text-gray-700">{!! nl2br(e($riwayat->kost->deskripsi)) !!}</p>
                       <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                           <p><span class="font-semibold">Tipe:</span> {{ $riwayat->kost->type }}</p>
                           <p><span class="font-semibold">Jumlah Kamar:</span> {{ $riwayat->kost->jumlah_kamar }}</p>
                           <p><span class="font-semibold">Lokasi Kecamatan:</span> {{ $riwayat->kost->location }}</p>
                           <p><span class="font-semibold">Alamat Lengkap:</span> {{ $riwayat->kost->alamat }}</p>
                           <p><span class="font-semibold">Harga:</span> Rp{{ number_format((int) preg_replace('/[^0-9]/', '', $riwayat->kost->harga), 0, ',', '.') }}/bulan</p>
                           <p><span class="font-semibold">Nomor Telepon:</span> {{ $riwayat->kost->user->phone }}</p>
                       </div>
                   </div>

                   <!-- Facilities & Rules -->
                   <div class="grid grid-cols-2 gap-4">
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

                   <!-- Booking Information -->
                   <div>
                       <p class="mb-3"><span class="font-semibold">Tanggal Mulai Sewa:</span> {{ \Carbon\Carbon::parse($riwayat->tanggal_booking)->translatedFormat('l, d F Y') }}</p>
                       <p class="mb-3"><span class="font-semibold">Tanggal Keluar:</span> {{ $riwayat->tanggal_keluar ? \Carbon\Carbon::parse($riwayat->tanggal_keluar)->translatedFormat('l, d F Y') : "-" }}</p>
                       <p class="mb-3"><span class="font-semibold">Status Konfirmasi:</span>
                           @if($riwayat->status_konfirmasi == 'Disetujui')
                           <span class="text-green-600">Disetujui</span>
                           @elseif($riwayat->status_konfirmasi == 'Ditolak')
                           <span class="text-red-600">Ditolak</span>
                           @else
                           <span class="text-yellow-600">Pending</span>
                           @endif
                       </p>
                       <p class="mb-3"><span class="font-semibold">Status Pembayaran:</span>
                           <span class="text-{{ $riwayat->status_pembayaran == 'Berhasil' ? 'green' : 'yellow' }}-600">{{$riwayat->status_pembayaran}}</span>
                       </p>
                       <p class="mb-3"><span class="font-semibold">Bukti Identitas:</span>
                           <br>
                           @if (pathinfo($riwayat->kartu_identitas, PATHINFO_EXTENSION) == 'pdf')
                           <a href="{{ asset('storage/' . $riwayat->kartu_identitas) }}" target="_blank" class="text-blue-600 hover:underline">
                               Lihat Kartu Identitas (PDF)
                           </a>
                           @else
                           <a href="{{ asset('storage/' . $riwayat->kartu_identitas) }}" class="glightbox">
                               <img src="{{ asset('storage/' . $riwayat->kartu_identitas) }}"
                                   alt="Kartu Identitas"
                                   class="mt-2 w-full max-w-lg border rounded-lg shadow cursor-pointer">
                           </a>
                           @endif
                       </p>
                   </div>

                   <!-- Rating Section -->
                   <div class="p-6 max-w-sm bg-white shadow-lg rounded-lg">
                       <h4 class="text-center text-lg font-semibold mb-4">Beri Penilaian Anda</h4>

                       @if ($riwayat && $riwayat->status_pembayaran === 'Berhasil')
                       <div class="flex justify-center space-x-2" id="stars">
                           @for ($i = 1; $i <= 5; $i++)
                               <i class="fa fa-star cursor-pointer text-gray-300 text-3xl transition duration-200" data-value="{{ $i }}"></i>
                               @endfor
                       </div>
                       <p id="rating-value" class="text-center mt-2 text-gray-600">Nilai: 0</p>
                       <input type="hidden" name="kost_id" id="kost_id" value="{{ $riwayat->kost->id }}">
                       <input type="hidden" name="rating" id="rating" value="0">
                       <button id="submit-rating" class="mt-4 px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition block mx-auto">Kirim Rating</button>
                       @else
                       <div class="flex justify-center space-x-2" id="stars-disabled">
                           @for ($i = 1; $i <= 5; $i++)
                               <i class="fa fa-star text-gray-300 text-3xl transition duration-200"></i>
                               @endfor
                       </div>
                       <p class="text-center mt-2 text-gray-600">Nilai: 0</p>
                       <button type="button" onclick="showPaymentAlert()" class="mt-4 px-4 py-2 bg-gray-400 text-white rounded-lg cursor-not-allowed block mx-auto">Kirim Rating</button>
                       @endif
                   </div>

                   <!-- Payment Button -->
                   <div class="flex justify-end mt-6">
                       @if ($riwayat->status_pembayaran != 'Berhasil')
                       <button type="button" id="btn-bayar" class="px-6 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 flex items-center gap-2">
                           <i class="fas fa-wallet"></i>
                           Bayar Sekarang
                       </button>
                       @else
                       <button type="button" onclick="showAlreadyBayarAlert()" class="px-6 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 flex items-center gap-2">
                           <i class="fas fa-check-circle"></i>
                           Sudah Dibayar
                       </button>
                       @endif
                   </div>

               </div>
           </div>
       </div>


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
           document.addEventListener("DOMContentLoaded", function() {
               const stars = document.querySelectorAll('.fa-star');
               const ratingValue = document.getElementById('rating-value');
               const submitButton = document.getElementById('submit-rating');
               const kostId = document.getElementById('kost_id').value;
               let userRating = 0;

               stars.forEach(star => {
                   star.addEventListener("mouseover", function() {
                       highlightStars(this.getAttribute("data-value"));
                   });

                   star.addEventListener("mouseout", function() {
                       highlightStars(userRating);
                   });

                   star.addEventListener("click", function() {
                       userRating = this.getAttribute("data-value");
                       ratingValue.textContent = `Nilai: ${userRating}`;
                   });
               });

               function highlightStars(rating) {
                   stars.forEach(star => {
                       if (star.getAttribute("data-value") <= rating) {
                           star.classList.add("text-yellow-400", "scale-110");
                           star.classList.remove("text-gray-300");
                       } else {
                           star.classList.add("text-gray-300");
                           star.classList.remove("text-yellow-400", "scale-110");
                       }
                   });
               }

               submitButton.addEventListener("click", function() {
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
                                   icon: data.message === "Anda sudah memberikan rating untuk kost/kontrakan ini." ? 'warning' : 'success',
                                   title: data.message,
                                   showConfirmButton: false,
                                   timer: 3000
                               });

                               if (data.message === "Anda sudah memberikan rating untuk kost/kontrakan ini.") {
                                   submitButton.disabled = true;
                                   stars.forEach(star => star.classList.add("cursor-not-allowed"));
                               }

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