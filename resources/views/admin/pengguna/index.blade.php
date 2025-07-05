<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Kelola Akun Pengguna') }}
            </h2>
            <!-- <a href="{{ route('admin.pengguna.create') }}" class="mt-4 sm:mt-0 px-6 py-3 bg-indigo-600 text-white rounded-full font-semibold hover:bg-indigo-700 transition duration-300 text-center">
                Tambah Pengguna
            </a> -->
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                
                <!-- Form Search -->
                <div class="py-4 flex justify-end px-4">
                    <form method="GET" action="{{ route('admin.pengguna.index') }}" class="flex items-center w-full sm:w-96">
                        <input type="text" name="search" value="{{ request('search') }}"
                            class="border border-gray-300 rounded-md px-4 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-400"
                            placeholder="Cari pengguna...">
                        <button type="submit"
                            class="ml-3 bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition duration-300">
                            Cari
                        </button>
                    </form>
                </div>

                <!-- Tabel -->
                <div class="w-full overflow-x-auto">
                    <table class="min-w-[1000px] w-full divide-y divide-gray-200">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Nama Pengguna</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Jenis Kelamin</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Email</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Nomor Telepon</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Tipe Akun</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($users as $user)
                            <tr>
                                <td class="px-6 py-4 text-sm text-gray-900 text-center">{{ $user->name }}</td>
                                <td class="px-6 py-4 text-sm text-gray-900 text-center">{{ $user->gender }}</td>
                                <td class="px-6 py-4 text-sm text-gray-900 text-center">{{ $user->email }}</td>
                                <td class="px-6 py-4 text-sm text-gray-900 text-center">{{ $user->phone }}</td>
                                <td class="px-6 py-4 text-sm text-gray-900 text-center">
                                    @foreach ($user->roles as $role)
                                        {{ $role->name }}@if (!$loop->last), @endif
                                    @endforeach
                                </td>
                                <td class="px-6 py-4 text-center text-sm flex justify-center gap-2 flex-wrap">
                                    <form action="{{ route('admin.pengguna.destroy', $user->id) }}" method="POST" class="delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 text-white rounded-full font-semibold hover:bg-red-700 transition duration-300">
                                            Hapus
                                        </button>
                                    </form>
                                    <a href="{{ route('admin.pengguna.show', $user->id) }}" class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-full font-semibold hover:bg-green-700 transition duration-300">
                                        Detail
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-6 py-4 text-sm text-gray-900 text-center">Data tidak ditemukan.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>


    <!-- SweetAlert2 Script -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.delete-form').forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        text: "Data ini akan dihapus dan tidak dapat dikembalikan!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });
        });
    </script>

</x-app-layout>