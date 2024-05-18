<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFortniteEventPlatformsTable extends Migration
{
    public function up(): void
    {
        Schema::create('fortnite_event_platforms', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('event_id')->index();
            $table->string('event_platform');
            $table->timestamps();

            $table->foreign('event_id')->references('event_id')->on('fortnite_events')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fortnite_event_platforms');
    }
}
