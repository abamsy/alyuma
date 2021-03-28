<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAllocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('allocations', function (Blueprint $table) {
            $table->id();
            $table->date('allocated_at');
            $table->foreignId('product_id')->constrained()
                    ->onDelete('cascade');
            $table->unsignedSmallInteger('quantity');
            $table->foreignId('point_id')->constrained()
                    ->onDelete('cascade');
            $table->foreignId('plant_id')->constrained()
                    ->onDelete('cascade');
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
        Schema::dropIfExists('allocations');
    }
}
