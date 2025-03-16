<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Verifikasi Data') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-white-100">
                            <tr>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Pemilik</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Kost/Kontrakan</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Jenis Hunian</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah Kamar</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($kosts as $kost)
                            <tr>
                                <td class="px-6 py-4 text-sm text-gray-900 text-center">{{ $kost->user->name }}</td>
                                <td class="px-6 py-4 text-sm text-gray-900 text-center">{{ $kost->nama }}</td>
                                <td class="px-6 py-4 text-sm text-gray-900 text-center">{{ $kost->type }}</td>
                                <td class="px-6 py-4 text-sm text-gray-900 text-center">{{ $kost->jumlah_kamar }}</td>
                                <td class="px-6 py-4 text-sm text-center">
                                    @if ($kost->verifikasi)
                                    @if ($kost->verifikasi->status === 'terverifikasi')
                                    <span class="text-blue-600">
                                        Terverifikasi
                                    </span>
                                    @else
                                    <span class="text-yellow-600">
                                        {{ ucfirst($kost->verifikasi->status) }}
                                    </span>
                                    @endif
                                    @else
                                    <span class="text-red-600">Belum Diverifikasi</span>
                                    @endif
                                </td>

                                <td class="px-6 py-4 text-center text-sm">
                                    <a href="{{ route('admin.verifikasi.show', $kost->id)}}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">Detail</a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-sm text-gray-900 text-center">Data tidak ditemukan.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>