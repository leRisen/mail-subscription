<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableMailSubscribers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('mail_subscribers')) {
            Schema::create('mail_subscribers', function (Blueprint $table) {
                $table->increments('id');
                $table->string('email');
                $table->string('code')->nullable();
                $table->dateTime('subscription_date');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mail_subscribers');
    }
}
