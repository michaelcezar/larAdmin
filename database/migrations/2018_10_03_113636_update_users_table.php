<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->datetime('deleted_at')->nullable();
            $table->unsignedInteger('user_status')->nullable();
            $table->unsignedInteger('user_type')->nullable();
            $table->foreign('user_status')->nullable()->references('id')->on('user_client_status')->onDelete('set null');
            $table->foreign('user_type')->nullable()->references('id')->on('user_type')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['user_status']);
            $table->dropForeign(['user_type']);
            $table->dropColumn('deleted_at');
            $table->dropColumn('user_status');
            $table->dropColumn('user_type');
        });
    }
}
