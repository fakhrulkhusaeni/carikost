<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Daftar Data Promosi Hunian') }}
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
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Pemilik</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Nomor Telepon</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Jenis Hunian</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Status (Dijual/Disewakan per-bulan)</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Status Pembayaran</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr>
                                <td class="px-6 py-4 text-sm text-gray-900 text-center">Budi Santoso</td>
                                <td class="px-6 py-4 text-sm text-gray-900 text-center">081234567890</td>
                                <td class="px-6 py-4 text-sm text-gray-900 text-center">Rumah</td>
                                <td class="px-6 py-4 text-sm text-gray-900 text-center">Dijual</td>
                                <td class="px-6 py-4 text-sm text-green-600 text-center">Lunas</td>
                                <td class="px-6 py-4 text-center text-sm">
                                    <a href="#" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">Detail</a>
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


    <!-- SweetAlert2 Script -->

</x-app-layout>