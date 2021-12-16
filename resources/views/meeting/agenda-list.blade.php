@extends('layouts.template')

@section('title', 'Dashboard | Admin')

@section('agenda-rapat')

<div class="margin-judul">
    <h1>Agenda Rapat</h1>
    <ol class="breadcrumb" style="background: none; padding: 10px 0px;">
        <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
        <li class="active">Agenda Rapat</li>
    </ol>
</div>

<div class="sm3-container">
    <div class="row">
        <div class="col-md-12">
            <div class="sm3-card">
                <div class="db-flex">
                    <h3 style="margin: 0px;"> Daftar Agenda Rapat</h3>
                    <div class="icon-card2">
                        <i class="fa fa-angle-double-right"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="sm3-container">
    <div class="row">
        <div class="col-md-12">
            <div class="sm3-card">
                <div class="table-responsive">
                    <table class="table table-hover" id="daftar-meeting">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Agenda Rapat</th>
                                <th scope="col">Jadwal</th>
                                <th scope="col">Status</th>
                                <th scope="col">Presensi</th>
                                <th scope="col">Ket</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $datas)
                            <tr>
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td>
                                    <b>Judul Rapat</b><br>
                                    {{$datas->title}}<br>
                                    <br>
                                    <b>Peserta</b><br>
                                    {{$datas->participant}}<br>
                                </td>
                                <td>
                                    <div class="row db-flex" style="column-gap: 0px;">
                                        <a class="btn btn-secondary fa fa-calendar"></a>
                                        <p style="margin-bottom: 0px;">{{$datas->tampilTanggal()}}</p>

                                    </div>
                                    <div class="row db-flex" style="column-gap: 0px;">
                                        <a class="btn btn-secondary fa fa-clock"></a>
                                        <p style="margin-bottom: 0px;">{{$datas->time}}</p>
                                    </div>
                                    <div class="row db-flex" style="column-gap: 0px;">
                                        <a class="btn btn-secondary fa fa-info-circle"></a>
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
                                    @if($datas->attendance_id)
                                    <i>{{ $datas->tampilAbsen() }}</i>
                                    @elseif($datas->isBelumDibuka())
                                    Belum Dimulai
                                    @elseif($datas->isBerlangsung())
                                    <form action="{{route('absenCreate')}}" method="get">
                                        <input type="hidden" name="id" id="id" value="{{$datas->id}}" />
                                        <button class="btn btn-primary" id="status" name="status" value="1" type="submit">Hadir</button>
                                        <button class="btn btn-danger" id="status" name="status" value="2" type="submit">Sakit</button>
                                        <button class="btn btn-warning" id="status" name="status" value="3" type="submit">Ijin</button>
                                    </form>
                                    @else
                                    Alpha
                                    @endif
                                </td>
                                <td>
                                    <a class="btn btn-primary fa fa-info-circle" href="{{route('agendaDetail', $datas->id)}}"></a>
                                    <!-- <a class="btn btn-primary fa fa-info-circle" wire:click="destroy('12')"></a> -->
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
        $('#daftar-meeting').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'excel', 'pdf', 'print'
            ]
        });
    });
</script>

@endsection