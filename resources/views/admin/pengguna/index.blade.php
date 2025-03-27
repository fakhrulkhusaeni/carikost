<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Kelola Akun Pengguna') }}
            </h2>
            <!-- <a href="#" class="mt-4 sm:mt-0 px-6 py-3 bg-indigo-600 text-white rounded-full font-semibold hover:bg-indigo-700 transition duration-300 text-center">
                Tambah Pengguna
            </a> -->
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
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Pengguna</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Nomor Telepon</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Roles</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr>
                                <td class="px-6 py-4 text-sm text-gray-900 text-center">User 1</td>
                                <td class="px-6 py-4 text-sm text-gray-900 text-center">user1@gmail.com</td>
                                <td class="px-6 py-4 text-sm text-gray-900 text-center">081234567890</td>
                                <td class="px-6 py-4 text-sm text-gray-900 text-center">Pemilik Kost</td>
                                <td class="px-6 py-4 text-center text-sm">
                                    <button class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded">Edit</button>
                                    <button class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded">Hapus</button>
                                </td>
                            </tr>
                            <tr>
                                <td class="px-6 py-4 text-sm text-gray-900 text-center">User 2</td>
                                <td class="px-6 py-4 text-sm text-gray-900 text-center">user2@gmail.com</td>
                                <td class="px-6 py-4 text-sm text-gray-900 text-center">080987654321</td>
                                <td class="px-6 py-4 text-sm text-gray-900 text-center">Pencari Kost</td>
                                <td class="px-6 py-4 text-center text-sm">
                                    <button class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded">Edit</button>
                                    <button class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded">Hapus</button>
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