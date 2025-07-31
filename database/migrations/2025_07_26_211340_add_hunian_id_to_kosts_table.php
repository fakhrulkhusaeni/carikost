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
        Schema::table('kosts', function (Blueprint $table) {
            $table->unsignedBigInteger('hunian_id')->nullable()->after('id');
            $table->foreign('hunian_id')->references('id')->on('hunians')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kosts', function (Blueprint $table) {
            $table->dropForeign(['hunian_id']);
            $table->dropColumn('hunian_id');
        });
    }
};
