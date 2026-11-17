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

            $table->boolean('deposit_returned')
                ->default(false)
                ->after('deposit_return');

            $table->timestamp('deposit_returned_at')
                ->nullable()
                ->after('deposit_returned');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {

            $table->dropColumn([
                'deposit_returned',
                'deposit_returned_at'
            ]);

        });
    }
};