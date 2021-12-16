@extends('layouts.template')

@section('title', 'Dashboard | Admin')

@section('manajemen-detail')

<div class="margin-judul">
    <h1>Detail Agenda Rapat</h1>
    <ol class="breadcrumb" style="background: none; padding: 10px 0px;">
        <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
        <li><a href="{{ route('agendaList') }}">@if($info == 'Meeting') Manajemen @elseif($info == 'Agenda') Agenda @endif Rapat</a></li>
        <li class="active">Detail</li>
    </ol>
</div>

<div class="sm3-container">
    <div class="row">
        <div class="col-md-12">
            <div class="sm3-card">

                <nav class="db-flex">
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav">

                            <li class="active" style="margin-right: 40px;">
                                <a class="nav-link open-tab" href="#" data-tab='a'>Detail Agenda Rapat</a>
                            </li>
                            <li style="margin-right: 40px;">
                                <a class="nav-link open-tab" href="#" data-tab='b'>Notulensi Rapat</a>
                            </li>
                            <li style="margin-right: 40px;">
                                <a class="nav-link open-tab" href="#" data-tab='c'>Daftar Hadir Peserta Rapat</a>
                            </li>
                        </ul>
                    </div>
                    <div class="icon-card2">
                        <i class="fa fa-angle-double-right"></i>
                    </div>
                </nav>
            </div>
        </div>
    </div>
</div>

<!-- =================DETAIL RAPAT================== -->
<div class="sm3-container tab" data-tab='a'>
    <div class="row">
        <div class="col-md-12">
            <div class="sm3-card">
                <h1>Detail Agenda Rapat</h1> <br>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">Agenda Rapat</th>
                                <th scope="col">Jadwal</th>
                                <th scope="col">Status</th>
                                @if($info == 'Agenda')
                                <th scope="col">Presensi</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <b>Judul Rapat</b><br>
                                    {{$detail->title}}<br>
                                    <br>
                                    <b>Peserta</b><br>
                                    {{$detail->participant}}<br>
                                </td>
                                <td>
                                    <div class="row db-flex" style="column-gap: 0px;">
                                        <a class="btn btn-secondary fa fa-calendar" href=""></a>
                                        <p style="margin-bottom: 0px;">{{$detail->date}}</p>
                                    </div>
                                    <div class="row db-flex" style="column-gap: 0px;">
                                        <a class="btn btn-secondary fa fa-clock" href=""></a>
                                        <p style="margin-bottom: 0px;">{{$detail->time}}</p>
                                    </div>
                                    <div class="row db-flex" style="column-gap: 0px;">
                                        <a class="btn btn-secondary fa fa-info-circle" href=""></a>
                                        <p style="margin-bottom: 0px;">{{$detail->place}}</p>
                                    </div>
                                </td>
                                <td>
                                    <a class="btn btn-info">
                                        @if($detail->isBelumDibuka())
                                        Belum Dimulai
                                        @elseif($detail->isBerlangsung())
                                        Berlangsung
                                        @elseif($detail->isSelesai())
                                        Selesai
                                        @elseif($detail->isTutup())
                                        Tutup
                                        @endif
                                    </a>
                                </td>
                                @if($info == 'Agenda')
                                <td>
                                    @if($detail->attendance_id)
                                    <i> {{ $detail->tampilAbsen() }} </i>
                                    @elseif($detail->isBelumDibuka())
                                    Belum Dimulai
                                    @elseif($detail->isBerlangsung())
                                    <form action="{{route('absenCreate')}}" method="get">
                                        <input type="hidden" name="id" id="id" value="{{$detail->id}}" />
                                        <button class="btn btn-primary" id="status" name="status" value="1" type="submit">Hadir</button>
                                        <button class="btn btn-danger" id="status" name="status" value="2" type="submit">Sakit</button>
                                        <button class="btn btn-warning" id="status" name="status" value="3" type="submit">Ijin</button>
                                    </form>
                                    @else
                                    Alpha
                                    @endif
                                </td>
                                @endif
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="card card-desc">
                    <h5>Deskripsi : </h5>
                    <p style="margin: 0px;">{{$detail->description}}</p>
                </div> <br>

                <!-- Button share muncul jika aktor adalah admin divisi / administrator -->

                <div class="db-flex btn-kanan" style="column-gap: 0px;">
                    <span class="input-group-addon span-share"><i class="fab fa-whatsapp"></i></span>
                    <a class="btn btn-primary btn-share" href="">WhatsApp</a>
                </div>
                <div class="db-flex btn-kanan" style="column-gap: 0px;">
                    <span class="input-group-addon span-share"><i class="far fa-envelope"></i></span>
                    <a class="btn btn-primary btn-share" href="{{ route('notificationGmail', $detail->id) }}">E-Mail</a>
                </div>
                <p class="btn-kanan" style="padding: 10px;">Bagikan Via</p><br> <br>
            </div>
        </div>
    </div>
</div>

