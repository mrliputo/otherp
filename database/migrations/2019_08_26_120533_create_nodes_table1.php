<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNodesTable1 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('nodes', function (Blueprint $table) {
            $table->string('name');
            $table->mediumText('description');
            $table->tinyInteger('access_type');
            $table->string('url');
            $table->integer('user_id');
        });
    }

    public function down()
    {
        
    }
}
