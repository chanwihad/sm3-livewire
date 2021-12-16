@extends('layouts.template')

@section('title', 'Dashboard | Admin')

@section('data-pegawai')

<div class="margin-judul">
  <h1>Data Pegawai Sea Mobile Indonesia</h1>
  <ol class="breadcrumb" style="background: none; padding: 10px 0px;">
    <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="active">Data Pegawai</li>
  </ol>
</div>

<div class="sm3-container">
    <div class="row">
        <div class="col-md-12">
            <div class="sm3-card">

                <div class="table-responsive">
                    <table class="table table-bordered" id="daftar-user">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Nama Lengkap</th>
                                <th scope="col">Aktor</th>
                                <th scope="col">Divisi</th>
                                <th scope="col">Jabatan</th>
                                <th scope="col">Jumlah Kehadiran</th>
                                <th scope="col">Total Kehadiran</th>
                                <th scope="col">Persentase Kehadiran</th>
                                <th scope="col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $datas)
                            <tr>
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td>{{ $datas->name }}</td>
                                <td>{{ $datas->rolename }}</td>
                                <td>{{ $datas->division }}</td>
                                <td>{{ $datas->position }}</td>
                                <td>03</td>
                                <td>05</td>
                                <td>75%</td>
                                <td>
                                    <a class="btn btn-warning fa fa-edit" href="{{ route('userUpdate', $datas->id) }}" data-toggle="tooltip" data-placement="bottom" title="Ubah"></a>
                                    <a wire:click="destroy({{ $datas->id }})" class="btn btn-danger fa fa-trash" data-toggle="tooltip" title=' Delete' data-placement="bottom"></a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>


            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#daftar-user').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'excel', 'pdf', 'print'
            ]
        });
    });
</script>

@endsection