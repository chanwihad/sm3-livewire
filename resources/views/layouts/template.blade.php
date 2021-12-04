<!doctype html>
<html class="no-js" lang="en">

<!-- HEAD -->
@include('layouts.head')

<body>

    <!-- SIDEBAR -->
    @include('layouts.sidebar')

    <div class="all-content-wrapper">

        <!-- SIDEBAR -->
        @include('layouts.navbar')

        <!--MENU -->
        @yield('dashboard')
        
        @yield('manajemen-rapat')
        @yield('manajemen-tambah')
        @yield('manajemen-ubah')
        @yield('manajemen-detail')

        @yield('agenda-rapat')
        @yield('agenda-detail')

        @yield('data-pegawai')
        @yield('data-edit')

        @yield('akun-saya')
        @yield('akun-edit')

    </div>

    <!-- FOOTER -->
    @include('layouts.footer')

    <!-- SCRIPT -->
    @include('layouts.script')
</body>

</html>