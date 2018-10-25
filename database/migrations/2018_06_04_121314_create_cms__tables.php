<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCmsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loginlogs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->nullableTimestamps();

            $table->foreign('user_id')->references('id')->on('users');
        });

        Schema::create('user_settings', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->boolean('isLocked')->default(false);
            $table->boolean('isSidebarClosed')->default(false);
            $table->boolean('showNotifications')->default(true);
            $table->string('language')->default('tr');
            $table->string('profile_photo')->nullable();
            $table->integer('created_by')->unsigned();
            $table->integer('updated_by')->unsigned()->nullable();
            $table->nullableTimestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('updated_by')->references('id')->on('users');
        });

        Schema::create('roles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('created_by')->unsigned();
            $table->integer('updated_by')->unsigned()->nullable();
            $table->nullableTimestamps();

            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('updated_by')->references('id')->on('users');
        });

        Schema::create('permissions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('created_by')->unsigned();
            $table->integer('updated_by')->unsigned()->nullable();
            $table->nullableTimestamps();

            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('updated_by')->references('id')->on('users');
        });

        Schema::create('permission_role', function (Blueprint $table) {
            $table->integer('permission_id')->unsigned();
            $table->integer('role_id')->unsigned();
            $table->nullableTimestamps();

            $table->foreign('permission_id')->references('id')->on('permissions')->onDelete('cascade');
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');

            $table->primary(['permission_id', 'role_id']);
        });

        Schema::create('role_user', function (Blueprint $table) {
            $table->integer('role_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->nullableTimestamps();

            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->primary(['role_id', 'user_id']);
        });

        Schema::create('invitees', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email');
            $table->string('token');
            $table->boolean('isRegistered')->default(false);
            $table->integer('role_id')->unsigned()->nullable();;
            $table->integer('user_id')->unsigned()->nullable();;
            $table->integer('created_by')->unsigned();
            $table->integer('updated_by')->unsigned()->nullable();
            $table->nullableTimestamps();

            $table->foreign('role_id')->references('id')->on('roles');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('updated_by')->references('id')->on('users');
        });

        Schema::create('tasks', function (Blueprint $table) {
            $table->increments('id');
            $table->text('description');
            $table->boolean('isDone')->default(false);
            $table->integer('position')->default(1);
            $table->integer('created_by')->unsigned();
            $table->integer('updated_by')->unsigned()->nullable();
            $table->nullableTimestamps();

            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('updated_by')->references('id')->on('users');
        });

        Schema::create('contact_forms', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('to');
            $table->string('cc')->nullable();
            $table->integer('created_by')->unsigned();
            $table->integer('updated_by')->unsigned()->nullable();
            $table->nullableTimestamps();

            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('updated_by')->references('id')->on('users');
        });


        // Can Be Multilingual
        Schema::create('form_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title_tr');
            $table->string('title_en');
            $table->string('to');
            $table->string('cc')->nullable();
            $table->integer('contact_form_id')->unsigned();
            $table->boolean('publish')->default(true);
            $table->integer('created_by')->unsigned();
            $table->integer('updated_by')->unsigned()->nullable();
            $table->nullableTimestamps();

            $table->foreign('contact_form_id')->references('id')->on('contact_forms');
            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('updated_by')->references('id')->on('users');
        });


        Schema::create('inbox_mails', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('contact_form_id')->unsigned()->nullable();
            $table->integer('form_category_id')->unsigned()->nullable();
            $table->string('from')->nullable();
            $table->string('to')->nullable();
            $table->string('subject')->nullable();
            $table->text('body');
            $table->boolean('isRead')->default(false);
            $table->boolean('isSent')->default(false);
            $table->boolean('isDraft')->default(false);
            $table->boolean('isTrash')->default(false);
            $table->boolean('isImportant')->default(false);
            $table->integer('created_by')->unsigned()->nullable();
            $table->integer('updated_by')->unsigned()->nullable();
            $table->nullableTimestamps();

            $table->foreign('contact_form_id')->references('id')->on('contact_forms');
            $table->foreign('form_category_id')->references('id')->on('form_categories');
            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('updated_by')->references('id')->on('users');
        });

        Schema::create('inbox_attachments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('inbox_mail_id')->unsigned();
            $table->string('path');
            $table->integer('created_by')->unsigned()->nullable();
            $table->integer('updated_by')->unsigned()->nullable();
            $table->nullableTimestamps();

            $table->foreign('inbox_mail_id')->references('id')->on('inbox_mails');
            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('updated_by')->references('id')->on('users');
        });

        Schema::create('search_index', function (Blueprint $table) {
            $table->increments('id');
            $table->string('keyword');
            $table->string('folder');
            $table->integer('key');
            $table->nullableTimestamps();
        });

        Schema::create('file_manager_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->integer('created_by')->unsigned();
            $table->integer('updated_by')->unsigned()->nullable();
            $table->nullableTimestamps();

            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('updated_by')->references('id')->on('users');
        });


        Schema::create('file_manager_files', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('file_manager_category_id')->unsigned();
            $table->string('title');
            $table->string('file_path');
            $table->integer('created_by')->unsigned();
            $table->integer('updated_by')->unsigned()->nullable();
            $table->nullableTimestamps();

            $table->foreign('file_manager_category_id')->references('id')->on('file_manager_categories');
            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('updated_by')->references('id')->on('users');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('file_manager_files');
        Schema::drop('file_manager_categories');
        Schema::drop('search_index');
        Schema::drop('inbox_attachments');
        Schema::drop('inbox_mails');
        Schema::drop('form_categories');
        Schema::drop('contact_forms');
        Schema::drop('tasks');
        Schema::drop('invitees');
        Schema::drop('role_user');
        Schema::drop('permission_role');
        Schema::drop('roles');
        Schema::drop('permissions');
        Schema::drop('user_settings');
        Schema::drop('loginlogs');
    }
}
