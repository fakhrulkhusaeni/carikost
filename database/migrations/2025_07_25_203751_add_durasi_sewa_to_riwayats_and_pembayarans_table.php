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
        Schema::table('pembayarans', function (Blueprint $table) {
            $table->string('durasi_sewa', 10)->nullable()->after('tanggal_booking');
        });
    
        Schema::table('riwayats', function (Blueprint $table) {
            $table->string('durasi_sewa', 10)->nullable()->after('tanggal_booking');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('riwayats', function (Blueprint $table) {
            $table->dropColumn(['durasi_sewa']);
        });

        Schema::table('pembayarans', function (Blueprint $table) {
            $table->dropColumn(['durasi_sewa']);
        });
    }
};
