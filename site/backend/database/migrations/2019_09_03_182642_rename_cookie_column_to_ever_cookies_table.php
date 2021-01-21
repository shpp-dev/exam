<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameCookieColumnToEverCookiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ever_cookies', function (Blueprint $table) {
            $table->renameColumn('cookie', 'token');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ever_cookies', function (Blueprint $table) {
            $table->renameColumn('token', 'cookie');
        });
    }
}
