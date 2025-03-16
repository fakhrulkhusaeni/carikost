<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Daftar Pemesanan Kost') }}
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
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Lengkap</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Jenis Kelamin</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Nomor Telepon</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Booking</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Status Konfirmasi</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($pembayarans as $pembayaran)
                            <tr>
                                <td class="px-6 py-4 text-sm text-gray-900 text-center">{{ $pembayaran->user->name }}</td>
                                <td class="px-6 py-4 text-sm text-gray-900 text-center">{{ $pembayaran->user->gender }}</td>
                                <td class="px-6 py-4 text-sm text-gray-900 text-center">{{ $pembayaran->user->email }}</td>
                                <td class="px-6 py-4 text-sm text-gray-900 text-center">{{ $pembayaran->user->phone }}</td>
                                <td class="px-6 py-4 text-sm text-gray-900 text-center">{{ \Carbon\Carbon::parse($pembayaran->tanggal_booking)->format('d-m-Y') }}</td>
                                <!-- Status Konfirmasi -->
                                <td class="px-6 py-4 text-sm text-center">
                                    @if($pembayaran->status == 'Disetujui')
                                    <span class="text-green-600">Disetujui</span>
                                    @elseif($pembayaran->status == 'Ditolak')
                                    <span class="text-red-600">Ditolak</span>
                                    @else
                                    <span class="text-yellow-600">Belum Disetujui</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center text-sm">
                                    <a href="{{ route('admin.pembayaran.show', $pembayaran->id)}}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">Detail</a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-6 py-4 text-sm text-gray-500 text-center">
                                    Tidak ada data pembayaran tersedia.
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