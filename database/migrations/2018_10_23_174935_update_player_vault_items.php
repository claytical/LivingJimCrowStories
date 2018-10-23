<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdatePlayerVaultItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('player_vault_items', function (Blueprint $table) {
            //
            $table->dropColumn('email');
            $table->bigInteger('user_id');           

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('player_vault_items', function (Blueprint $table) {
            //
        });
    }
}
