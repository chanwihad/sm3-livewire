<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPegawai extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        \Spatie\Permission\Models\Role::create(['name' => 'pegawai']);
        $permissionByRole = [
          'pegawai' => ['manage meeting']
        ];
        $pegawai = \Spatie\Permission\Models\Role::findByName('pegawai');
        $pegawai->givePermissionTo($permissionByRole['pegawai']);
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
