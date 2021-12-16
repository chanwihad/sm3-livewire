@extends('layouts.template')

@section('title', 'Dashboard | Admin')

@section('manajemen-rapat')

<div class="margin-judul">
    <h1>Manajemen Agenda Rapat</h1>
    <ol class="breadcrumb" style="background: none; padding: 10px 0px;">
        <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
        <li class="active">Manajemen Rapat</li>
    </ol>
</div>

<div class="sm3-container">
    <div class="row">
        <div class="col-md-12">
            <div class="sm3-card">
                <div class="db-flex">
                    <h3 style="margin: 0px;"> Daftar Agenda Rapat Semua Divisi</h3>
                    <div style="margin-left:auto;">
                        <div class="db-flex">
                            <div class="db-flex" style="column-gap: 0px;">
                                <span class="input-group-addon span-share"><i class="fa fa-plus"></i></span>
                                <a href="{{route('meetingCreate')}}" class="btn btn-primary btn-share" role="button" aria-disabled="true">Tambah Rapat</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div>
    <div class="sm3-container">
        <div class="row">
            <div class="col-md-12">
                <div class="sm3-card">
                    <table class="table table-hover" id="daftar-meeting">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Agenda Rapat</th>
                                <th scope="col">Jadwal</th>
                                <th scope="col">Status</th>
                                <th scope="col">Aksi</th>
                                <th scope="col">Ket</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $datas)
                            <tr>
                                <a href="{{route('meetingCreate')}}">
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <td>
                                        <b>Judul Rapat</b><br>
                                        {{$datas->title}}<br>
                                        <br>
                                        <b>Peserta</b><br>
                                        {{$datas->participant}}<br>

                                    </td>
                                </a>
                                <td>
                                    <div class="row db-flex" style="column-gap: 0px;">
                                        <a class="btn btn-secondary fa fa-calendar" href=""'></a>
                                        <p style="margin-bottom: 0px;">{{$datas->tampilTanggal()}}</p>
                                    </div>
                                    <div class="row db-flex" style="column-gap: 0px;">
                                        <a class="btn btn-secondary fa fa-clock" href=""'></a>
                                        <p style="margin-bottom: 0px;">{{$datas->time}}</p>
                                    </div>
                                    <div class="row db-flex" style="column-gap: 0px;">
                                        <a class="btn btn-secondary fa fa-info-circle" href=""'></a>
                                        <p style="margin-bottom: 0px;">{{$datas->place}}</p>
                                    </div>
                                </td>
                                <td>
                                    <a class="btn btn-info">
                                        @if($datas->isBelumDibuka())
                                        Belum Dimulai
                                        @elseif($datas->isBerlangsung())
                                        Berlangsung
                                        @elseif($datas->isSelesai())
                                        Selesai
                                        @elseif($datas->isTutup())
                                        Tutup
                                        @endif
                                    </a>
                                </td>
                                <td>
                                    <a class="btn btn-warning fa fa-edit" href="{{route('meetingUpdate', $datas->id)}}" data-toggle="tooltip" data-placement="bottom" title="Ubah"></a>
                                    <!-- <a href="{{route('meetingDelete',['id' => $datas->id])}}" class="btn btn-danger fa fa-trash" data-toggle="tooltip" title=' Delete' data-placement="bottom"></a> -->
                                        <a href="{{route('meetingDeleteConfirm',['id' => $datas->id])}}" wire:click="destroy({{ $datas->id }})" class="btn btn-danger fa fa-trash" data-toggle="tooltip" title=' Delete' data-placement="bottom"></a>
                                </td>
                                <td>
                                    <a class="btn btn-primary fa fa-info-circle" href="{{route('meetingDetail', $datas->id)}}"></a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table> <br>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#daftar-meeting').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'excel', 'pdf', 'print'
            ]
        });
    });
</script>

@endsection