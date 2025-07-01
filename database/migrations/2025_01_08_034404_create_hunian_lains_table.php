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
            $table->string('nama_pemilik', 50);
            $table->text('deskripsi');
            $table->string('tipe_hunian', 10);
            $table->string('harga', 15);
            $table->string('status', 10);
            $table->string('location', 20);
            $table->text('alamat');
            $table->string('telepon', 13);
            $table->string('status_verifikasi', 15);
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
