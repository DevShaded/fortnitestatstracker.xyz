<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCreativeIslandsTable extends Migration
{
    public function up(): void
    {
        Schema::create('creative_islands', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('island_code')->index();
            $table->string('island_name');
            $table->string('island_description');
            $table->string('island_image');
            $table->string('island_creator');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('creative_islands');
    }
}
