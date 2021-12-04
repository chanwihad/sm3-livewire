<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class role extends Model
{
    use HasFactory;

    public static function getAllRole()
    {
        return Role::orderBy('id', 'asc')->get();
    }

    public static function getRole($id)
    {
        return Role::where('id' , $id)->first();
    }
}