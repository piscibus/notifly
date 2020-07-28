<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Class CreateNotiflyReadNotificationTable
 */
class CreateNotiflyReadNotificationTable extends Migration
{
    /**
     * Run the migrations
     */
    public function up()
    {
        Schema::create('read_notification', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuidMorphs('owner');
            $table->string('verb');
            $table->uuidMorphs('object');
            $table->uuidMorphs('target');
            $table->unsignedInteger('trimmed_actors');
            $table->timestamps();
            $table->timestamp('seen_at')->nullable();
        });
    }

    /**
     * Rollback the migrations
     */
    public function down()
    {
        Schema::dropIfExists('read_notification');
    }
}
