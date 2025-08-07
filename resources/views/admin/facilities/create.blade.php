<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Tambah Fasilitas') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden p-8 shadow-sm sm:rounded-lg">
                <form method="POST" action="{{ route('admin.facilities.store') }}">
                    @csrf

                    <div>
                        <label for="nama_fasilitas" class="block text-sm font-medium text-gray-700">Nama Fasilitas</label>
                        <input type="text" id="nama_fasilitas" name="nama_fasilitas" value="{{ old('nama_fasilitas') }}"
                               class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                        @error('nama_fasilitas')
                        <span class="text-red-600 text-sm mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="flex justify-end gap-4 mt-6">
                        <button type="submit" class="px-6 py-2 bg-indigo-600 text-white font-semibold rounded-lg shadow-sm hover:bg-indigo-700 focus:ring-2 focus:ring-indigo-500">
                            Tambah Baru
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
