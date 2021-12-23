@extends('layouts.template')

@section('title', 'Dashboard | Admin')

@section('akun-edit')

<div class="margin-judul">
    <h1>Profil Saya</h1>
    <ol class="breadcrumb" style="background: none; padding: 10px 0px;">
        <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
        <li><a href="{{ url()->previous() }}">Profil Saya</a></li>
        <li class="active">Ubah Profil</li>
    </ol>
</div>
<form action="{{ route('profileSave') }}" method="post">
    {{ csrf_field() }}
    <div class="sm3-container">
        <div class="row">
            <div class="col-md-12">
                <div class="db-flex flex-column" style="column-gap: 0px;">
                    <div class="col-md-4 sm3-card card-akun-1">
                        <img class="db-img img-pas-foto" src="{{ $user->profile_picture }}">
                        <h4>{{ $user->name }}</h4>
                        <span class="badge badge-akun" data-toggle="tooltip" data-placement="bottom" title="Hak Akses"> {{ $role->name }}</span>
                    </div>
                    <div class="col-md-8 sm3-card card-akun-2">
                        <div class="db-flex">
                            <h3 style="margin: 0px;">Informasi Profil</h3>
                        </div>
                        <hr><br>
                        <div class="form-group row" style="margin-bottom: 10px;">
                            <label for="staticEmail" class="col-sm-2 col-form-label">Nama</label>
                            <div class="col-sm-10">
                                <p>{{ $user->name }}</p>
                            </div>
                        </div>
                        <div class="form-group row" style="margin-bottom: 10px;">
                            <label for="staticEmail" class="col-sm-2 col-form-label">Divisi</label>
                            <div class="col-sm-10">
                                <p>{{ $user->division }}</p>
                            </div>
                        </div>
                        <div class="form-group row" style="margin-bottom: 10px;">
                            <label for="staticEmail" class="col-sm-2 col-form-label">Jabatan</label>
                            <div class="col-sm-10">
                                <p>{{ $user->position }}</p>
                            </div>
                        </div>

                        <div class="form-group row" style="margin-bottom: 10px;">
                            <label for="staticEmail" class="col-sm-2 col-form-label">E-Mail</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="email" name="email" placeholder="{{ $user->email }}" value="{{ $user->email }}">
                            </div>
                        </div>
                        <div class="form-group row" style="margin-bottom: 10px;">
                            <label for="staticEmail" class="col-sm-2 col-form-label">Handphone</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="phone" name="phone" placeholder="{{ $user->phone }}" value="{{ $user->phone }}">
                            </div>
                        </div>
                        <br>
                        <button type="submit" dusk="createMeeting" class="btn btn-primary btn-kanan" role="button" aria-disabled="true">Simpan Profil</button>
                        <button href="{{ route('profileDetail') }}" class="btn btn-warning btn-kanan" aria-disabled="true">Kembali</button>
                        <br><br>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
<br>

@endsection