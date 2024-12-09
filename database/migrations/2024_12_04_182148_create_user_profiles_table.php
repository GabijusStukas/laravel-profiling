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
        Schema::create('user_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('profiling_question_id')->constrained()->cascadeOnDelete();
            $table->string('answer');
            $table->timestamps();
        });
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('user_profiles');
    }
};
