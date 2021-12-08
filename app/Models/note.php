<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class note extends Model
{
    use HasFactory;

    protected $fillable = [
        'id', 'meeting_id', 'notes', 'created_at', 'updated_at'
    ];

    public static function getNotesByMeeting($id)
    {
        return Note::where('meeting_id', $id)->first();
    }

    public static function noteSave($data, $id)
    {
        $note = Note::where('meeting_id', $id)->first();
        if($note) {
            return $note->update($data);
        } else {
            return Note::insert($data);
        }
    }
}
