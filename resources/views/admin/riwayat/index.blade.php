<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Riwayat Booking') }}
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
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Hunian</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Jenis Hunian</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Harga (per bulan)</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Booking</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Status Konfirmasi</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Status Pembayaran</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($riwayatBookings as $riwayat)
                            <tr>
                                <td class="px-6 py-4 text-sm text-gray-900 text-center">{{ $riwayat->kost->nama }}</td>
                                <td class="px-6 py-4 text-sm text-gray-900 text-center">{{ $riwayat->kost->type}}</td>
                                <td class="px-6 py-4 text-sm text-gray-900 text-center">Rp{{ number_format($riwayat->kost->harga, 0, ',', '.') }}</td>
                                <td class="px-6 py-4 text-sm text-gray-900 text-center">{{ \Carbon\Carbon::parse($riwayat->tanggal_booking)->format('d-m-Y') }}</td>
                                <td class="px-6 py-4 text-sm text-center">
                                    @if($riwayat->status_konfirmasi == 'Disetujui')
                                    <span class="text-green-600">Disetujui</span>
                                    @elseif($riwayat->status_konfirmasi == 'Ditolak')
                                    <span class="text-red-600">Ditolak</span>
                                    @else
                                    <span class="text-yellow-600">Belum Disetujui</span>
                                    @endif
                                </td>

                                <td class="px-6 py-4 text-sm text-yellow-600 text-center">{{ $riwayat->status_pembayaran }}</td>

                                <td class="px-6 py-4 text-center text-sm">
                                    <a href="{{ route('admin.riwayat.show', $riwayat->id)}}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">Detail</a>
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