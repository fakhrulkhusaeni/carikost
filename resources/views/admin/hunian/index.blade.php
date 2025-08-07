<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Kelola Hunian') }}
            </h2>
            <a href="{{ route('admin.hunian.create') }}" class="mt-4 sm:mt-0 px-6 py-3 bg-indigo-600 text-white rounded-full font-semibold hover:bg-indigo-700 transition duration-300 text-center">
                Tambah Hunian
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-lg rounded-lg overflow-hidden">

                <!-- Navbar Mini -->
                <nav class="bg-white border-b border-gray-200 mb-4 px-4 py-2 flex justify-between items-center">
                    <div class="flex space-x-4">
                        <a href="{{ route('admin.kost.index') }}"
                            class="font-semibold transition {{ request()->routeIs('admin.kost.index') ? 'text-blue-600' : 'text-gray-700 hover:text-blue-600' }}">
                                Lihat Kamar
                        </a>
                        <a href="{{ route('admin.hunian.index') }}"
                            class="font-semibold transition {{ request()->routeIs('admin.hunian.index') ? 'text-blue-600' : 'text-gray-700 hover:text-blue-600' }}">
                                Lihat Hunian
                        </a>
                    </div>
                </nav>

                <!-- Tabel -->
                <div class="w-full overflow-x-auto">
                    <table class="min-w-[800px] w-full divide-y divide-gray-200">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-900 uppercase tracking-wider">Nama Hunian</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-900 uppercase tracking-wider">Lokasi</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-900 uppercase tracking-wider">Status Verifikasi</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-900 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($hunians as $hunian)
                                <tr>
                                    <td class="px-6 py-4 text-center">{{ $hunian->nama }}</td>
                                    <td class="px-6 py-4 text-center">{{ $hunian->location }}</td>
                                    <td class="px-6 py-4 text-center whitespace-nowrap">
                                        @php
                                            $kost = $hunian->kosts->first();
                                        @endphp

                                        @if ($kost && $kost->verifikasi)
                                            @if ($kost->verifikasi->status_verifikasi === 'terverifikasi')
                                                <span class="text-blue-600 font-semibold">Terverifikasi</span>
                                            @elseif ($kost->verifikasi->status_verifikasi === 'ditolak')
                                                <span class="text-red-500 font-semibold">Ditolak</span>
                                            @else
                                                <span class="text-yellow-600 font-semibold">{{ ucfirst($kost->verifikasi->status_verifikasi) }}</span>
                                            @endif
                                        @else
                                            <span class="text-gray-500 italic">Belum diverifikasi</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-center space-x-1">
                                        <a href="{{ route('admin.hunian.edit', $hunian->id) }}" class="inline-block px-4 py-2 bg-yellow-500 text-white rounded-full hover:bg-yellow-600 transition">Edit</a>

                                        <form action="{{ route('admin.hunian.destroy', $hunian->id) }}" method="POST" class="inline-block delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 text-white rounded-full font-semibold hover:bg-red-700 transition duration-300">
                                                Hapus
                                            </button>
                                        </form>

                                        @if ($kost)
                                            <a href="{{ route('admin.kost.show', $kost->id) }}" class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-full font-semibold hover:bg-green-700 transition duration-300">
                                                Detail
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">Tidak ada data hunian.</td>
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
