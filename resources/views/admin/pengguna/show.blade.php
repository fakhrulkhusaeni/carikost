<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detail User') }}
            </h2>
        </div>
    </x-slot>

        <div class="py-12 px-4 sm:px-6 lg:px-8">
            <div class="max-w-7xl mx-auto">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 sm:p-8 max-w-2xl mx-auto grid grid-cols-1 gap-6">
                
                <!-- Owner Details -->
                <div class="flex flex-col sm:flex-row items-center gap-4">
                    <img class="border rounded-full w-20 h-20 object-cover" src="{{ asset('storage/' . $user->avatar) }}" alt="Foto Pemilik Kost">
                    <div class="text-center sm:text-start">
                        <h5 class="mb-1 font-medium text-sm sm:text-base"><span class="font-semibold">{{ $user->name }}</span></h5>
                        <span class="text-gray-500 text-sm"> @foreach ($user->roles as $role)
                            {{ $role->name }}@if (!$loop->last), @endif
                            @endforeach</span>
                    </div>
                </div>

                <!-- User Details -->
                <div class="col-span-1 md:col-span-2">

                    <!-- Email -->
                    <div class="mb-4">
                        <span class="font-semibold text-gray-700">Email: </span>
                        <span class="text-gray-600">{{ $user->email }}</span>
                    </div>

                    <!-- Phone -->
                    <div class="mb-4">
                        <span class="font-semibold text-gray-700">Nomor Telepon: </span>
                        <span class="text-gray-600">{{ $user->phone }}</span>
                    </div>

                    <!-- Gender -->
                    <div class="mb-4">
                        <span class="font-semibold text-gray-700">Jenis Kelamin: </span>
                        <span class="text-gray-600">{{ ucfirst($user->gender) }}</span>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>