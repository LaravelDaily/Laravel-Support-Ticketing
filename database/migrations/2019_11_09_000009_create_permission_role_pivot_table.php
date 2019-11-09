<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePermissionRolePivotTable extends Migration
{
    public function up()
    {
        Schema::create('permission_role', function (Blueprint $table) {
            $table->unsignedInteger('role_id');

            $table->foreign('role_id', 'role_id_fk_583549')->references('id')->on('roles')->onDelete('cascade');

            $table->unsignedInteger('permission_id');

            $table->foreign('permission_id', 'permission_id_fk_583549')->references('id')->on('permissions')->onDelete('cascade');
        });
    }
}
