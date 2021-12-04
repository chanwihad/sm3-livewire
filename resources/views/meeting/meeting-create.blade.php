@extends('layouts.template')

@section('title', 'Dashboard | Admin')

@section('manajemen-tambah')

<div class="margin-judul">
  <h1>Buat Rapat</h1>
  <ol class="breadcrumb" style="background: none; padding: 10px 0px;">
    <li><a href="#">Dashboard</a></li>
    <li><a href="#">Manajemen Rapat</a></li>
    <li class="active">Buat Rapat</li>
  </ol>
</div>
<form action="{{route('meetingSave')}}" method="POST">

  {{ csrf_field() }}
  <div class="sm3-container">
    <div class="row">
      <div class="col-md-12">
        <div class="sm3-card">

          <div class="form-group row">
            <label for="colFormLabel" class="col-sm-2 col-form-label">Judul Rapat</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="title" name="title" value="{{old("title")}}" placeholder="judul">
              @if($errors->has('title'))
              <p class="">{{$errors->first('title')}}</p>
              @endif
            </div>
          </div>
          <div class="form-group row">
            <label for="colFormLabel" class="col-sm-2 col-form-label">Deskripsi Rapat</label>
            <div class="col-sm-10">
              <textarea class="form-control" id="description" name="description" rows="3">{!! old('description') !!}</textarea>
              @if($errors->has('description'))
              <p class="">{{$errors->first('description')}}</p>
              @endif
            </div>
          </div>

          <div class="form-group row">
            <label for="colFormLabel" class="col-sm-2 col-form-label">Tanggal</label>
            <div class='form-group col-sm-10 datepicker'>
              <div class="db-flex" style="column-gap: 0px;">
                <input id="date" name="date" value="{{old("date")}}" type="text" class="form-control hasDatepicker" placeholder="Date of Birth">
                <!-- <input type='text' autocomplete="off" class="form-control" placeholder="yyyy-mm-dd" /> -->
                <span class="input-group-addon span-icon"><i class="fa fa-calendar"></i></span>
                @if($errors->has('date'))
                <p class="">{{$errors->first('date')}}</p>
                @endif
              </div>
            </div>
          </div>

          <div class="form-group row">
            <label for="colFormLabel" class="col-sm-2 col-form-label">Jam</label>
            <div class="db-flex">
              <div class='form-group col-md-6 datepicker'>
                <div class="db-flex" style="column-gap: 0px;">
                  <input type='text' autocomplete="off" class="form-control" id="time_start" name="time_start" value="{{old("time_start")}}" placeholder="Mulai" />
                  <span class="input-group-addon span-icon"><i class="fa fa-clock-o"></i></span>
                  @if($errors->has('time_start'))
                  <p class="">{{$errors->first('time_start')}}</p>
                  @endif
                </div>
              </div>
              <div class='form-group col-md-6 datepicker'>
                <div class="db-flex" style="column-gap: 0px;">
                  <input type='text' autocomplete="off" class="form-control" id="time_end" name="time_end" value="{{old("time_end")}}" placeholder="Selesai" />
                  <span class="input-group-addon span-icon"><i class="fa fa-clock-o"></i></span>
                  @if($errors->has('time_end'))
                  <p class="">{{$errors->first('time_end')}}</p>
                  @endif
                </div>
              </div>
            </div>
          </div>

          <div class="form-group row">
            <label for="colFormLabel" class="col-sm-2 col-form-label">Tempat</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="place" name="place" value="{{old("place")}}" placeholder="Lokasi Meeting">
              @if($errors->has('place'))
              <p class="">{{$errors->first('place')}}</p>
              @endif
            </div>
          </div>

          <!-- <div class="form-group row">
                        <label for="colFormLabel" class="col-sm-2 col-form-label">Penyelenggara</label>
                        <div class="col-sm-10">
                            <input type="email" class="form-control" placeholder="col-form-label">
                        </div>
                    </div> -->

          <div class="form-group row">
            <label for="colFormLabel" class="col-sm-2 col-form-label">Peserta</label>
            <div class="col-sm-10">
              <select class="form-control" id="participant" name="participant">
                <option selected>Pilih Peserta Rapat</option>
                <option value="Dewan Pengurus" @if(old("participant") == 'Dewan Pengurus') selected @endif>Dewan Pengurus</option>
                <option value="Divisi SDM" @if(old("participant") == 'Divisi SDM') selected @endif>Divisi SDM</option>
                <option value="Divisi Operasional" @if(old("participant") == 'Divisi Operasional') selected @endif>Divisi Operasional</option>
                <option value="Divisi Pemasaran" @if(old("participant") == 'Divisi Pemasaran') selected @endif>Divisi Pemasaran</option>
                <option value="Divisi Keuangan" @if(old("participant") == 'Divisi Keuangan') selected @endif>Divisi Keuangan</option>
                <option value="Divisi IT" @if(old("participant") == 'Divisi IT') selected @endif>Divisi IT</option>
              </select>
              @if($errors->has('participant'))
              <p class="">{{$errors->first('participant')}}</p>
              @endif
            </div>
          </div>

          <div class="form-group row">
            <label for="colFormLabel" class="col-sm-2 col-form-label">Status</label>
            <div class="col-sm-10">
              <select class="form-control" id="status" name="status">
                <option selected>Pilih Status Agenda Rapat</option>
                <option value="1" @if(old("status") == '1')selected @endif>Aktif</option>
                <option value="0" @if(old("status") == '0')selected @endif>Tidak Aktif</option>
              </select>
              @if($errors->has('status'))
              <p class="">{{$errors->first('status')}}</p>
              @endif
            </div>
          </div> <br>
          <!-- <a href="" class="btn btn-primary btn-kanan" role="button" aria-disabled="true">Simpan Rapat</a>
                    <a href="" class="btn btn-warning btn-kanan" role="button" aria-disabled="true">Kembali</a> -->
          <button class="shadow bg-blue-500 hover:bg-blue-400 focus:shadow-outline focus:outline-none text-white font-bold py-2 px-4 rounded" type="submit" dusk="createMeeting">
            Buat Acara
          </button>
          <br><br>

        </div>
      </div>
    </div>
  </div>
</form>
@endsection