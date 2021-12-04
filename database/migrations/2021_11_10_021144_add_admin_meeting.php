<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAdminMeeting extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        \Spatie\Permission\Models\Role::create(['name' => 'admin']);
        $permissionByRole = [
          'admin' => ['manage meeting']
        ];
        $permissions = [
            'manage meeting'
        ];

        foreach ($permissions as $permission) {
            \Spatie\Permission\Models\Permission::create(['name' => $permission]);
        }

        $admin = \Spatie\Permission\Models\Role::findByName('admin');
        $admin->givePermissionTo($permissionByRole['admin']);
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
