<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function getAllUser()
    {
        $data = User::leftJoin('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
            ->leftJoin('roles', 'model_has_roles.role_id', '=', 'roles.id')
            ->select('users.id', 'users.name', 'roles.name AS rolename', 'email', 'division', 'position')
            ->orderBy('users.id', 'asc')
            ->get();
        return $data;
    }

    public static function getUser($id)
    {
        return User::where('id', $id)->first();
    }

    public static function updateProfile($id, $email, $phone)
    {
        return User::where('id', $id)->update(['email' => $email, 'phone' => $phone]);
    }

    public static function getUserParticipant($division)
    {
        return User::where('division', $division)->get();
    }

    public static function getUserAttendances($id, $participant)
    {
        return User::where('users.division', 'like', '%' . $participant . '%')
            ->leftJoin('attendances', function ($join) use ($id) {
                $join->on('users.id', '=', 'attendances.ref_user_id')
                    ->where('attendances.meeting_id', '=', $id);
            })
            ->select('users.id', 'users.name', 'users.email', 'users.division', 'users.position', 'users.phone', 'attendances.id as attendances_id', 'attendances.created_at', 'attendances.updated_at', 'attendances.meeting_id', 'attendances.status')
            ->orderBy('users.id', 'asc')
            ->get();
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
        if ($this->status == 0) {
            return 'Alpha';
        }
    }

    public function isAdministrator()
    {
        return $this->hasRole('admin');
    }
    
    public function isAdminDivisi()
    {
        return $this->hasRole('admin divisi');
    }

    public static function getDataUser()
    {
        $data = User::leftJoin('attendances', 'users.id', '=', 'attendances.ref_user_id')
        ->select('users.id', 'users.name', 'users.division', 'users.position', 'SELECT count("attendances.id") as total')
        ->get();
        return $data;
    }
}
