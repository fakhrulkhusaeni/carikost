   <!-- jQery -->
   <script type="text/javascript" src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>
   <script type="text/javascript"
       src="{{ env('MIDTRANS_FRONT_ENDPOINT') }}"
       data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>

   <script>
       const midtransToken = "{{ $midtransToken }}";
   </script>

   <x-app-layout>
       <x-slot name="header">
           <div class="flex justify-between items-center">
               <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                   {{ __('Detail Kost') }}
               </h2>
           </div>
       </x-slot>

       <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

       <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css">

       <div class="py-12">
           <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
               <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8 max-w-5xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-6">

                   <!-- Owner Details -->
                   <div class="flex items-center mb-6">
                       <img class="flex-shrink-0 border rounded-full w-20 h-20 mr-5" src="{{ asset('storage/' . $riwayat->kost->user->avatar) }}" alt="Foto Pemilik Kost">
                       <div class="text-start">
                           <h5 class="mb-2 font-medium">Dikelola Oleh <span class="font-semibold">{{ $riwayat->kost->user->name }}</span></h5>
                           <span class="text-gray-500">Pemilik Hunian</span>
                       </div>
                   </div>

                   <!-- Photo Gallery -->
                   <div class="col-span-1 md:col-span-2">
                       <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                           <div class="mb-3">
                               <a href="{{ asset('assets/foto.jpg') }}" class="glightbox" data-gallery="kost-gallery">
                                   <img src="{{ asset('assets/foto.jpg') }}" class="img-fluid rounded" alt="Foto Hunian Kost 1" style="max-width: 100%; height: auto;">
                               </a>
                           </div>
                           <div class="mb-3">
                               <a href="{{ asset('assets/foto.jpg') }}" class="glightbox" data-gallery="kost-gallery">
                                   <img src="{{ asset('assets/foto.jpg') }}" class="img-fluid rounded" alt="Foto Hunian Kost 2" style="max-width: 100%; height: auto;">
                               </a>
                           </div>
                       </div>
                   </div>

                   <!-- Kost Details -->
                   <div class="col-span-1 md:col-span-2">
                       <h3 class="text-3xl font-bold text-gray-900 mb-4">{{ $riwayat->kost->nama }}</h3>
                       <div class="mb-4">
                           <span class="font-semibold text-gray-700">Deskripsi: </span>
                           <p class="text-gray-600">{!! nl2br(e($riwayat->kost->deskripsi)) !!}</p>
                       </div>
                       <div class="mb-4">
                           <span class="font-semibold text-gray-700">Tipe: </span>
                           <span class="text-gray-600">Kost {{ $riwayat->kost->type }}</span>
                       </div>
                       <div class="mb-4">
                           <span class="font-semibold text-gray-700">Jumlah Kamar: </span>
                           <span class="text-gray-600">{{ $riwayat->kost->jumlah_kamar }}</span>
                       </div>
                       <div class="mb-4">
                           <span class="font-semibold text-gray-700">Lokasi Kecamatan: </span>
                           <span class="text-gray-600">{{ $riwayat->kost->location }}</span>
                       </div>
                       <div class="mb-4">
                           <span class="font-semibold text-gray-700">Alamat Lengkap: </span>
                           <span class="text-gray-600">{{ $riwayat->kost->alamat }}</span>
                       </div>
                       <div class="mb-4">
                           <span class="font-semibold text-gray-700">Harga: </span>
                           <span class="text-gray-600">Rp{{ number_format($riwayat->kost->harga, 0, ',', '.') }}/bulan</span>
                       </div>

                   </div>

                   <!-- Facilities Section -->
                   <div class="col-span-1 md:col-span-2">
                       <span class="font-semibold text-gray-700">Fasilitas: </span>
                       <ul class="mt-1 text-gray-600 list-disc pl-6">
                           @forelse ($riwayat->kost->facilities as $facility)
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
                           @forelse ($riwayat->kost->rules as $rule)
                           <li>{{ $rule }}</li>
                           @empty
                           <li>Peraturan tidak tersedia</li>
                           @endforelse
                       </ul>
                   </div>

                   <!-- Booking Information -->
                   <div class="col-span-1 md:col-span-2">
                       <h4 class="text-xl font-semibold text-gray-800 mb-2">Informasi Booking</h4>
                       <div class="mb-4">
                           <span class="font-semibold text-gray-700">Tanggal Booking: </span>
                           <span class="text-gray-600">{{ \Carbon\Carbon::parse($riwayat->tanggal_booking)->translatedFormat('d F Y') }}</span>
                       </div>
                       <div class="mb-4">
                           <span class="font-semibold text-gray-700">Status Konfirmasi: </span>
                           @if($riwayat->status_konfirmasi == 'Disetujui')
                           <span class="text-green-600">Disetujui</span>
                           @elseif($riwayat->status_konfirmasi == 'Ditolak')
                           <span class="text-red-600">Ditolak</span>
                           @else
                           <span class="text-yellow-600">Belum Disetujui</span>
                           @endif
                       </div>
                       <div class="mb-4">
                           <span class="font-semibold text-gray-700">Status Pembayaran: </span>
                           <span class="text-yellow-600">{{$riwayat->status_pembayaran}}</span>
                       </div>
                   </div>

                   <!-- Bagian Rating Interaktif (Dipindah ke Kiri) -->
                   <div class="p-6 max-w-sm bg-white shadow-lg rounded-lg">
                       <h4 class="text-center text-lg font-semibold mb-4">Beri Penilaian Anda</h4>
                       <div class="flex justify-center space-x-2">
                           <i class="fa fa-star cursor-pointer text-gray-300 text-3xl transition-transform duration-200" data-value="1"></i>
                           <i class="fa fa-star cursor-pointer text-gray-300 text-3xl transition-transform duration-200" data-value="2"></i>
                           <i class="fa fa-star cursor-pointer text-gray-300 text-3xl transition-transform duration-200" data-value="3"></i>
                           <i class="fa fa-star cursor-pointer text-gray-300 text-3xl transition-transform duration-200" data-value="4"></i>
                           <i class="fa fa-star cursor-pointer text-gray-300 text-3xl transition-transform duration-200" data-value="5"></i>
                       </div>
                       <p id="rating-value" class="text-center mt-2 text-gray-600">Nilai: 0</p>
                       <input type="hidden" name="kost_id" id="kost_id" value="{{ $riwayat->kost->id }}">
                       <button id="submit-rating" class="mt-4 px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition block mx-auto">
                           Kirim Rating
                       </button>

                   </div>



                   <!-- Button: Lakukan Pembayaran -->
                   <div class="col-span-1 md:col-span-2 flex justify-end mt-6 space-x-4">
                       <!-- Tombol Pembayaran -->
                       <form action="#" method="POST">
                           <button type="button" id="btn-bayar" class="px-6 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 flex items-center gap-2">
                               <i class="fas fa-wallet"></i> <!-- Ikon Kartu Kredit -->
                               Lakukan Pembayaran
                           </button>
                       </form>

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

       <script>
           document.addEventListener("DOMContentLoaded", function() {
               const stars = document.querySelectorAll('.fa-star'); // Ambil semua ikon bintang
               const ratingValue = document.getElementById('rating-value'); // Elemen teks nilai rating
               const submitButton = document.getElementById('submit-rating'); // Tombol submit
               const kostId = document.getElementById('kost_id').value; // ID kost
               let userRating = 0; // Simpan nilai rating yang dipilih

               // Event listener untuk hover bintang
               stars.forEach(star => {
                   star.addEventListener("mouseover", function() {
                       highlightStars(this.getAttribute("data-value"));
                   });

                   star.addEventListener("mouseout", function() {
                       highlightStars(userRating); // Kembalikan ke rating yang dipilih
                   });

                   star.addEventListener("click", function() {
                       userRating = this.getAttribute("data-value");
                       ratingValue.textContent = `Nilai: ${userRating}`;
                   });
               });

               // Fungsi untuk memperbarui tampilan bintang
               function highlightStars(rating) {
                   stars.forEach(star => {
                       if (star.getAttribute("data-value") <= rating) {
                           star.classList.add("text-yellow-400", "scale-110"); // Warna bintang aktif & efek zoom
                           star.classList.remove("text-gray-300");
                       } else {
                           star.classList.add("text-gray-300");
                           star.classList.remove("text-yellow-400", "scale-110");
                       }
                   });
               }

               // Event listener untuk tombol submit
               submitButton.addEventListener("click", function() {
                   if (userRating > 0 && kostId) {
                       submitButton.innerHTML = "Mengirim..."; // Indikator loading
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
                               alert(data.message);
                               if (data.message === "Anda sudah memberikan rating untuk kost ini.") {
                                   submitButton.disabled = true;
                                   stars.forEach(star => star.classList.add("cursor-not-allowed"));
                               }
                               setTimeout(() => location.reload(), 1000); // Refresh setelah rating dikirim
                           })
                           .catch(error => {
                               console.error("Terjadi kesalahan:", error);
                               alert("Gagal mengirim rating, coba lagi nanti.");
                               submitButton.innerHTML = "Kirim Rating";
                               submitButton.disabled = false;
                           });
                   } else {
                       alert("Silakan pilih rating terlebih dahulu");
                   }
               });
           });
       </script>

       <script type="text/javascript" src="{{ asset('js/pay.js') }}"></script>

   </x-app-layout>