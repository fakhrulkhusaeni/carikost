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
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-white-100">
                            <tr>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-900 uppercase tracking-wider">Nama Hunian</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-900 uppercase tracking-wider">Jenis Hunian</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-900 uppercase tracking-wider">Harga (per bulan)</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-900 uppercase tracking-wider">Tanggal Booking</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-900 uppercase tracking-wider">Status Konfirmasi</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-900 uppercase tracking-wider">Status Pembayaran</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-900 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($riwayatBookings as $riwayat)
                            <tr>
                                <td class="px-6 py-4 text-center whitespace-nowrap">{{ $riwayat->kost->nama }}</td>
                                <td class="px-6 py-4 text-center whitespace-nowrap">{{ $riwayat->kost->type}}</td>
                                <td class="px-6 py-4 text-center whitespace-nowrap">Rp{{ number_format($riwayat->kost->harga, 0, ',', '.') }}</td>
                                <td class="px-6 py-4 text-center whitespace-nowrap">{{ \Carbon\Carbon::parse($riwayat->tanggal_booking)->format('d-m-Y') }}</td>
                                <td class="px-6 py-4 text-center whitespace-nowrap">
                                    @if($riwayat->status_konfirmasi == 'Disetujui')
                                    <span class="text-green-500">Disetujui</span>
                                    @elseif($riwayat->status_konfirmasi == 'Ditolak')
                                    <span class="text-red-500">Ditolak</span>
                                    @else
                                    <span class="text-yellow-500">Belum Disetujui</span>
                                    @endif
                                </td>

                                <td class="px-6 py-4 text-center whitespace-nowrap text-yellow-500">{{ $riwayat->status_pembayaran }}</td>

                                <td class="px-6 py-4 text-center whitespace-nowrap text-sm font-medium">
                                    <a href="{{ route('admin.riwayat.show', $riwayat->id)}}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-full font-semibold hover:bg-blue-700 transition duration-300">
                                        Detail
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-6 py-4 text-sm text-gray-500 text-center">
                                    Tidak ada riwayat booking.
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