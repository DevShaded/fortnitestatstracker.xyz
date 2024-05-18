<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFortniteShopSpecialDailyItemsTable extends Migration
{
    public function up(): void
    {
        Schema::create('fortnite_shop_special_daily_items', function (Blueprint $table) {
            $table->id();
            $table->string('item_id')->nullable();
            $table->string('item_name');
            $table->unsignedBigInteger('item_price');
            $table->string('item_background')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('special_daily_items');
    }
}
