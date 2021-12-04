<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class note extends Model
{
    use HasFactory;

    public static function getNotesByMeeting($id)
    {
        return Note::where('meeting_id', $id)->first();
    }
}
