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
        Schema::table('order_items', function (Blueprint $table) {

            /*
            |--------------------------------------------------------------------------
            | Harga beli saat transaksi
            |--------------------------------------------------------------------------
            */

            $table->unsignedBigInteger('purchase_price')
                ->default(0);

            /*
            |--------------------------------------------------------------------------
            | Status kerusakan
            |--------------------------------------------------------------------------
            */

            $table->string('damage_status')
                ->default('good');

            /*
            |--------------------------------------------------------------------------
            | Nominal denda kerusakan
            |--------------------------------------------------------------------------
            */

            $table->unsignedBigInteger('damage_penalty')
                ->default(0);

            /*
            |--------------------------------------------------------------------------
            | Perlu servis
            |--------------------------------------------------------------------------
            */

            $table->boolean('needs_service')
                ->default(false);

            /*
            |--------------------------------------------------------------------------
            | Catatan kerusakan
            |--------------------------------------------------------------------------
            */

            $table->text('damage_note')
                ->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_items', function (Blueprint $table) {

            $table->dropColumn([
                'purchase_price',
                'damage_status',
                'damage_penalty',
                'needs_service',
                'damage_note',
            ]);

        });
    }
};