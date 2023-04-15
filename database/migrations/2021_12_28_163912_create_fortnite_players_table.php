<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFortnitePlayersTable extends Migration
{
    public function up(): void
    {
        Schema::create('fortnite_players', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('account_id')->index();
            $table->string('username');
            $table->unsignedBigInteger('level')->nullable();
            $table->unsignedBigInteger('progress')->nullable();
            $table->string('image')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fortnite_players');
    }
}
