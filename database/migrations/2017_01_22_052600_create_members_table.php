<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->integer('key');
            $table->text('hash');
            $table->text('ircName');
            $table->text('spokenName');
            $table->integer('addedBy');
            $table->integer('dateCreated');
            $table->integer('isAdmin');
            $table->integer('lastLogin');
            $table->integer('isActive');

            $table->primary('key');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
