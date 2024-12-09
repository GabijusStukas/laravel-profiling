<?php

use App\Models\ProfilingQuestion;
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
        Schema::create('profiling_questions', function (Blueprint $table) {
            $table->id();
            $table->string('question');
            $table->enum('type', ProfilingQuestion::TYPES);
            $table->json('options')->nullable();
            $table->timestamps();
        });
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('profiling_questions');
    }
};
