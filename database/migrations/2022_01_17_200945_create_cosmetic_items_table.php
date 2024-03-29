<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCosmeticItemsTable extends Migration
{
    public function up(): void
    {
        Schema::create('cosmetic_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('cosmetic_id')->index();
            $table->string('name');
            $table->string('description');
            $table->string('cosmetic_type');
            $table->string('rarity');
            $table->string('price');
            $table->string('image');
            $table->string('release_date');
            $table->double('interest');
            $table->string('set')->nullable();
            $table->string('intro_chapter');
            $table->string('intro_season');
            $table->string('intro_text');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cosmetic_items');
    }
}
