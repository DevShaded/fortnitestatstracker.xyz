<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeaturedItemsTable extends Migration
{
    public function up()
    {
        Schema::create('featured_items', function (Blueprint $table) {
            $table->id();
            $table->string('item_id')->nullable();
            $table->string('item_name');
            $table->unsignedBigInteger('item_price');
            $table->string('item_background')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
        });
    }

    public function down()
    {
        Schema::dropIfExists('featured_items');
    }
}
