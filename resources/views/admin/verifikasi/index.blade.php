<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Kelola Daftar Kost dan Kontrakan') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-lg rounded-lg overflow-hidden">

                <!-- Form Pencarian -->
                <div class="py-4 flex justify-end px-4">
                    <form method="GET" action="{{ route('admin.verifikasi.index') }}" class="flex items-center w-full sm:w-96">
                        <input type="text" name="search" value="{{ request('search') }}"
                            class="border border-gray-300 rounded-md px-4 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-400"
                            placeholder="Cari data kost dan kontrakan...">
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
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-900 uppercase tracking-wider">Nama Pemilik</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-900 uppercase tracking-wider">Nama Kost/Kontrakan</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-900 uppercase tracking-wider">Jenis Hunian</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-900 uppercase tracking-wider">Jumlah Kamar</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-900 uppercase tracking-wider">Status Verifikasi</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-900 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($kosts as $kost)
                            <tr>
                                <td class="px-6 py-4 text-center whitespace-nowrap">{{ $kost->user->name }}</td>
                                <td class="px-6 py-4 text-center whitespace-nowrap">{{ $kost->nama }}</td>
                                <td class="px-6 py-4 text-center whitespace-nowrap">{{ $kost->type }}</td>
                                <td class="px-6 py-4 text-center whitespace-nowrap">{{ $kost->jumlah_kamar }}</td>
                                <td class="px-6 py-4 text-center whitespace-nowrap">
                                    @if ($kost->verifikasi)
                                        @if ($kost->verifikasi->status_verifikasi === 'terverifikasi')
                                            <span class="text-blue-600">Terverifikasi</span>
                                        @elseif ($kost->verifikasi->status_verifikasi === 'ditolak')
                                            <span class="text-red-500">Ditolak</span>
                                        @else
                                            <span class="text-yellow-600">{{ ucfirst($kost->verifikasi->status_verifikasi) }}</span>
                                        @endif
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center whitespace-nowrap text-sm font-medium">
                                    <a href="{{ route('admin.verifikasi.show', $kost->id)}}" class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-full font-semibold hover:bg-green-700 transition duration-300">
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
                    e.preventDefault(); // Prevent the default form submission

                    const form = this;

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
                            form.submit(); // Submit the form if confirmed
                        }
                    });
                });
            });
        });
    </script>


</x-app-layout>