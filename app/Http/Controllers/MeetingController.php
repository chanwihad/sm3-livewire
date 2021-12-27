<?php

namespace App\Http\Controllers;

use App\Models\attendance as ModelsAttendance;
use Illuminate\Http\Request;
use App\Models\Meeting;
use App\Models\Note;
use App\Models\User;
use App\Models\Attendance;
use DB;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Ramsey\Uuid\Uuid;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Str;

use App\Mail\NotifikasiEmail;
use Illuminate\Support\Facades\Mail;

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
        $user = \Auth::user();
        if ($user) {
            $att = Attendance::getJumlahHadir($user->id);
            $meet = Meeting::getTotalHadir($user->division);
            if ($att) {
                $persen = $att / $meet * 100;
            } else {
                $persen = 0;
            }
            return view('meeting.dashboard', [
                'data' => Meeting::all(),
                'user' => $user,
                'jumlah' => $att,
                'total' => $meet,
                'persen' => number_format($persen)
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
        return view('/meeting/meeting-detail', ['detail' => $detail, 'user' => $user, 'notulensi' => $notulensi, 'peserta' => $peserta, 'info' => 'Meeting']);
    }

    public function meetingCreate()
    {
        $this->authorize('manage meeting', Meeting::class);
        $user = \Auth::user();
        if ($user->hasRole('admin') || $user->hasRole('admin divisi')) {
            return view('/meeting/meeting-create', ['user' => $user]);
        }
        return back()->with('warning', 'Anda tidak memiliki akses');
    }

    public function meetingUpdate(String $Id)
    {
        $this->authorize('manage meeting', Meeting::class);
        $user = \Auth::user();
        if ($user->hasRole('admin') || $user->hasRole('admin divisi')) {
            $meeting = Meeting::getMeetingUpdate($Id);
            $meeting->date = date('m/d/Y', strtotime($meeting['date']));
            if ($meeting) {
                return view('/meeting/meeting-update', ['data' => $meeting, 'user' => $user]);
            }
        }
        return abort(404, "Meeting tidak ditemukan");
    }

    public function meetingSave(Request $request)
    {
        $user = \Auth::user();
        $this->authorize('manage meeting', Meeting::class);
        if ($user->hasRole('pegawai')) {
            return redirect(route('meetingList'))->with('warning', 'Anda tidak memiliki akses');
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
        if ($request->get('id') == null) {
            $data['id'] = \Str::uuid();
            $data['creator'] = $user->id;
        }
        $data['time'] = $data['time_start'] . ' - ' . $data['time_end'];
        unset($data['time_start']);
        unset($data['time_end']);
        $data['date'] = date('Y-m-d', strtotime($data['date']));
        // dd($data);
        if ($request->get('id') == null) {
            $meeting = Meeting::meetingSaveCreate($data);
            if ($meeting) {
                return redirect(route('meetingList'))->with('success', 'Berhasil menyimpan data meeting baru');
            }
            return redirect(route('meetingList'))->with('warning', 'Gagal menyimpan data meeting baru');
        } else {
            $meeting = Meeting::meetingSaveUpdate($data, $request->get('id'));
            if ($meeting) {
                return redirect(route('meetingList'))->with('success', 'Berhasil memperbarui data meeting');
            }
            return redirect(route('meetingList'))->with('warning', 'Gagal memperbarui data meeting');
        }
    }

    public function meetingDeleteConfirm($id)
    {
        $user = \Auth::user();
        if ($user->hasRole('pegawai')) {
            return redirect(route('meetingList'))->with('warning', 'Anda tidak memiliki akses');
            // return abort(403, "User tidak memiliki hak akses");
        } else {
            alert()->question('Apakah anda yakin', 'Untuk Menghapus Data Pegawai ini?')
                ->showConfirmButton('<a style="color: white;" href="/management/meeting/' . $id . '/delete">Hapus</a>')->toHtml()
                ->showCancelButton('Kembali', '#aaa')->reverseButtons();

            return redirect(route('meetingList'));
        }
        return redirect(route('meetingList'))->with('warning', 'Gagal menghapus data meeting');
    }

    public function meetingDelete($Id)
    {
        $data = Meeting::where('id', $Id)->first();
        if ($data) {
            Meeting::meetingDelete($Id);
            return redirect(route('meetingList'))->with('success', 'Berhasil menghapus data meeting');
        }

        return redirect(route('meetingList'))->with('warning', 'Gagal menghapus data meeting');
    }

    public function agendaList()
    {
        $this->authorize('manage meeting');
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
        $peserta = User::getUserAttendances($id, $detail->participant);
        $notulensi = Note::getNotesByMeeting($id);
        return view('/meeting/meeting-detail', ['detail' => $detail, 'user' => $user, 'notulensi' => $notulensi, 'peserta' => $peserta, 'info' => 'Agenda']);
    }

    public function absenCreate(Request $request)
    {
        $this->authorize('manage meeting', Attendance::class);
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
            return back()->with('success', 'Berhasil menyimpan data absen');
        }
        return back()->with('warning', 'Gagal memperbarui data absen');
    }

    public function absenUpdate(Request $req)
    {
        $this->authorize('manage meeting', Attendance::class);
        $attendance = Attendance::getAttendanceById($req->id);
        if ($attendance) {
            return view('/meeting/attend-update', ['data' => $attendance]);
        }
        if (!$attendance) {
            $attendance = User::getUser($req->user_id);
            $meeting = Meeting::getMeetingById($req->meeting_id);
            return view('/meeting/attend-update', ['data' => $attendance, 'meeting' => $meeting]);
        }
        return abort(404, "Meeting tidak ditemukan");
    }

    public function absenSave(Request $req)
    {
        $this->authorize('manage meeting', Attendance::class);
        if (!$req->meeting_id) {
            $ubah = Attendance::attendanceUpdate($req->id, $req->status);
            if ($ubah) {
                return back()->with('success', 'Berhasil mengubah data absen');
            }
        } else {
            $data = [
                'meeting_id' => $req->meeting_id,
                'ref_user_id' => $req->ref_user_id,
                'name' => $req->name,
                'email' => $req->email,
                'division' => $req->division,
                'position' => $req->position,
                'phone' => $req->phone,
                'status' => $req->status,
            ];
            $buat = Attendance::attendanceSave($data);
            if ($buat) {
                return redirect(route('meetingDetail', [$req->meeting_id]))->with('success', 'Berhasil mengubah data absen');
            }
        }
        return abort(404, "Absen tidak ditemukan");
    }

    public function noteSave(Request $request)
    {
        $user = \Auth::user();
        $this->authorize('manage meeting', Note::class);
        if ($user->hasRole('pegawai')) {
            return back()->with('warning', 'Anda tidak memiliki akses');
        }
        $data = $request->validate([
            'notes' => 'required',
            'meeting_id' => '',
            'documentation' => 'required|max:2048|mimes:jpeg,png,jpg,gif,svg',
        ]);
        $fileName = $request->documentation->getClientOriginalName();
        $documentation = $request->documentation->storeAs('documentation', $fileName);
        $data['documentation'] = $documentation;
        $meeting = Note::noteSave($data, $request->meeting_id);
        if ($meeting) {
            return back()->with('success', 'Berhasil menyimpan data notulensi baru');
        }
        return abort(404, "Meeting tidak ditemukan");
    }

    public function notificationGmail($id)
    {
        $user = \Auth::user();
        $this->authorize('manage meeting', Meeting::class);
        if ($user->hasRole('pegawai')) {
            return back()->with('warning', 'Anda tidak memiliki akses');
        }
        $meeting = Meeting::getMeetingById($id);
        $meeting->date = date('D, d M Y', strtotime($meeting['date']));
        $participant = User::getUserParticipant($meeting->participant);
        if ($participant) {
            foreach ($participant as $peserta) {
                Mail::to('safitriherdian28@gmail.com')->send(new NotifikasiEmail($meeting, $peserta));
            }
            return back()->with('success', 'Berhasil mengirim pemberitahuan melalui Email');
        }
        return back()->with('warning', 'Gagal mengirim pemberitahuan melalui Email');
    }

    public function notificationWhatsapp(Request $request)
    {
        $this->authorize('manage meeting', Meeting::class);
        $meeting = Meeting::getMeetingById($request->id);
        $participant = User::getUserParticipant($meeting->participant);
        foreach ($participant as $peserta) {
            $curl = curl_init();
            $token = "IHN3mgZlvZOLVUnFx5cTOrcbL3zp0FnlH9U0YDyJlrXFTa6UFoeLK1jCu9VUF11m";
            $payload = [
                "data" => [
                    [
                        'phone' => $peserta->phone,
                        'message' => 'PEMBERITAHUAN AGENDA RAPAT SMI
Kepada ' . $peserta->name . ', 
                        
Diberitahukan kepada saudara bahwa terdapat agenda rapat pada: 
Tanggal : ' . $meeting->date . '
Jam : ' . $meeting->time . '
Tempat : ' . $meeting->place . ' 

Dimohon untuk hadir dan mengikuti agenda rapat tersebut. Atas perhatian dan waktunya kami ucapkan terima kasih

Ket: ' . $meeting->description,
                        'secret' => false,
                        'priority' => false,
                    ]
                ]
            ];
            curl_setopt(
                $curl,
                CURLOPT_HTTPHEADER,
                array(
                    "Authorization: $token",
                    "Content-Type: application/json"
                )
            );
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($payload));
            curl_setopt($curl, CURLOPT_URL, "https://wablas.com/api/v2/send-bulk/text");
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
            $result = curl_exec($curl);
            curl_close($curl);
        }
        if (Str::contains($result, 'true')) {
            return back()->with('success', 'Berhasil mengirim pemberitahuan melalui Whatsapp');
        }
        return back()->with('warning', 'Gagal mengirim pemberitahuan melalui Whatsapp');
    }
}
