<?php

use App\Models\Event;
use App\Models\RankList;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('event_rank_list', function (Blueprint $table) {
            $table->foreignIdFor(Event::class)->constrained('events')->cascadeOnDelete();
            $table->foreignIdFor(RankList::class)->constrained('rank_lists')->cascadeOnDelete();
            $table->float('weight')->default(1);

            $table->unique(['event_id', 'rank_list_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('event_rank_list');
    }
};
