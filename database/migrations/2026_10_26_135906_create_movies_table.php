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
        Schema::create('movies', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('synopsis');
            $table->string('genre');
            $table->unsignedSmallInteger('duration'); // in minutes
            $table->string('rating', 10)->default('13+');
            $table->string('director')->nullable();
            $table->string('cast')->nullable();
            $table->string('poster_url');
            $table->string('backdrop_url')->nullable();
            $table->string('trailer_url')->nullable();
            $table->enum('status', ['now_playing', 'upcoming'])->default('now_playing');
            $table->date('release_date')->nullable();
            $table->decimal('base_price', 10, 2)->default(45000);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movies');
    }
};
