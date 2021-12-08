<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Ramsey\Uuid\Uuid;

/**
 * App\Models\Event
 *
 * @property Uuid $id
 **/

class meeting extends Model
{
    use HasFactory;

    protected $table = 'meetings';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id', 'title', 'description', 'date', 'time', 'place', 'creator', 'participant', 'status', 'created_at', 'updated_at'
    ];
    protected $casts = [
        'id' => 'string'
    ];

    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;

    // protected $dispatchesEvents = [
    //     'created_at' => RegisterToFts::class,
    //     'updated_at' => RegisterToFts::class,
    //   ];
    /**
     * The storage format of the model's date columns.
     *
     * @var string
     */
    protected $dateFormat = 'U';


    public static function getMeeting()
    {
        $user = \Auth::user();
        if ($user->hasRole('admin')) {
            $data = Meeting::orderBy('created_at', 'desc')->get();
            return $data;
        } else if ($user->hasRole('admin divisi')) {
            $data = Meeting::where('creator', $user->id)
                ->orWhere('participant', 'like', '%Rapat Besar%')
                ->orWhere('participant', 'like', '%' . $user->division . '%')
                ->orderBy('created_at', 'desc')
                ->get();
            // dd($data);
            return $data;
        }
        // else if ($user->hasRole('pegawai')) {
        //     $data = Meeting::Where('participant', 'ilike', 'semua')
        //         ->orWhere('participant', 'ilike', $user->division)
        //         ->orderBy('created_at', 'asc')
        //         ->get();
        //     return $data;
        // }
    }

    public static function getAgenda()
    {
        $user = \Auth::user();
        if ($user->hasRole('admin')) {
            $data = Meeting::where('participant', 'like', '%Rapat Besar%')
                ->orWhere('participant', 'like', '%' . $user->division . '%')
                ->orderBy('created_at', 'desc')
                ->leftJoin('attendances', function ($join) {
                    $join->on('meetings.id', '=', 'attendances.meeting_id')
                        ->where('ref_user_id', '=', \Auth::user()->id);
                })
                ->select('meetings.id as id', 'attendances.id as attendance_id', 'ref_user_id', 'title', 'description', 'date', 'time', 'place', 'creator', 'participant', 'meetings.status', 'attendances.status as attendances_status', 'meetings.created_at', 'meetings.updated_at')
                ->get();
            return $data;
        } else if ($user->hasRole('admin divisi')) {
            $data = Meeting::where('creator', $user->id)
                ->orWhere('participant', 'like', '%Rapat Besar%')
                ->orWhere('participant', 'like', '%' . $user->division . '%')
                ->orderBy('created_at', 'desc')
                ->leftJoin('attendances', function ($join) {
                    $join->on('meetings.id', '=', 'attendances.meeting_id')
                        ->where('ref_user_id', '=', \Auth::user()->id);
                })
                ->select('meetings.id as id', 'attendances.id as attendance_id', 'ref_user_id', 'title', 'description', 'date', 'time', 'place', 'creator', 'participant', 'meetings.status', 'attendances.status as attendances_status', 'meetings.created_at', 'meetings.updated_at')
                ->get();
            return $data;
        } else if ($user->hasRole('pegawai')) {
            $data = Meeting::Where('participant', 'like', '%Rapat Besar%')
                ->orWhere('participant', 'like',  '%' . $user->division . '%')
                ->orderBy('created_at', 'desc')
                ->leftJoin('attendances', function ($join) {
                    $join->on('meetings.id', '=', 'attendances.meeting_id')
                        ->where('ref_user_id', '=', \Auth::user()->id);
                })
                ->select('meetings.id as id', 'attendances.id as attendance_id', 'ref_user_id', 'title', 'description', 'date', 'time', 'place', 'creator', 'participant', 'meetings.status', 'attendances.status as attendances_status', 'meetings.created_at', 'meetings.updated_at')
                ->get();
            return $data;
        }
    }

    public static function getMeetingDetail($id)
    {
        return Meeting::where('meetings.id', $id)
            // ->leftJoin('attendances', 'meetings.id', '=', 'attendances.meeting_id')
            ->leftJoin('attendances', function ($join) {
                $join->on('meetings.id', '=', 'attendances.meeting_id')
                    ->where('ref_user_id', '=', \Auth::user()->id);
            })
            ->select('meetings.id as id', 'attendances.id as attendance_id', 'ref_user_id', 'title', 'description', 'date', 'time', 'place', 'creator', 'participant', 'meetings.status', 'attendances.status as attendances_status', 'meetings.created_at', 'meetings.updated_at')
            ->first();
    }

    public static function getMeetingUpdate($id)
    {
        $user = \Auth::user();
        if ($user->hasRole('admin') || $user->hasRole('admin divisi')) {
            return Meeting::where('id', $id)->first();
        }
    }

    public static function meetingSaveCreate($data)
    {
        return Meeting::insert($data);
    }

    public static function meetingSaveUpdate($data, $id)
    {
        $meeting = Meeting::where('id', $id)->first();
        return $meeting->update($data);
    }

    public static function meetingDelete($id)
    {
        return Meeting::where('id', $id)->delete();
    }

    public function getStatus(): string
    {
        if ($this->status == self::STATUS_INACTIVE) {
            return 'tutup';
        }

        $now = Carbon::now();
        $date = Carbon::createFromFormat('Y-m-d', $this->date)
            ->endOfDay();
        // ->toDateTimeString();

        if (
            // $now->equalTo($this->date)
            $now->greaterThanOrEqualTo($this->date)
            && $now->lessThanOrEqualTo($date)
            && $this->status == self::STATUS_ACTIVE
        ) {
            return 'berlangsung';
        }

        if (
            $now->lessThanOrEqualTo($this->date)
            && $this->status == self::STATUS_ACTIVE
        ) {
            return 'belum dibuka';
        }

        if (
            $now->greaterThanOrEqualTo($date)
            && $this->status == self::STATUS_ACTIVE
        ) {
            return 'selesai';
        }


        return 'tutup';
    }

    public static function getTotalHadir($division)
    {
        return meeting::where('participant', 'like', '%Rapat Besar%')->orWhere('participant', 'like', '%' . $division . '%')->count();
    }

    public function isBelumDibuka(): bool
    {
        return $this->getStatus() == 'belum dibuka';
    }

    public function isBerlangsung(): bool
    {
        return $this->getStatus() == 'berlangsung';
    }

    public function isSelesai(): bool
    {
        return $this->getStatus() == 'selesai';
    }

    public function isTutup(): bool
    {
        return $this->getStatus() == 'tutup';
    }

    public function tampilTanggal(): string
    {
        if (empty($this->date)) {
            return '-';
        }
        return $this->date;
    }
    public function getTimeStart()
    {
        $temp = str_replace(' -', '', $this->time);
        $explodeJam = explode(' ', $temp);
        return $explodeJam[0];
    }

    public function getTimeEnd()
    {
        $temp = str_replace(' -', '', $this->time);
        $explodeJam = explode(' ', $temp);
        return $explodeJam[1];
    }

    public function tampilAbsen(): string
    {
        if (empty($this->attendances_status)) {
            return 'Alpha';
        }
        if ($this->attendances_status == 1) {
            return 'Hadir';
        }
        if ($this->attendances_status == 2) {
            return 'Sakit';
        }
        if ($this->attendances_status == 3) {
            return 'Izin';
        }
        if ($this->attendances_status == 0) {
            return 'Alpha';
        }
    }
}
