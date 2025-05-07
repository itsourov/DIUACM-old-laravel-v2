<?php

use App\Models\Contest;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('teams', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignIdFor(Contest::class)->constrained('contests');
            $table->integer('rank')->nullable();
            $table->integer('solveCount')->nullable();
            $table->timestamps();

            $table->unique(['name', 'contest_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('teams');
    }
};
