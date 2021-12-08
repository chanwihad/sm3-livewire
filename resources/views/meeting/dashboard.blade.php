@extends('layouts.template')

@section('title', 'Dashboard | Admin')

@section('dashboard')

<div class="margin-judul">
    <h3 style="font-weight: 400;">Dashboard</h3>
    <h1>Sea Mobile Meeting Management</h1>
</div>

<div class="sm3-container">
    <div class="row sm3-card" style="padding: 50px 15px !important;">
        <div class="col-md-4">
            <h3>Hi, {{$user->name}}!</h3> <br>
            <p>Selamat datang di <b>SM3 - Sea Mobile Meeting<br>
                    Management System.</b> Kamu dapat melihat<br>
                rapat yang berlangsung dan melakukan<br>
                presensi kehadiran disini</p> <br>
            <a href="" class="btn btn-primary db-btn" role="button" aria-disabled="true">Presensi Sekarang</a>
        </div>
        <div class="col-md-8">
            <img class="db-img" src="assets/img/db.png">
        </div>
    </div>
</div>

<div class="sm3-container">
    <div class="row">
        <div class="col-md-12">
            <div class="db-flex flex-column">
                <div class="col-md-6 sm3-card">
                    <div class="db-flex db-info">
                        <h1 class="db-h1">{{ $jumlah }}</h1>
                        <p class="db-p">dari</p>
                        <h1 class="db-h1">{{ $total }}</h1>
                        <p class="db-p">Agenda Rapat<br>Berhasil Diikuti</p>
                        <div class="icon-card2">
                            <i class="fa fa-angle-double-right"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 sm3-card">
                    <div class="db-flex db-info">
                        <h1 class="db-h1" style="margin-right:10px">{{ $persen }}%</h1>
                        <p class="db-p">Persentase Kehadiran<br>Mengikuti Agenda Rapat</p>
                        <div class="icon-card2">
                            <i class="fa fa-angle-double-right"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



@endsection