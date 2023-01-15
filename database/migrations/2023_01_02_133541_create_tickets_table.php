<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable();
            $table->string('ticket_id')->nullable();
            $table->integer('cust_id')->nullable();
            $table->integer('category_id')->nullable();
            $table->string('subject')->nullable();
            $table->string('priority')->nullable();
            $table->string('purchasecode')->nullable();
            $table->string('purchasecodesupport')->nullable();
            $table->text('message')->nullable();
            $table->text('note')->nullable();
            $table->string('status')->nullable();
            $table->text('replystatus')->nullable();
            $table->integer('toassignuser_id')->nullable();
            $table->integer('myassignuser_id')->nullable();
            $table->string('last_reply')->nullable();
            $table->string('auto_replystatus')->nullable();
            $table->string('closing_ticket')->nullable();
            $table->string('auto_close_ticket')->nullable();
            $table->string('overduestatus')->nullable();
            $table->text('file')->nullable();
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
        Schema::dropIfExists('tickets');
    }
}
