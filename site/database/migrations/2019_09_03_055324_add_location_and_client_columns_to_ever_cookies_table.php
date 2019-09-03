<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLocationAndClientColumnsToEverCookiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ever_cookies', function (Blueprint $table) {
            $table->string('location')->after('id');
            $table->string('client')->after('location');
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
            $table->dropColumn('location');
            $table->dropColumn('client');
        });
    }
}
