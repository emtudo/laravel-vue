<?php

namespace Emtudo\Domains\Users\Database\Migrations;

use Emtudo\Support\Domain\Database\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePasswordResetsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        $this->schema->create('password_resets', function (Blueprint $table) {
            $table->string('email')->index();
            $table->string('token')->index();

            $table->timestamp('created_at');

            $table->index(['token', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        $this->schema->drop('password_resets');
    }
}
