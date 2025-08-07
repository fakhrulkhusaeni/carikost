<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Daftar Fasilitas') }}
            </h2>
            <a href="{{ route('admin.facilities.create') }}" class="mt-4 sm:mt-0 px-6 py-3 bg-indigo-600 text-white rounded-full font-semibold hover:bg-indigo-700 transition duration-300 text-center">
                Tambah Fasilitas
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-lg rounded-lg overflow-hidden">

                <!-- Form Search -->
                <div class="py-4 flex justify-end px-4">
                    <form method="GET" action="{{ route('admin.facilities.index') }}" class="flex items-center w-full sm:w-96">
                        <input type="text" name="search" value="{{ request('search') }}"
                            class="border border-gray-300 rounded-md px-4 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-400"
                            placeholder="Cari fasilitas...">
                        <button type="submit"
                            class="ml-3 bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition duration-300">
                            Cari
                        </button>
                    </form>
                </div>

                <!-- Tabel Fasilitas -->
                <div class="w-full overflow-x-auto">
                    <table class="min-w-[600px] w-full divide-y divide-gray-200">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Nama Fasilitas</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($facilities as $facility)
                                <tr>
                                    <td class="px-6 py-4 text-sm text-gray-900 text-center">
                                        {{ $facility->nama_fasilitas }}
                                    </td>
                                    <td class="px-6 py-4 text-center text-sm flex justify-center gap-2 flex-wrap">
                                        <a href="{{ route('admin.facilities.edit', $facility->id) }}"
                                            class="inline-flex items-center px-4 py-2 bg-yellow-500 text-white rounded-full font-semibold hover:bg-yellow-600 transition duration-300">
                                            Edit
                                        </a>
                                        <form action="{{ route('admin.facilities.destroy', $facility->id) }}" method="POST" class="delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="inline-flex items-center px-4 py-2 bg-red-600 text-white rounded-full font-semibold hover:bg-red-700 transition duration-300">
                                                Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="px-6 py-4 text-sm text-gray-500 text-center">
                                        Belum ada fasilitas yang ditambahkan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="mt-4 px-4">
                        {{ $facilities->links() }}
                    </div>
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
