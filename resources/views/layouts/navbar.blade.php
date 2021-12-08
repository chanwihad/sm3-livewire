<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="logo-pro">
                <a href="index.html"><img class="main-logo" src="{{ URL::asset('assets/img/logo/logo.png') }}" alt="" /></a>
            </div>
        </div>
    </div>
</div>
<div class="header-advance-area">
    <div class="header-top-area">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="header-top-wraper">
                        <div class="row">
                            <div class="col-lg-1 col-md-0 col-sm-1 col-xs-12">
                                <div class="menu-switcher-pro">
                                    <button type="button" id="sidebarCollapse" class="btn bar-button-pro header-drl-controller-btn btn-info navbar-btn">
                                        <i class="educate-icon educate-nav"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="">
                                <div class="header-right-info">
                                    <ul class="nav navbar-nav mai-top-nav header-right-menu">
                                        <li class="nav-item">
                                            <a href="#" data-toggle="dropdown" role="button" aria-expanded="false" class="nav-link dropdown-toggle">
                                                <i class="fa fa-user"></i>
                                                <span class="admin-name">{{ \Auth::user()->name }}</span>
                                                <i class="fa fa-angle-down edu-icon edu-down-arrow"></i>
                                            </a>
                                            <ul role="menu" class="dropdown-header-top author-log dropdown-menu">
                                                <form method="POST" action="{{ route('logout') }}">
                                                    @csrf
                                                    <li><a href="{{ route('logout') }}" onclick="event.preventDefault();
                                                this.closest('form').submit();"><span class="edu-icon edu-locked author-log-ic"></span>Log Out</a>
                                                    </li>
                                                </form>
                                            </ul>

                                        </li>

                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Mobile Menu start -->
    <div class="mobile-menu-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="mobile-menu">
                        <nav id="dropdown">
                            <ul class="mobile-menu-nav">
                                <li><a data-toggle="collapse" data-target="#Charts" href="#">Dashboard<span class="admin-project-icon edu-icon edu-down-arrow"></span></a>
                                </li>
                                <li><a href="events.html">Agenda Rapat</a></li>
                                <li><a data-toggle="collapse" data-target="#demoevent" href="#">Riwayat Rapat<span class="admin-project-icon edu-icon edu-down-arrow"></span></a>
                                </li>
                                <li><a data-toggle="collapse" data-target="#Miscellaneousmob" href="#">Data Pegawai<span class="admin-project-icon edu-icon edu-down-arrow"></span></a>
                                </li>
                                <!-- <li><a data-toggle="collapse" data-target="#Chartsmob" href="#">Rekapitulasi <span class="admin-project-icon edu-icon edu-down-arrow"></span></a>
                                            <ul id="Chartsmob" class="collapse dropdown-header-top">
                                                <li><a href="bar-charts.html">Absensi</a>
                                                </li>
                                                <li><a href="line-charts.html">Notulensi</a>
                                            </ul>
                                        </li> -->
                                <li><a data-toggle="collapse" data-target="#demoevent" href="#">Akun Saya<span class="admin-project-icon edu-icon edu-down-arrow"></span></a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    <!-- Mobile Menu end -->