<!-- =================NOTULENSI RAPAT================== -->
<div class="sm3-container tab" data-tab='b' style="display:none;">
    <div class="row">
        <div class="col-md-12">
            <div class="sm3-card">
                <div class="db-flex">
                    <h1>Notulensi Agenda Rapat</h1> <br>
                </div> <br>

                @if($info == 'Meeting')
                <form action="{{route('noteSave')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="meeting_id" id="meeting_id" value="{{$detail->id}}" />
                    <textarea id="editor2" name="notes" value="@isset($notulensi) {{ $notulensi->notes }} @endisset"> @isset($notulensi) {!! old("notes",$notulensi->notes) !!} @endisset</textarea> <br>
                    @if($errors->has('notes'))
                    <p class="alert-danger">{{$errors->first('notes')}}</p><br>
                    @endif
                    <label for="documentation" class="form-label">Masukkan Dokumentasi</label>
                    <input class="form-control" type="file" id="documentation" name="documentation"> <br>
                    @if($errors->has('documentation'))
                    <p class="alert-danger">{{$errors->first('documentation')}}</p><br>
                    @endif
                    <div class="db-flex" style="column-gap: 0px; justify-content: right;">
                        <span class="input-group-addon span-share"><i class="fa fa-save"></i></span>
                        <button type="submit" class="btn btn-primary btn-share" role="button" aria-disabled="true">Simpan Notulensi</button> <br>
                    </div>
                </form> <br>
                @endif

                @if($info == 'Agenda')
                <textarea id="editor1" name="notes" value="@isset($notulensi) {{ $notulensi->notes }} @endisset"> @isset($notulensi) {!! old("notes",$notulensi->notes) !!} @endisset</textarea> <br>
                @endif

                <div class="card card-desc">
                    <h5>Dokumentasi Foto : </h5>
                    <img class="card-img-top" @isset($notulensi->documentation) src="storage/{{ $notulensi->documentation }}" @endisset>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- =================DAFTAR HADIR RAPAT================== -->
<div class="sm3-container tab" data-tab='c' style="display:none;">
    <div class="row">
        <div class="col-md-12">
            <div class="sm3-card">
                <div class="db-flex">
                    <h1>Daftar Hadir Peserta Rapat</h1> <br>

                </div> <br>

                <div class="table-responsive">
                    <table class="table table-bordered" id="daftar-absen">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Nama Lengkap</th>
                                <th scope="col">Divisi</th>
                                <th scope="col">Jabatan</th>
                                <th scope="col">Tanggal</th>
                                <th scope="col">Jam Presensi</th>
                                <th scope="col">Status</th>
                                @if($info == 'Meeting')
                                <th scope="col">Aksi</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($peserta as $pesertas)
                            <tr>
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td>{{ $pesertas->name }}</td>
                                <td>{{ $pesertas->division }}</td>
                                <td>{{ $pesertas->position }}</td>
                                <td>{{ $pesertas->tampilTanggal() }}</td>
                                <td>{{ $pesertas->tampilJam() }}</td>
                                <td>
                                    <a class="btn btn-primary">{{ $pesertas->tampilAbsen() }}</a>
                                </td>
                                @if($info == 'Meeting')
                                <td>
                                    <form action="{{route('absenUpdate')}}" method="get">
                                        <input type="hidden" name="id" id="id" value="{{ $pesertas->attendances_id }}" />
                                        <input type="hidden" name="user_id" id="user_id" value="{{ $pesertas->id }}" />
                                        <input type="hidden" name="meeting_id" id="meeting_id" value="{{ $detail->id }}" />
                                        {{ csrf_field() }}
                                        <!-- Button trigger modal -->
                                        <button type="submit" class="btn btn-warning fa fa-edit" data-toggle="modal" data-target="#exampleModalCenter"></button>

                                    </form>
                                </td>
                                @endif
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
    CKEDITOR.replace('editor1', {
        readOnly: true
    });
    // CKEDITOR.replace('editor2');

    CKEDITOR.replace('editor2', {
        extraPlugins: 'image2,uploadimage',

        toolbar: [{
                name: 'clipboard',
                items: ['Undo', 'Redo']
            },
            {
                name: 'styles',
                items: ['Styles', 'Format']
            },
            {
                name: 'basicstyles',
                items: ['Bold', 'Italic', 'Strike', '-', 'RemoveFormat']
            },
            {
                name: 'paragraph',
                items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote']
            },
            {
                name: 'links',
                items: ['Link', 'Unlink']
            },
            {
                name: 'insert',
                items: ['Image', 'Table']
            },
            {
                name: 'tools',
                items: ['Maximize']
            }
        ],

        // Configure your file manager integration. This example uses CKFinder 3 for PHP.
        filebrowserBrowseUrl: '/apps/ckfinder/3.4.5/ckfinder.html',
        filebrowserImageBrowseUrl: '/apps/ckfinder/3.4.5/ckfinder.html?type=Images',
        filebrowserUploadUrl: '/apps/ckfinder/3.4.5/core/connector/php/connector.php?command=QuickUpload&type=Files',
        filebrowserImageUploadUrl: '/apps/ckfinder/3.4.5/core/connector/php/connector.php?command=QuickUpload&type=Images',

        // Upload dropped or pasted images to the CKFinder connector (note that the response type is set to JSON).
        uploadUrl: '/apps/ckfinder/3.4.5/core/connector/php/connector.php?command=QuickUpload&type=Files&responseType=json',

        // Reduce the list of block elements listed in the Format drop-down to the most commonly used.
        format_tags: 'p;h1;h2;h3;pre',
        // Simplify the Image and Link dialog windows. The "Advanced" tab is not needed in most cases.
        removeDialogTabs: 'image:advanced;link:advanced',

        height: 450,
        removeButtons: 'PasteFromWord'
    });

    $(document).ready(function() {
        $('#daftar-absen').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'excel', 'pdf', 'print'
            ]
        });
    });


    $(function() {
        // When an open tab item from your menu is clicked
        $(".open-tab").click(function() {
            // Hide any of the content tabs
            $(".tab").hide();
            // Show your active tab (read from your data attribute)
            $('[data-tab ="' + $(this).data('tab') + '"]').show();
            // Optional: Highlight the selected tab
            $('li.active').removeClass('active');
            $(this).closest('li').addClass('active');
        });
    });
</script>

@endsection