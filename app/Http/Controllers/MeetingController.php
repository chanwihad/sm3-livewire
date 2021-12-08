<?php

namespace App\Http\Controllers;

use App\Models\attendance as ModelsAttendance;
use Illuminate\Http\Request;
use App\Models\Meeting;
use App\Models\Note;
use App\Models\User;
use App\Models\Attendance;
use App\Models\Model_has_role;
use DB;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Ramsey\Uuid\Uuid;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class MeetingController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if (\Auth::user()) {
            return view('meeting.dashboard', [
                'data' => Meeting::all(),
                'user' => \Auth::user()
            ]);
        }
    }

    public function meetingList()
    {
        $this->authorize('manage meeting', Meeting::class);
        $user = \Auth::user();
        $data = Meeting::getMeeting();
        if ($data) {
            return view('/meeting/meeting-list', ['data' => $data, 'user' => $user]);
        }
        return abort(404, "User tidak ditemukan");
    }

    public function meetingDetail($id)
    {
        $this->authorize('manage meeting', Meeting::class);
        $user = \Auth::user();
        $detail = Meeting::getMeetingDetail($id);
        $peserta = User::getUserAttendances($id, $detail->participant);
        $notulensi = Note::getNotesByMeeting($id);
        $userrole = Model_has_role::getRoleUser($user->id);
        return view('/meeting/meeting-detail', ['detail' => $detail, 'user' => $user, 'notulensi' => $notulensi, 'peserta' => $peserta, 'userrole' => $userrole, 'info' => 'Meeting']);
    }

    public function meetingCreate()
    {
        $this->authorize('manage meeting', Meeting::class);
        $user = \Auth::user();
        if ($user->hasRole('admin') || $user->hasRole('admin divisi')) {
            return view('/meeting/meeting-create', ['user' => $user]);
        }
    }

    public function meetingUpdate(String $Id)
    {
        $this->authorize('manage meeting', Meeting::class);
        $meeting = Meeting::getMeetingUpdate($Id);
        if ($meeting) {
            return view('/meeting/meeting-update', ['data' => $meeting]);
        }
        return abort(404, "Meeting tidak ditemukan");
    }

    public function meetingSave(Request $request)
    {
        $user = \Auth::user();
        $this->authorize('manage meeting', Meeting::class);
        if ($user->hasRole('pegawai')) {
            return redirect(route('meetingList'))->with('error', 'Anda tidak memiliki akses');
            // return abort(403, "User tidak memiliki hak akses");
        }
        $data = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'date' => 'required|date',
            'time_start' => 'required|date_format:H:i|before:time_end',
            'time_end' => 'required|date_format:H:i|after:time_start',
            'place' => 'required',
            'participant' => 'required',
            'status' => 'required',
        ]);

        // $validator = Validator::make($request->all(), $arrValidate);
        // if ($validator->fails()) {
        //     return redirect(route('meetingCreate'))
        //         ->withErrors($validator)
        //         ->withInput();
        // }
        // $temp = $request->except('_token');
        // dd($arrValidate);
        // $data = (array) $arrValidate;
        // dd($data);
        if ($request->get('id') == null) {
            $data['id'] = \Str::uuid();
            $data['creator'] = $user->id;
        }
        $data['time'] = $data['time_start'] . ' - ' . $data['time_end'];
        unset($data['time_start']);
        unset($data['time_end']);
        $data['date'] = date('Y-m-d', strtotime( $data['date']));
        // dd($data);
        if ($request->get('id') == null) {
            $meeting = Meeting::meetingSaveCreate($data);
            if ($meeting) {
                return redirect(route('meetingList'))->with('success', 'Berhasil menyimpan data meeting baru');
            }
            return redirect(route('meetingList'))->with('error', 'Gagal menyimpan data meeting baru');
        } else {
            $meeting = Meeting::meetingSaveUpdate($data, $request->get('id'));
            if ($meeting) {
                return redirect(route('meetingList'))->with('success', 'Berhasil memperbarui data meeting');
            }
            return redirect(route('meetingList'))->with('error', 'Gagal memperbarui data meeting');
        }
    }

    public function meetingDelete($Id)
    {
        $user = \Auth::user();
        if ($user->hasRole('pegawai')) {
            return redirect(route('meetingList'))->with('error', 'Anda tidak memiliki akses');
            // return abort(403, "User tidak memiliki hak akses");
        }
        $data = Meeting::where('id', $Id)->first();
        if ($data) {
            Meeting::meetingDelete($Id);
            return redirect(route('meetingList'))->with('success', 'Berhasil menghapus data meeting');
        }

        return redirect(route('meetingList'))->with('error', 'Gagal menghapus data meeting');
    }

    public function agendaList()
    {
        $this->authorize('manage meeting', Meeting::class);
        $user = \Auth::user();
        $data = Meeting::getAgenda();
        if ($data) {
            return view('/meeting/agenda-list', ['data' => $data, 'user' => $user]);
        }
        return abort(404, "User tidak ditemukan");
    }

    public function agendaDetail($id)
    {
        $this->authorize('manage meeting', Meeting::class);
        $user = \Auth::user();
        $detail = Meeting::getMeetingDetail($id);
        // $peserta = Attendance::getAttendanceByMeeting($id);
        $peserta = User::getUserAttendances($id, $detail->participant);
        // dd($peserta);
        $notulensi = Note::getNotesByMeeting($id);
        $userrole = Model_has_role::getRoleUser($user->id);
        return view('/meeting/meeting-detail', ['detail' => $detail, 'user' => $user, 'notulensi' => $notulensi, 'peserta' => $peserta, 'userrole' => $userrole, 'info' => 'Agenda']);
    }


    public function absenCreate(Request $request)
    {
        $this->authorize('manage meeting', Meeting::class);
        $user = \Auth::user();
        $data = [
            'meeting_id' => $request->id,
            'ref_user_id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'division' => $user->division,
            'position' => $user->position,
            'phone' => $user->phone,
            'status' => $request->status,
        ];
        $attendance = Attendance::attendanceSave($data);
        if ($attendance) {
            return back()->with('success', 'Berhasil menyimpan data meeting baru');
        }
        return back()->with('error', 'Gagal memperbarui data meeting');
    }

    public function absenUpdate(Request $req)
    {
        $this->authorize('manage meeting', Meeting::class);
        $attendance = Attendance::getAttendanceById($req->id);
        if ($attendance) {
            return view('/meeting/attend-update', ['data' => $attendance]);
        }
        return abort(404, "Meeting tidak ditemukan");
    }

    public function absenSave(Request $req)
    {
        $this->authorize('manage meeting', Meeting::class);
        $ubah = Attendance::attendanceUpdate($req->id, $req->status);
        if ($ubah) {
            return back()->with('success', 'Berhasil menyimpan data meeting baru');
        }
        return abort(404, "Meeting tidak ditemukan");
    }

    public function noteSave(Request $request)
    {
        $user = \Auth::user();
        $this->authorize('manage meeting', Meeting::class);
        if ($user->hasRole('pegawai')) {
            return back()->with('error', 'Anda tidak memiliki akses');
        }
        $data = $request->validate([
            'notes' => 'required',
            'meeting_id' => ''
        ]);
        $meeting = Note::noteSave($data,$request->meeting_id);
        if($meeting){
            return back()->with('success', 'Berhasil menyimpan data notulensi baru');
        }
        return abort(404, "Meeting tidak ditemukan");
    }










    public function simpanNotulensi(Request $request)
    {
        $user = \Auth::user();
        $this->authorize('manage meeting', Note::class);
        if ($user->hasRole('pegawai')) {
            return redirect(route('meetingList'))->with('error', 'Anda tidak memiliki akses');
            // return abort(403, "User tidak memiliki hak akses");
        }
        $arrValidate = [
            'notes' => 'required',
        ];
        $validator = Validator::make($request->all(), $arrValidate);
        if ($validator->fails()) {
            return redirect(route('buatNotulensi'))
                ->withErrors($validator)
                ->withInput();
        }
        $data = $request->toArray();
        if ($request->get('id') == null) {
            /** @var Note $note */
            $notulensi = Note::create($data);
            if ($note) {
                return redirect(route('daftarMeeting'))->with('success', 'Berhasil menyimpan data notulensi baru');
            }
            return redirect(route('daftarMeeting'))->with('error', 'Gagal menyimpan data notulensi baru');
        } else {
            $notulensi = Note::where('id', $request->get('id'))->first();
            if ($notulensi->update($data)) {
                return redirect(route('daftarMeeting'))->with('success', 'Berhasil memperbarui data notulensi');
            }
            return redirect(route('daftarMeeting'))->with('error', 'Gagal memperbarui data notulensi');
        }
    }

    public function cekNotulensi(String $Id)
    {
        $user = \Auth::user();
        $this->authorize('manage meeting', Note::class);
        $data = Note::where('id', $Id)->first();
        if ($data) {
            return view('/meeting/cek-notulensi', ['data' => $data]);
        }
        return abort(404, "Notulensi tidak ditemukan");
    }

    public function ubahNotulensi(String $Id)
    {
        $user = \Auth::user();
        $this->authorize('manage meeting', Note::class);
        if ($user->hasRole('admin') || $user->hasRole('admin divisi')) {
            $notulensi = Note::where('id', $Id)->first();
        }
        if ($notulensi) {
            return view('meeting/ubah-notulensi', ['data' => $notulensi]);
        }
        return abort(404, "Notulensi tidak ditemukan");
    }

    public function absenMeeting(String $Id)
    {
        $user = \Auth::user();
        $data = Meeting::where('id', $Id)->first();
        return view('meeting/absen-meeting', [
            'data' => $data,
            'user' => $user
        ]);
    }

    public function konfirmasi1(Request $request, String $Id)
    {
        $user = \Auth::user();
        $arrValidate = [
            'id_meeting' => 'required',
            'status' => 'required',
        ];
        $validator = Validator::make($request->all(), $arrValidate);
        if ($validator->fails()) {
            return redirect(route('absenMeeting'))
                ->withErrors($validator)
                ->withInput();
        }
        $data = $request->toArray();
        $data['id'] = \Str::uuid();
        $data['time'] = $data['time_start'] . (empty($data['time_end']) ?: ' - ' . $data['time_end']) . " " . $data['zona_waktu'];
        if ($request->get('id') == null) {
            /** @var Meeting $meeting */
            $meeting = Meeting::create($data);
            if ($meeting) {
                return redirect(route('daftarMeeting'))->with('success', 'Berhasil menyimpan data meeting baru');
            }
            return redirect(route('daftarMeeting'))->with('error', 'Gagal menyimpan data meeting baru');
        } else {
            $meeting = Meeting::where('id', $request->get('id'))->first();
            if ($meeting->update($data)) {
                return redirect(route('daftarMeeting'))->with('success', 'Berhasil memperbarui data meeting');
            }
            return redirect(route('daftarMeeting'))->with('error', 'Gagal memperbarui data meeting');
        }
    }

    public function konfirmasi(Request $req, string $id)
    {
        /**
         * @var User $user
         * @var Event $event
         */
        $user = \Auth::user();
        $event = $req->event;
        if ($user->alreadyConfirmedOn($event->id)) {
            return view('events/konfirmasi-finished', [
                'event' => $event,
                'user' => $user
            ]);
        }

        return view('events/konfirmasi', [
            'event' => $event,
            'user' => $user
        ]);
    }

    public function saveKonfirmasi(Request $req, string $id)
    {
        /** @var Event $event */
        /** @var User $user */
        $user = \Auth::user();
        $event = $req->event;

        $requirements = [
            'paraf' => 'required',
        ];

        if ($event->hasPasscode()) {
            $id = $event->id;
            $passcode = $req->post('passcode');
            $requirements['passcode'] = [
                'required',
                Rule::exists('events')
                    ->where(function ($query) use ($id, $passcode) {
                        return $query
                            ->where('id', $id)
                            ->where('passcode', $passcode);
                    }),
            ];
        }
    }

    public function registrasi(Request $req, string $id)
    {
        /**
         * @var User $user
         * @var Event $event
         */
        $user = \Auth::user();
        $event = $req->event;
        if ($user->alreadyRegisteredOn($event->id)) {
            return view('events/registrasi-finished', [
                'event' => $event,
                'user' => $user
            ]);
        }

        return view('events/registrasi', [
            'event' => $event,
            'user' => $user
        ]);
    }

    public function saveRegistrasi(Request $req, string $id)
    {
        /** @var Event $event */
        /** @var User $user */
        $user = \Auth::user();
        $event = $req->event;

        $reg = new EventRegistration();
        $reg->event_id = $event->id;
        $reg->ref_user_id = $user->id;
        $reg->name = $user->name;
        $reg->email = $user->email;
        $reg->organisasi = $user->getNamaOrganisasi();
        $reg->jabatan = $user->getNamaJabatan();
        $reg->registered = true;
        $reg->save();
        event(new RegistrasiCreated($reg));

        return redirect('event/registrasi/' . $event->id);
    }
}























