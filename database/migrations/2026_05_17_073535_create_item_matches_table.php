<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('item_matches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lost_item_id')->constrained('items')->onDelete('cascade');
            $table->foreignId('found_item_id')->constrained('items')->onDelete('cascade');
            $table->decimal('location_score', 5, 2)->default(0);
            $table->decimal('date_time_score', 5, 2)->default(0);
            $table->decimal('category_score', 5, 2)->default(0);
            $table->decimal('total_score', 5, 2)->default(0);
            $table->enum('match_level', ['high', 'possible', 'low']);
            $table->enum('status', ['pending', 'accepted', 'rejected'])->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('item_matches');
    }
};