<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        
        Schema::create('images', function (Blueprint $table) {
            $table->increments('id');
            
            $table->string('name', 500);
            
            $table->text('description');
            
            $table->text('images');
            
            $table->text('thumbnail');

            $table->integer('user_id')->unsigned()->nullable()->default(12);
            
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            
            $table->timestamps();
            
            //
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        
        Schema::dropIfExists('images');
        
    }
}
