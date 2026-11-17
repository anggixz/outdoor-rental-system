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

            $table->integer('late_days')
                ->default(0);

            $table->bigInteger('late_fee')
                ->default(0);

            $table->integer('missing_items')
                ->default(0);

            $table->bigInteger('missing_fee')
                ->default(0);

            $table->bigInteger('total_penalty')
                ->default(0);

            $table->bigInteger('deposit_return')
                ->default(0);

            $table->text('admin_note')
                ->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            //
        });
    }
};
