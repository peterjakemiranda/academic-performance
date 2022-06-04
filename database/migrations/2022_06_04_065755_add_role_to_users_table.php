<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class AddRoleToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('student')->after('email');
        });
        DB::update("UPDATE users set role = 'admin' where admin = 1");

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('admin');
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
            $table->integer('admin')->default(0)->after('email');
        });
        DB::update("UPDATE users set admin = ` where role = 'admin'");

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role');
        });
    }
}
