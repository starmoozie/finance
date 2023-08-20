<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterUsersAddJsonRelation extends Migration
{

    const TABLE  = 'users';
    const COLUMN = 'group_ids';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(Self::TABLE, function (Blueprint $table) {
            $table->json(Self::COLUMN)->nullable()->after('remember_token');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(Self::TABLE, function (Blueprint $table) {
            $table->dropColumn(Self::COLUMN);
        });
    }
}
