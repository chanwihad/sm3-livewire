<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class attendance extends Model
{
    use HasFactory;

    public static function getAttendanceById($id)
    {
        return Attendance::where('id', $id)->orderBy('name', 'asc')->first();
    }

    public static function getAttendanceByMeeting($id)
    {
        return Attendance::where('meeting_id', $id)->orderBy('name', 'asc')->get();
    }

    public static function attendanceSave($data)
    {
        return Attendance::insert($data);
    }

    public static function attendanceUpdate($id, $status)
    {
        return Attendance::where('id', $id)->update(['status' => $status]);
    }

    public static function getJumlahHadir($id)
    {
        return Attendance::where('ref_user_id', $id)->where('status', '=', 1)->count();
    }

    public function tampilJam(): string
    {
        if (empty($this->created_at)) {
            return '-';
        }
        return $this->created_at->format('g:i A');
    }

    public function tampilTanggal(): string
    {
        if (empty($this->created_at)) {
            return '-';
        }
        return $this->created_at->format('D, d M Y');;
    }

    public function tampilAbsen(): string
    {
        if (empty($this->status)) {
            return 'Alpha';
        }
        if ($this->status == 1) {
            return 'Hadir';
        }
        if ($this->status == 2) {
            return 'Sakit';
        }
        if ($this->status == 3) {
            return 'Izin';
        }
        if($this->status == 0) {
            return 'Alpha';
        }
    }
}
