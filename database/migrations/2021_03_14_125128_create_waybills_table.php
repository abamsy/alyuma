<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWaybillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('waybills', function (Blueprint $table) {
            $table->id();
            $table->foreignId('allocation_id')->constrained()
                    ->onDelete('cascade');
            $table->date('dispatched_at');
            $table->unsignedTinyInteger('dquantity');
            $table->unsignedSmallInteger('dbags');
            $table->date('received_at')->nullable();
            $table->unsignedTinyInteger('rquantity')->nullable();
            $table->unsignedSmallInteger('rbags')->nullable();
            $table->string('driver');
            $table->string('dphone');
            $table->string('truck');
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
        Schema::dropIfExists('waybills');
    }
}
