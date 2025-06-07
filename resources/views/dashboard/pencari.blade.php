<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Pencari Kost dan Kontrakan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Statistik Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="card bg-green-500 text-white p-6 rounded-lg shadow-md">
                    <h3 class="text-lg font-semibold">Total Riwayat Pesanan</h3>
                    <p class="text-3xl font-bold mt-2">{{ $totalRiwayatPesanan }}</p>
                </div>
            </div>
        </div>
    </div>

    <style>
        .card {
            transition: transform 0.2s;
        }

        .card:hover {
            transform: translateY(-5px);
        }
    </style>
</x-app-layout>