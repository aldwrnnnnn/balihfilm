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
        Schema::create('studios', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type')->default('regular'); // regular, vip, atmos
            $table->unsignedTinyInteger('total_rows')->default(6);
            $table->unsignedTinyInteger('total_cols')->default(8);
            $table->string('row_labels')->default('A,B,C,D,E,F');
            $table->decimal('extra_fee', 10, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('studios');
    }
};
