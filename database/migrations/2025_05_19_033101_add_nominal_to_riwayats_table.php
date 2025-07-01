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
        Schema::table('riwayats', function (Blueprint $table) {
            $table->string('nominal', 15)->nullable()->after('status_pembayaran');

        });

        Schema::table('pembayarans', function (Blueprint $table) {
            $table->string('nominal', 15)->nullable()->after('status_pembayaran');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('riwayats', function (Blueprint $table) {
            $table->dropColumn('status_pembayaran');
        });

        Schema::table('pembayarans', function (Blueprint $table) {
            $table->dropColumn('status_pembayaran');
        });
    }
};
