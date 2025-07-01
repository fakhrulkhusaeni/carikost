<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('kosts', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 25); // Nama Kost/Kontrakan
            $table->text('deskripsi'); // Deskripsi
            $table->enum('type', ['putra', 'putri', 'campur', 'kontrakan']); // Jenis Kost
            $table->integer('jumlah_kamar'); // Jumlah Kamar
            $table->string('location', 20); // Lokasi Kecamatan
            $table->text('alamat'); // Alamat
            $table->string('harga', 15); // Harga (per bulan)
            $table->json('facilities'); // Fasilitas
            $table->json('rules'); // Peraturan Kost/Kontrakan
            $table->json('foto'); // Foto Hunian
            $table->timestamps(); // Created at & Updated at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kosts');
    }
};
