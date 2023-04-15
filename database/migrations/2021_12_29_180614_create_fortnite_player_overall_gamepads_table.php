<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFortnitePlayerOverallGamepadsTable extends Migration
{
    public function up(): void
    {
        Schema::create('fortnite_player_overall_gamepads', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('account_id')->index();
            $table->unsignedBigInteger('score');
            $table->unsignedDouble('scorePerMin');
            $table->unsignedDouble('scorePerMatch');
            $table->unsignedBigInteger('wins');
            $table->unsignedBigInteger('top3');
            $table->unsignedBigInteger('top5');
            $table->unsignedBigInteger('top6');
            $table->unsignedBigInteger('top10');
            $table->unsignedBigInteger('top12');
            $table->unsignedBigInteger('top25');
            $table->unsignedBigInteger('kills');
            $table->unsignedDouble('killsPerMin');
            $table->unsignedDouble('killsPerMatch');
            $table->unsignedBigInteger('deaths');
            $table->float('kd', 22,2);
            $table->unsignedBigInteger('matches');
            $table->float('winRate', 22,2);
            $table->unsignedBigInteger('minutesPlayed');
            $table->unsignedBigInteger('playersOutLived');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));

            $table->foreign('account_id')->references('account_id')->on('fortnite_players')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fortnite_player_overall_gamepads');
    }
}
