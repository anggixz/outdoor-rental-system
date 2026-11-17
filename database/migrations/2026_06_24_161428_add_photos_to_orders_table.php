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
        Schema::table('orders', function (Blueprint $table) {

            // Foto saat alat diserahkan ke penyewa
            $table->string('pickup_photo')
                ->nullable()
                ->after('rental_status');

            // Foto saat alat dikembalikan oleh penyewa
            $table->string('return_photo')
                ->nullable()
                ->after('pickup_photo');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {

            $table->dropColumn([
                'pickup_photo',
                'return_photo'
            ]);

        });
    }
};