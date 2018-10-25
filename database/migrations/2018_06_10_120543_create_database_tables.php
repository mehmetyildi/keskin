<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDatabaseTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       

        /* Article.php */
        Schema::create('articles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title_tr')->nullable();
            $table->string('title_en')->nullable();
            $table->text('caption_tr')->nullable();
            $table->text('caption_en')->nullable();
            $table->text('description_tr')->nullable();
            $table->text('description_en')->nullable();
            $table->string('url_tr');
            $table->string('url_en');
            $table->string('video_path')->nullable();
            $table->string('main_image')->nullable();
            $table->boolean('promote')->default(false);
            $table->boolean('publish')->default(false);
            $table->integer('position')->default(1);
            $table->date('actual_date')->nullable();
            $table->date('publish_at')->nullable();
            $table->date('publish_until')->nullable();
            $table->integer('created_by')->unsigned();
            $table->integer('updated_by')->unsigned()->nullable();
            $table->nullableTimestamps();

            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('updated_by')->references('id')->on('users');
        });

        /* ArticleImage.php */
        Schema::create('article_images', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('article_id')->unsigned();
            $table->string('title_tr')->nullable();
            $table->string('title_en')->nullable();
            $table->string('main_image')->nullable();
            $table->boolean('publish')->default(false);
            $table->integer('position')->default(1);
            $table->integer('created_by')->unsigned();
            $table->integer('updated_by')->unsigned()->nullable();
            $table->nullableTimestamps();

            $table->foreign('article_id')->references('id')->on('articles');
            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('updated_by')->references('id')->on('users');
        });

        Schema::create('popups', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title_tr')->nullable();
            $table->string('title_en')->nullable();
            $table->string('image_path_tr')->nullable();
            $table->string('image_path_en')->nullable();
            $table->string('video_path')->nullable();
            $table->string('link')->nullable();
            $table->integer('duration')->nullable();
            $table->boolean('publish')->default(false);
            $table->integer('position')->default(1);
            $table->date('publish_at')->nullable();
            $table->date('publish_until')->nullable();
            $table->integer('created_by')->unsigned();
            $table->integer('updated_by')->unsigned()->nullable();
            $table->nullableTimestamps();

            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('updated_by')->references('id')->on('users');
        });

        Schema::create('video', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title_tr')->nullable();
            $table->string('title_en')->nullable();
            $table->string('main_video_path')->nullable();
            $table->string('mobile_video_path')->nullable();
            $table->boolean('publish')->default(false);
            $table->integer('position')->default(1);
            $table->integer('created_by')->unsigned();
            $table->integer('updated_by')->unsigned()->nullable();
            $table->nullableTimestamps();

            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('updated_by')->references('id')->on('users');
        });

        Schema::create('tests', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title_tr')->nullable();
            $table->string('title_en')->nullable();
            $table->string('description_tr')->nullable();
            $table->string('description_en')->nullable();
            $table->string('main_image')->nullable();
            $table->string('video_path')->nullable();
            $table->boolean('publish')->default(false);
            $table->integer('position')->default(1);
            $table->integer('created_by')->unsigned();
            $table->integer('updated_by')->unsigned()->nullable();
            $table->nullableTimestamps();

            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('updated_by')->references('id')->on('users');
        });

        Schema::create('fields', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title_tr')->nullable();
            $table->string('title_en')->nullable();
            $table->string('description_tr')->nullable();
            $table->string('description_en')->nullable();
            $table->string('main_image')->nullable();
            $table->boolean('publish')->default(false);
            $table->integer('position')->default(1);
            $table->integer('created_by')->unsigned();
            $table->integer('updated_by')->unsigned()->nullable();
            $table->nullableTimestamps();

            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('updated_by')->references('id')->on('users');
        });

        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title_tr')->nullable();
            $table->string('title_en')->nullable();
            $table->string('description_tr')->nullable();
            $table->string('description_en')->nullable();
            $table->string('main_image')->nullable();
            $table->boolean('publish')->default(false);
            $table->integer('position')->default(1);
            $table->integer('created_by')->unsigned();
            $table->integer('updated_by')->unsigned()->nullable();
            $table->nullableTimestamps();

            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('updated_by')->references('id')->on('users');
        });

        

        Schema::create('product_test', function (Blueprint $table) {
        
            $table->integer('product_id')->unsigned();
            $table->integer('test_id')->unsigned();
            
            $table->nullableTimestamps();
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('test_id')->references('id')->on('tests')->onDelete('cascade');
            
            $table->primary(['product_id','test_id']);
        });

        Schema::create('field_product', function (Blueprint $table) {
        
            $table->integer('product_id')->unsigned();
            $table->integer('field_id')->unsigned();
            
            $table->nullableTimestamps();
            $table->foreign('field_id')->references('id')->on('fields')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade'); 
            $table->primary(['field_id','product_id']);   
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('article_images');
        Schema::dropIfExists('articles');
        Schema::dropIfExists('popups');
        Schema::dropIfExists('tests');
        Schema::dropIfExists('fields');
        Schema::dropIfExists('products');
        Schema::dropIfExists('video');
        Schema::dropIfExists('product_test');
        Schema::dropIfExists('field_product');
       
    }
}
