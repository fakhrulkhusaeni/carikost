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
        Schema::create('hunian_lains', function (Blueprint $table) {
            $table->id();
            $table->string('nama_pemilik');
            $table->text('deskripsi');
            $table->string('tipe_hunian');
            $table->string('harga');
            $table->string('status');
            $table->string('location');
            $table->string('alamat');
            $table->string('telepon');
            $table->string('status_verifikasi');
            $table->json('detail_hunian');
            $table->json('fasilitas');
            $table->json('foto');
            $table->json('bukti_kepemilikan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hunian_lains');
    }
};
