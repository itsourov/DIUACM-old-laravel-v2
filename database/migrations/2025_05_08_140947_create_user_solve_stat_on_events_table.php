<?php

use App\Models\Event;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('user_solve_stat_on_events', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->constrained('users')->cascadeOnDelete();
            $table->foreignIdFor(Event::class)->constrained('events')->cascadeOnDelete();
            $table->unsignedInteger('solve_count');
            $table->unsignedInteger('upsolve_count');
            $table->boolean('participation');
            $table->timestamps();

            $table->unique(['user_id', 'event_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_solve_stat_on_events');
    }
};
