<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Kelola Daftar Kost') }}
            </h2>
            <a href="{{ route('admin.kost.create') }}" class="mt-4 sm:mt-0 px-6 py-3 bg-indigo-600 text-white rounded-full font-semibold hover:bg-indigo-700 transition duration-300 text-center">
                Tambah Baru
            </a>
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
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Kost</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Jenis Kost</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah Kamar</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Harga (per-bulan)</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Status Verifikasi</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($kosts as $kost)
                            <tr>
                                <td class="px-6 py-4 text-center whitespace-nowrap">{{ $kost->nama }}</td>
                                <td class="px-6 py-4 text-center whitespace-nowrap">{{ $kost->type }}</td>
                                <td class="px-6 py-4 text-center whitespace-nowrap">{{ $kost->jumlah_kamar }}</td>
                                <td class="px-6 py-4 text-center whitespace-nowrap">Rp{{ number_format($kost->harga, 0, ',', '.') }}</td>
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
                                <td class="px-6 py-4 text-center whitespace-nowrap text-sm font-medium">
                                    <a href="{{ route('admin.kost.edit', $kost->id) }}" class="inline-flex items-center px-4 py-2 bg-yellow-600 text-white rounded-full font-semibold hover:bg-yellow-700 transition duration-300">
                                        Edit
                                    </a>
                                    <form method="POST" action="{{ route('admin.kost.destroy', $kost) }}" class="inline-block delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 text-white rounded-full font-semibold hover:bg-red-700 transition duration-300">
                                            Hapus
                                        </button>
                                    </form>
                                    <a href="{{ route('admin.kost.show', $kost->id) }}" class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-full font-semibold hover:bg-green-700 transition duration-300">
                                        Detail
                                    </a>
                                </td>

                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-gray-500">Tidak ada data kost tersedia.</td>
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