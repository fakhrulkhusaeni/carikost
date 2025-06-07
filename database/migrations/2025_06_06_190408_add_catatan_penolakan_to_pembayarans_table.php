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
            $table->text('catatan_penolakan')->nullable()->after('status_konfirmasi');
        });

        Schema::table('riwayats', function (Blueprint $table) {
            $table->text('catatan_penolakan')->nullable()->after('status_konfirmasi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pembayarans', function (Blueprint $table) {
            $table->dropColumn('catatan_penolakan');
        });

        Schema::table('riwayats', function (Blueprint $table) {
            $table->dropColumn('catatan_penolakan');
        });
    }
};
