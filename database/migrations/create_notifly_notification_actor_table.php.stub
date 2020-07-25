<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Class CreateNotiflyNotificationActorTable
 */
class CreateNotiflyNotificationActorTable extends Migration
{
    /**
     * Run the migrations
     */
    public function up()
    {
        Schema::create('notification_actor', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('notification_id');
            $table->uuidMorphs('actor');
            $table->timestamps();
        });
    }

    /**
     * Rollback the migrations
     */
    public function down()
    {
        Schema::dropIfExists('notification_actor');
    }
}
