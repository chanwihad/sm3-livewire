<!-- Start Left menu area -->
<div class="left-sidebar-pro">
    <nav id="sidebar">
        <div class="sidebar-header">
            <a href="index.html"><img class="main-logo" src="{{ URL::asset('assets/img/logo/logo.png') }}" alt="" /></a>
            <strong><a href="index.html"><img src="{{ URL::asset('assets/img/logo/logosn.png') }}" alt="" /></a></strong>
        </div>
        <div class="left-custom-menu-adp-wrap comment-scrollbar">
            <nav class="sidebar-nav left-sidebar-menu-pro">
                <ul class="metismenu" id="menu1">
                    <li>
                        <a href="{{ route('dashboard') }}" aria-expanded="false"><span class="educate-icon educate-home icon-wrap sub-icon-mg" aria-hidden="true"></span> <span class="mini-click-non">Dashboard</span></a>
                    </li>
                    <!-- <li>
                        <a class="has-arrow" href="" aria-expanded="false"><span class="educate-icon educate-event icon-wrap"></span> <span class="mini-click-non">Agenda Rapat</span></a>
                        <ul class="submenu-angle" aria-expanded="false">
                            <li><a href=""><span class="mini-sub-pro">Riwayat</span></a></li>
                            <li><a href=""><span class="mini-sub-pro">Manajemen</span></a></li>
                        </ul>
                    </li> -->
                    <li>
                        <a href="{{ route('agendaList') }}" aria-expanded="false"><span class="educate-icon educate-event icon-wrap"></span> <span class="mini-click-non">Agenda Rapat</span></a>
                    </li>
                    <li>
                        <a href="{{ route('meetingList') }}" aria-expanded="false"><span class="educate-icon educate-library icon-wrap"></span> <span class="mini-click-non">Manajemen Rapat</span></a>
                    </li>
                    <li>
                        <a href="{{ route('userList') }}" aria-expanded="false"><span class="educate-icon educate-professor icon-wrap"></span> <span class="mini-click-non">Data Pegawai</span></a>
                    </li>
                    <li>
                        <a href="{{ route('profileDetail') }}" aria-expanded="false"><span class="educate-icon educate-student icon-wrap"></span> <span class="mini-click-non">Akun Saya</span></a>
                    </li>

                </ul>
            </nav>
        </div>
    </nav>
</div>
<!-- End Left menu area -->