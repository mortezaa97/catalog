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
        Schema::create('model_has_catalogs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('catalog_id')->constrained('catalogs');
            $table->morphs('model');
            $table->unique(['catalog_id', 'model_id', 'model_type']);
            $table->smallInteger('sort')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('model_has_catalogs');
    }
};
