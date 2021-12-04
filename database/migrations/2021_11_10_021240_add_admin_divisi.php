<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAdminDivisi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        \Spatie\Permission\Models\Role::create(['name' => 'admin divisi']);
        $permissionByRole = [
          'admin divisi' => ['manage meeting']
        ];
        $admin_satker = \Spatie\Permission\Models\Role::findByName('admin divisi');
        $admin_satker->givePermissionTo($permissionByRole['admin divisi']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
