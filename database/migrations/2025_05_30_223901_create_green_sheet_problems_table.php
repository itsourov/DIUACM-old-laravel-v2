<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('green_sheet_problems', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->integer('order');
            $table->string('oj')->nullable();
            $table->string('oj_id')->nullable();
            $table->string('oj_link');
            $table->text('editorial')->nullable();
            $table->text('hint')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('green_sheet_problems');
    }
};
