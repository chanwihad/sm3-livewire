@extends('layouts.template')

@section('title', 'Dashboard | Admin')

@section('manajemen-tambah')

<div class="margin-judul">
  <h1>Tambah Rapat</h1>
  <ol class="breadcrumb" style="background: none; padding: 10px 0px;">
    <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li><a href="{{ route('meetingList') }}">Manajemen Rapat</a></li>
    <li class="active">Tambah Rapat</li>
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
              <input type="text" class="form-control" id="title" name="title" value="{{old("title")}}" placeholder="Judul">
              @if($errors->has('title'))
              <p class="alert-danger">{{$errors->first('title')}}</p>
              @endif
            </div>
          </div>
          <div class="form-group row">
            <label for="colFormLabel" class="col-sm-2 col-form-label">Deskripsi Rapat</label>
            <div class="col-sm-10">
              <textarea class="form-control" id="description" name="description" rows="3" placeholder="Deskripsi">{!! old('description') !!}</textarea>
              @if($errors->has('description'))
              <p class="alert-danger">{{$errors->first('description')}}</p>
              @endif
            </div>
          </div>

          <div class="form-group row">
            <label for="colFormLabel" class="col-sm-2 col-form-label">Tanggal</label>
            <div class="col-sm-10">
              <div class="db-flex" style="column-gap: 0px;">
                <input type="text" class="form-control" id="usr1" name="date" value="{{old("date")}}" placeholder="MM/DD/YYYY">
                <span class="input-group-addon span-icon"><i class="fa fa-calendar"></i></span>
              </div>
              @if($errors->has('date'))
              <p class="alert-danger">{{$errors->first('date')}}</p>
              @endif
            </div>
          </div>

          <div class="form-group row">
            <label for="colFormLabel" class="col-sm-2 col-form-label">Jam</label>
            <div class="db-flex">
              <div class="form-group col-sm-6">
                <div class="db-flex" style="column-gap: 0px;">
                  <input type="text" class="form-control" id="timepkr" onclick="showpickers('timepkr',24)" name="time_start" value="{{old("time_start")}}" placeholder="Mulai">
                  <button type="button" class="input-group-addon span-icon"><i class="fa fa-clock"></i></span>

                </div>
                @if($errors->has('time_start'))
                <p class="alert-danger">{{$errors->first('time_start')}}</p>
                @endif
                <div class="timepicker"></div>
              </div>
              <div class="form-group col-sm-6">
                <div class="db-flex" style="column-gap: 0px;">
                  <input type="text" class="form-control" id="timepkr2" onclick="showpickers('timepkr2',24)" name="time_end" value="{{old("time_end")}}" placeholder="Selesai">
                  <button type="button" class="input-group-addon span-icon"><i class="fa fa-clock"></i></span>
                </div>
                @if($errors->has('time_end'))
                <p class="alert-danger">{{$errors->first('time_end')}}</p>
                @endif
                <div class="timepicker"></div>
              </div>
            </div>
          </div>

          <div class="form-group row">
            <label for="colFormLabel" class="col-sm-2 col-form-label">Tempat</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="place" name="place" value="{{old("place")}}" placeholder="Lokasi Meeting">
              @if($errors->has('place'))
              <p class="alert-danger">{{$errors->first('place')}}</p>
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
              @if($user->isAdministrator())
              <select class="form-control" id="participant" name="participant">
                <option value="" selected>Pilih Peserta Rapat</option>
                <option value="Dewan Pengurus" @if(old("participant")=='Dewan Pengurus' ) selected @endif>Dewan Pengurus</option>
                <option value="Divisi SDM" @if(old("participant")=='Divisi SDM' ) selected @endif>Divisi SDM</option>
                <option value="Divisi Operasional" @if(old("participant")=='Divisi Operasional' ) selected @endif>Divisi Operasional</option>
                <option value="Divisi Pemasaran" @if(old("participant")=='Divisi Pemasaran' ) selected @endif>Divisi Pemasaran</option>
                <option value="Divisi Keuangan" @if(old("participant")=='Divisi Keuangan' ) selected @endif>Divisi Keuangan</option>
                <option value="Divisi IT" @if(old("participant")=='Divisi IT' ) selected @endif>Divisi IT</option>
              </select>
              @else
              <select class="form-control" id="participant" name="participant">
                <option value="{{old("participant",$user->division)}}" selected>{{old("participant",$user->division)}}</option>
              </select>
              @endif
              @if($errors->has('participant'))
              <p class="alert-danger">{{$errors->first('participant')}}</p>
              @endif
            </div>
          </div>

          <div class="form-group row">
            <label for="colFormLabel" class="col-sm-2 col-form-label">Status</label>
            <div class="col-sm-10">
              <select class="form-control" id="status" name="status">
                <option value="" selected>Pilih Status Agenda Rapat</option>
                <option value="1" @if(old("status")=='1' )selected @endif>Aktif</option>
                <option value="0" @if(old("status")=='0' )selected @endif>Tidak Aktif</option>
              </select>
              @if($errors->has('status'))
              <p class="alert-danger">{{$errors->first('status')}}</p>
              @endif <br>
            </div>
          </div>
          <button type="submit" dusk="createMeeting" class="btn btn-primary btn-kanan" role="button" aria-disabled="true">Tambah Agenda Rapat</button>
          <button href="{{ route('meetingList') }}" class="btn btn-warning btn-kanan" role="button" aria-disabled="true">Kembali</button>

          <br><br>

        </div>
      </div>
    </div>
  </div>
</form>


<script>
  (function($) {
    jQuery.fn.select2_e = function() {
      $(this).each(function(n, element) {

        //тут превращаем select в input              
        var $element = $(element),
          choices = $element.find('option').map(function(n, e) {
            var $e = $(e);
            return {
              id: $e.val(),
              text: $e.text()
            };
          }),
          width = $element.width(),
          $input = $('<input>', {
            width: width
          });
        $element.hide().after($input);

        //превратили
        $input.select2({
          query: function(query) {
            var data = {},
              i;
            data.results = [];

            // подтставим то что искали
            if (query.term !== "") {
              data.results.push({
                id: query.term,
                text: query.term
              });
            }

            // добавим остальное
            for (i = 0; i < choices.length; i++) {
              if (choices[i].text.match(query.term) || choices[i].id.match(query.term)) data.results.push(choices[i]);
            }
            query.callback(data);
          }
        }).on('change', function() {
          var value = $input.val();
          $element.empty();
          $element.append($('<option>').val(value))
          $element.val(value).trigger('change');
        });;
        return $element;
      });
      return this;
    }
  })(jQuery);

  //пример использования
  jQuery(function($) {
    $("#usr1").datepicker({
      dateFormat: "yy-mm-dd",
      // beforeShowDay: beforeShowDayHandler,
      showOn: 'both',
      onClose: function(dateText, inst) {
        $(this).attr("disabled", false);
      },
      beforeShow: function(input, inst) {
        $(this).attr("disabled", true);
      }

    });

    console.log($('.testclass').select2_e().on('change', function() {
      alert(this.value)
    }));
  });

  $(function() {
    $('.dates #usr1').datepicker({
      'format': 'yy-mm-dd',
      'autoclose': true
    });
  });
</script>

@endsection