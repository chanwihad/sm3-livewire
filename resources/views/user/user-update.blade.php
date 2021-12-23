@extends('layouts.template')

@section('title', 'Dashboard | Admin')

@section('data-edit')

<div class="margin-judul">
    <h1>Ubah Data Pegawai Sea Mobile Indonesia</h1>
    <ol class="breadcrumb" style="background: none; padding: 10px 0px;">
        <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
        <li><a href="{{ route('userList') }}">Data Pegawai</a></li>
        <li class="active">Ubah</li>
    </ol>
</div>

<div class="sm3-container">
    <div class="row">
        <div class="col-md-12">
            <div class="db-flex flex-column" style="column-gap: 0px;">
                <div class="col-md-4 sm3-card card-akun-1">
                    <img class="db-img img-pas-foto" src="assets/img/pas-foto.jpg">
                    <h4>{{ $user->name }}</h4>
                    <p>Total Kehadiran : {{ $jumlah }} dari {{ $total }}</p>
                    <br>
                    <span class="badge badge-pegawai" data-toggle="tooltip" data-placement="bottom" title="Persentase Kehadiran">{{ $persen }}%</span>
                </div>
                <div class="col-md-8 sm3-card card-akun-2">
                    <div class="db-flex">
                        <h3 style="margin: 0px;">Informasi Akun</h3>
                    </div>
                    <hr><br>

                    <form action="{{ route('userSave') }}" method="POST">
                        <input type="hidden" name="id" id="id" value="{{$user->id}}" />
                        {{ csrf_field() }}
                        <div class="form-group row" style="margin-bottom: 10px;">
                            <label for="staticEmail" class="col-sm-2 col-form-label">Nama</label>
                            <div class="col-sm-10">
                                <p>{{ $user->name }}</p>
                            </div>
                        </div>
                        <div class="form-group row" style="margin-bottom: 10px;">
                            <label for="staticEmail" class="col-sm-2 col-form-label">Divisi</label>
                            <div class="col-sm-10">
                                <p>{{ $user->division }}
                                <p>
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
                                <p>{{ $user->email }}</p>
                            </div>
                        </div>
                        <div class="form-group row" style="margin-bottom: 10px;">
                            <label for="staticEmail" class="col-sm-2 col-form-label">Handphone</label>
                            <div class="col-sm-10">
                                <p>{{ $user->phone }}</p>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="colFormLabel" class="col-sm-2 col-form-label">Hak Akses</label>
                            <div class="col-sm-10">
                                <!-- <select class="form-control">
                                    @foreach($role as $roles)
                                    <option name="role" value="{{$roles->name}}" @isset($data) @if($data->role_id == $roles->id) checked @endif @endisset> {{$roles->name}} </option>
                                    @endforeach
                                </select> -->
                                <div class="md:w-2/3">

                                    @foreach($role as $roles)
                                    <input type="radio" name="role" value="{{$roles->name}}" @isset($data) @if($data->role_id == $roles->id) checked @endif @endisset> {{$roles->name}}
                                    <br>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <br>
                        <button type="submit" dusk="createMeeting" class="btn btn-primary btn-kanan" role="button" aria-disabled="true">Simpan Agenda Rapat</button>
                    </form>
                    <button href="{{route('userList')}}" class="btn btn-warning btn-kanan" role="button" aria-disabled="true">Kembali</button>
                    <br><br>
                </div>
            </div>
        </div>
    </div>
</div> <br>

@endsection