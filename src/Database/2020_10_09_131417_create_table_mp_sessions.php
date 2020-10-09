<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableMpSessions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!config('shopping_authenticate.is_enable_store_session')) {
            return;
        }
        Schema::connection('wgs')->create('table_mp_sessions', function (Blueprint $table) {
            $table->string('session_id');
            $table->primary(['session_id']);
            $table->string('session_key');
            $table->string('session_kaiin_id')->nullable();
            $table->json('content');
            $table->dateTime('expiry_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (!config('shopping_authenticate.is_enable_store_session')) {
            return;
        }
        Schema::connection('wgs')->dropIfExists('table_mp_sessions');
    }
}
