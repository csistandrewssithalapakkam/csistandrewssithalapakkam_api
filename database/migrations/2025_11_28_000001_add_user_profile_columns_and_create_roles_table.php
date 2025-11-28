<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserProfileColumnsAndCreateRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Create tbl_roles table
        Schema::create('tbl_roles', function (Blueprint $table) {
            $table->id('role_id');
            $table->string('role_name', 50)->unique();
            $table->timestamp('created_date')->useCurrent();
            $table->integer('created_by')->nullable();
            $table->timestamp('updated_date')->useCurrent()->useCurrentOnUpdate();
            $table->integer('updated_by')->nullable();
        });

        // Add columns to tbl_user
        Schema::table('tbl_user', function (Blueprint $table) {
            if (!Schema::hasColumn('tbl_user', 'first_name')) {
                $table->string('first_name', 50)->nullable()->after('user_name');
            }
            if (!Schema::hasColumn('tbl_user', 'last_name')) {
                $table->string('last_name', 50)->nullable()->after('first_name');
            }
            if (!Schema::hasColumn('tbl_user', 'mobile_number')) {
                $table->string('mobile_number', 20)->nullable()->after('user_email');
            }
            if (!Schema::hasColumn('tbl_user', 'role_id')) {
                $table->unsignedBigInteger('role_id')->nullable()->after('mobile_number');
                $table->foreign('role_id')
                    ->references('role_id')
                    ->on('tbl_roles')
                    ->onDelete('set null');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tbl_user', function (Blueprint $table) {
            if (Schema::hasColumn('tbl_user', 'role_id')) {
                $table->dropForeign(['role_id']);
                $table->dropColumn('role_id');
            }
            if (Schema::hasColumn('tbl_user', 'mobile_number')) {
                $table->dropColumn('mobile_number');
            }
            if (Schema::hasColumn('tbl_user', 'last_name')) {
                $table->dropColumn('last_name');
            }
            if (Schema::hasColumn('tbl_user', 'first_name')) {
                $table->dropColumn('first_name');
            }
        });

        Schema::dropIfExists('tbl_roles');
    }
}
