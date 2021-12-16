@extends('layouts.template')

@section('title', 'Dashboard | Admin')

@section('attend-update')

<div class="margin-judul">
    <h1>Ubah Data Pegawai Sea Mobile Indonesia</h1>
    <ol class="breadcrumb" style="background: none; padding: 10px 0px;">
        <li><a href="#">Dashboard</a></li>
        <li><a href="#">Manajemen Rapat</a></li>
        <li><a href="#">Detail</a></li>
        <li><a href="#">Daftar Hadir Peserta Rapat</a></li>
        <li class="active">Ubah</li>
    </ol>
</div>

<div class="sm3-container">
    <div class="row">
        <div class="col-md-12">
            <div class="db-flex flex-column" style="column-gap: 0px;">
                <div class="col-md-4 sm3-card card-akun-1">
                    <img class="db-img img-pas-foto" src="assets/img/pas-foto.jpg">
                    <div class="form-group row" style="text-align: left;">
                        <label for="colFormLabel" class="col-sm-12 col-form-label">Status Kehadiran Rapat</label> <br>
                        {{ $data->tampilAbsen() }} <br>
                        ubah rapat?? <br>
                        <form action="{{ route('absenSave') }}" method="post">
                            <input type="hidden" name="id" id="id" value="{{ $data->id }}" />
                            @if(!$data->status)
                            @if(isset($meeting)) <input type="hidden" name="meeting_id" id="meeting_id" value="{{ $meeting->id }}" /> @endisset
                            <input type="hidden" name="ref_user_id" id="ref_user_id" value="{{ $data->id }}" />
                            <input type="hidden" name="name" id="name" value="{{ $data->name }}" />
                            <input type="hidden" name="email" id="email" value="{{ $data->email }}" />
                            <input type="hidden" name="division" id="division" value="{{ $data->division }}" />
                            <input type="hidden" name="position" id="position" value="{{ $data->position }}" />
                            <input type="hidden" name="phone" id="phone" value="{{ $data->phone }}" />
                            @endif
                            {{ csrf_field() }}
                            <button type="button" class="btn btn-warning fa fa-edit" data-toggle="modal" data-target="#exampleModalCenter"></button>
                            <!-- Modal -->
                            <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLongTitle">Ubah Daftar Hadir Peserta Rapat</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>

                                        <div class="modal-body">
                                            <div class="form-group row" style="text-align: left;">
                                                <label for="colFormLabel" class="col-sm-12 col-form-label">Status Kehadiran Rapat</label> <br>
                                                <div class="row">
                                                    <div class="col-sm-3" style="margin-left: 15px;">
                                                        <input type="radio" id="status" name="status" value="1"> Hadir<br>
                                                        <input type="radio" id="status" name="status" value="2"> Sakit<br>
                                                        <br>
                                                    </div>
                                                    <div class="col-sm-5" style="margin-left: 15px;">
                                                        <input type="radio" id="status" name="status" value="3"> Izin<br>
                                                        <input type="radio" id="status" name="status" value="0"> Tidak Hadir
                                                        <br>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-secondary" data-dismiss="modal">Kembali</button>
                                            <button type="submit" class="btn btn-primary">Simpan</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-md-8 sm3-card card-akun-2">
                    <div class="db-flex">
                        <h3 style="margin: 0px;">Informasi Daftar Hadir Peserta Rapat</h3>
                    </div>
                    <hr><br>

                    <input type="hidden" name="id" id="id" value="" />
                    <div class="form-group row" style="margin-bottom: 10px;">
                        <label for="staticEmail" class="col-sm-3 col-form-label">Nama</label>
                        <div class="col-sm-9">
                            <p>{{ $data->name }}</p>
                        </div>
                    </div>
                    <div class="form-group row" style="margin-bottom: 10px;">
                        <label for="staticEmail" class="col-sm-3 col-form-label">Divisi</label>
                        <div class="col-sm-9">
                            <p>{{ $data->division }}
                            <p>
                        </div>
                    </div>
                    <div class="form-group row" style="margin-bottom: 10px;">
                        <label for="staticEmail" class="col-sm-3 col-form-label">Jabatan</label>
                        <div class="col-sm-9">
                            <p>{{ $data->position }}</p>
                        </div>
                    </div>
                    <div class="form-group row" style="margin-bottom: 10px;">
                        <label for="staticEmail" class="col-sm-3 col-form-label">Tanggal Presensi</label>
                        <div class="col-sm-9">
                            <p>{{ $data->tampilTanggal() }}</p>
                        </div>
                    </div>
                    <div class="form-group row" style="margin-bottom: 10px;">
                        <label for="staticEmail" class="col-sm-3 col-form-label">Jam Presensi</label>
                        <div class="col-sm-9">
                            <p>{{ $data->tampilJam() }}</p>
                        </div>
                    </div>
                    <br>
                    <a href="" class="btn btn-primary btn-kanan" role="button" aria-disabled="true">Simpan Rapat</a>
                    <a href="" class="btn btn-success btn-kanan" role="button" aria-disabled="true">Kembali</a>
                </div>
            </div>
        </div>
    </div>
</div> <br>

@endsection