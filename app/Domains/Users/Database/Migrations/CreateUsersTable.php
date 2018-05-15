<?php

namespace Emtudo\Domains\Users\Database\Migrations;

use Emtudo\Domains\Users\Database\Seeders\UserSeeder;
use Emtudo\Support\Domain\Database\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        $this->schema->create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 50)->index();
            $table->string('email')->unique()->nullable();
            $table->boolean('email_confirmed')->default(false);
            $table->string('password')->nullable();
            $table->boolean('two_factor')->default(false);
            $table->string('two_factor_code', 6)->nullable();

            $table->boolean('is_admin')->default(false);

            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });

        UserSeeder::start();
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        $this->schema->drop('users');
    }
}
