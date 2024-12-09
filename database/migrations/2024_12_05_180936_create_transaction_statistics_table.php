<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * @return void
     */
    public function up(): void
    {
        Schema::create('transaction_statistics', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->integer('points_transactions_created')->default(0);
            $table->integer('points_transactions_claimed')->default(0);
            $table->decimal('usd_claimed', 10)->default(0);
            $table->timestamps();
        });
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction_statistics');
    }
};
