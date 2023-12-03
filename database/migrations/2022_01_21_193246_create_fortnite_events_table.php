<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFortniteEventsTable extends Migration
{
    public function up(): void
    {
        Schema::create('fortnite_events', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('event_id')->index();
            $table->string('event_display_id')->index();
            $table->string('event_region');
            $table->string('event_name_1');
            $table->string('event_name_2');
            $table->string('event_poster');
            $table->longText('event_description');
            $table->string('event_schedule')->nullable();
            $table->string('event_start_time');
            $table->string('event_end_time');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fortnite_events');
    }
}
