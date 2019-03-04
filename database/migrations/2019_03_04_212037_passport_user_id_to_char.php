<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PassportUserIdToChar extends Migration
{
    private $tables = ['oauth_auth_codes', 'oauth_access_tokens', 'oauth_clients'];

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        foreach ($this->tables as $table) {
            Schema::table($table, function (Blueprint $table) {
                $table->dropColumn('user_id');
            });
            Schema::table($table, function (Blueprint $table) {
                $table->char('user_id', 26)->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        foreach ($this->tables as $table) {
            Schema::table($table, function (Blueprint $table) {
                $table->dropColumn('user_id');
            });
            Schema::table($table, function (Blueprint $table) {
                $table->integer('user_id')->nullable();
            });
        }
    }
}
