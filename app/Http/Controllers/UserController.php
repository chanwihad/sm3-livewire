<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use DB;
use App\Models\Meeting;
use App\Models\Role;
use App\Models\Note;
use App\Models\Model_has_role;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Ramsey\Uuid\Uuid;
use Illuminate\Support\Facades\Validator;
// use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserController extends Controller
{

    public function profileDetail()
    {
        $user = \Auth::user();
        if ($user) {
            $userrole = Model_has_role::getRoleUser($user->id);
            $role = Role::getRole($userrole->role_id);
            return view('user.profile-detail', [
                'userrole' => $userrole,
                'user' => $user,
                'role' => $role
            ]);
        }
    }

    public function profileUpdate() 
    {
        $user = \Auth::user();
        if ($user) {
            $userrole = Model_has_role::getRoleUser($user->id);
            $role = Role::getRole($userrole->role_id);
            return view('user.profile-update', [
                'userrole' => $userrole,
                'user' => $user,
                'role' => $role
            ]);
        }
    }

    public function profileSave(Request $request)
    {
        $user = \Auth::user();
        $this->authorize('manage meeting', Meeting::class);
        // dd($request->email);
        // if ($user) {
            // $data = (array) $request;
            // $simpanUser = User::where('id', $user->id)->first();
            $update = User::profileUpdate($user->id, $request->email, $request->phone);
            // where('id', $user->id)
            // ->update(['email' => $request->email, 'phone' => $request->phone]);
            // $update->save();
            if ($update) {
                return redirect(route('profileDetail'))->with('success', 'Berhasil memperbarui data meeting');
            }
        // }

    }

    public function userList()
    {
        $this->authorize('manage role', User::class);
        $user = \Auth::user();
        if ($user->hasRole('admin')) {
            $data = User::getAllUser();
            return view('/user/user-list', ['data' => $data, 'user' => $user]);
        }
        return abort(403, "Anda tidak memiliki hak akses");
    }

    public function userUpdate(String $Id)
    {
        $this->authorize('manage role', User::class);
        $user = \Auth::user();
        if ($user->hasRole('admin')) {
            $user = User::getUser($Id);
            $userrole = Model_has_role::getRoleUser($Id);
            $role = Role::getAllRole();
            return view('/user/user-update', ['data' => $userrole, 'user' => $user, 'role' => $role]);
        }
        return abort(403, "Anda tidak memiliki hak akses");
    }

    public function userSave(Request $request)
    {
        $this->authorize('manage role', User::class);
        $user = \Auth::user();
        if ($user->hasRole('admin')) {
            $ubahuser = User::getUser($request->id);
            $ubahuser->syncRoles($request->role);
            return redirect(route('userList'))->with('success', 'Berhasil memperbarui role user');
        }
        return abort(403, "Anda tidak memiliki hak akses");
    }
}
