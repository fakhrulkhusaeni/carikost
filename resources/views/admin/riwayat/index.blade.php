<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Riwayat Pemesanan') }}
            </h2>

        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                <!-- Membuat tabel bisa digulir pada layar kecil -->
                <div class="w-full overflow-x-auto">
                    <table class="min-w-[1000px] w-full divide-y divide-gray-200">
                        <thead class="bg-white-100">
                            <tr>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-900 uppercase tracking-wider">Nama Hunian</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-900 uppercase tracking-wider">Jenis Hunian</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-900 uppercase tracking-wider">Harga</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-900 uppercase tracking-wider">Tanggal Mulai Sewa</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-900 uppercase tracking-wider">Status Konfirmasi</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-900 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($riwayatBookings as $riwayat)
                            <tr>
                                <td class="px-6 py-4 text-center whitespace-nowrap">{{ $riwayat->kost->hunian->nama }}</td>
                                <td class="px-6 py-4 text-center whitespace-nowrap">{{ $riwayat->kost->type}}</td>
                                <td class="px-6 py-4 text-center whitespace-nowrap">
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

                                        // Terapkan diskon jika berlaku
                                        if ($durasi === 6) {
                                            $totalHarga = round($totalHarga * 0.95); // diskon 5%
                                        } elseif ($durasi >= 12) {
                                            $totalHarga = round($totalHarga * 0.9); // diskon 10%
                                        }
                                    @endphp
                                    Rp{{ number_format($totalHarga, 0, ',', '.') }}
                                </td>

                                <td class="px-6 py-4 text-center whitespace-nowrap">{{ \Carbon\Carbon::parse($riwayat->tanggal_booking)->format('d-m-Y') }}</td>
                                <td class="px-6 py-4 text-center whitespace-nowrap">
                                    @if($riwayat->status_konfirmasi == 'Disetujui')
                                    <span class="text-green-500">Disetujui</span>
                                    @elseif($riwayat->status_konfirmasi == 'Ditolak')
                                    <span class="text-red-500">Ditolak</span>
                                    @else
                                    <span class="text-yellow-500">Pending</span>
                                    @endif
                                </td>

                                <td class="px-6 py-4 text-center whitespace-nowrap text-sm font-medium">
                                    <a href="{{ route('admin.riwayat.show', $riwayat->id)}}" class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-full font-semibold hover:bg-green-700 transition duration-300">
                                        Detail
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-6 py-4 text-sm text-gray-500 text-center">
                                    Tidak ada riwayat pemesanan.
                                </td>
                            </tr>
                            @endforelse

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- SweetAlert2 Script -->

</x-app-layout>