// public function __construct()
//     {
//         $this->middleware('auth');
//         // $this->middleware(function (Request $req, $next) {
//         //     $id = $req->route('id');
//         //     if (!empty($id)) {
//         //         if (!Uuid::isValid($id)) {
//         //             throw new NotFoundHttpException('Meeting Not Found');
//         //         }

//         //         $meeting = Meeting::find($id);
//         //         if (!$meeting) {
//         //             throw new NotFoundHttpException('Meeting Not Found');
//         //         }

//         //         $req->merge(['meeting' => $meeting]);

//         //         return $next($req);
//         //     }
//         //     return $next($req);
//         // });

//         //     $id = $this->route('id');
//         // dd($id);
//     }

//     /**
//      * Show the application dashboard.
//      *
//      * @return \Illuminate\Contracts\Support\Renderable
//      */
//     public function index() //Request $req)
//     {
//         // return view('home');
//         // $daftarmeeting = Meeting::all();
//         // $daftarmeeting = $req->meeting;
//         // dd($daftarmeeting);
//         // $user = \Auth::user();
//         // dd($user->division);

//         // $user = \App\Models\User::where('id',1)->first();
//         // if($user) {
//         //     $user->assignRole('admin');
//         // }
//         // $this->authorize('manage role', User::class);
//         // $ubahuser1 = User::where('id', 1)->first();
//         // $ubahuser1->assignRole('admin');
//         // $ubahuser2 = User::where('id', 2)->first();
//         // $ubahuser2->assignRole('admin divisi');
//         // $ubahuser3 = User::where('id', 3)->first();
//         // $ubahuser3->assignRole('pegawai');
//         if (\Auth::user()) {
//             return view('meeting.dashboard', [
//                 'data' => Meeting::all(),
//                 'user' => \Auth::user()
//             ]);
//         }
//         // $user = \Auth::user();
//         // if ($user->hasRole('admin')) {
//         //     $this->authorize('manage meeting', User::class);
//         //     $data = Meeting::
//         //     orderBy('created_at', 'asc')
//         //     ->paginate(10);
//         //     dd($data);
//         //     return view('/user/admin/ubah-user', ['data' => $data, 'user' => $user]);
//         // } else if ($user->hasRole('admin divisi')) {
//         //     $this->authorize('manage meeting', User::class);
//         //     $data = Meeting::
//         //     where('creator', $user->id)
//         //     ->orWhere('participant', 'like', 'semua')
//         //     ->orWhere('participant', 'like', $user->division)
//         //     // ->orWhere('participant', 'ilike', '%'.$user->id.'%')
//         //     ->orderBy('created_at', 'asc')
//         //     ->paginate(10);
//         //     dd($data);
//         //     return view('?????', ['data' => $data, 'user' => $user]);
//         // } else if ($user->hasRole('pegawai')) {
//         //     $data = Meeting::
//         //     Where('participant', 'like', 'semua')
//         //     ->orWhere('participant', 'like', $user->division)
//         //     ->orderBy('created_at', 'asc')
//         //     ->paginate(10);
//         //     dd($data);
//         //     return view('????', ['data' => $data, 'user' => $user]);
//         // }
//         // return abort(404, "User tidak ditemukan");
//     }