<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class model_has_role extends Model
{
    use HasFactory;

    public static function getRoleUser($id)
    {
        return Model_has_role::where('model_id', $id)->first();
    }
}