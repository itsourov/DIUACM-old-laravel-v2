<?php

use App\Enums\EventType;
use App\Enums\ParticipationScope;
use App\Enums\Visibility;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->enum('status', Visibility::toArray())->default(Visibility::DRAFT);
            $table->dateTime('starting_at');
            $table->string('ending_at')->unique();
            $table->string('event_link')->nullable();
            $table->string('event_password')->nullable();
            $table->boolean('open_for_attendance');
            $table->enum('type', EventType::toArray())->default(EventType::CONTEST);
            $table->enum('participation_scope', ParticipationScope::toArray())->default(ParticipationScope::OPEN_FOR_ALL);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
