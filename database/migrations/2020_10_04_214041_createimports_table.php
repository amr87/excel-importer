<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateimportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('imports', function (Blueprint $table) {
            $table->increments('id')->comment('File ID');
            $table->string('title')->comment('File Title');
            $table->integer('rows')->comment('Total Number of File Rows');
            $table->integer('inserted')->nullable()->default(0)->comment('Successfully Inserted Rows Count');
            $table->integer('failed')->nullable()->default(0)->comment('Failed Insertion Rows Count');
            
            $table->dateTime('startedAt')->comment('Import Process Start Time');
            $table->dateTime('endedAt')->nullable()->comment('Import Process End Time');
            $table->integer('duration')->nullable()->comment('Import Process Total Duration in Seconds');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('imports');
    }
}
