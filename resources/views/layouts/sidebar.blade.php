<aside class="left-sidebar sidebar-dark" id="left-sidebar">
    <div id="sidebar" class="sidebar sidebar-with-footer">
        <!-- Aplication Brand -->
        <div class="app-brand">
            <a href="#">
                <img src="{{ Storage::url('img/logo.png') }}" alt="Mono">
            </a>
        </div>
        <!-- begin sidebar scrollbar -->
        <div class="sidebar-left" data-simplebar style="height: 100%;">
            <!-- sidebar menu -->
            <ul class="nav sidebar-inner" id="sidebar-menu">
                <li>
                    <a class="sidenav-item-link" href="{{ url('/beranda_admin') }}" id="dashboard">
                        <i class="mdi mdi-chart-line"></i>
                        <span class="nav-text">Dashboard</span>
                    </a>
                </li>
                <li class="section-title">
                    Data
                </li>
                <li class="has-sub">
                    <a class="sidenav-item-link" href="javascript:void(0)" data-toggle="collapse" data-target="#email"
                        aria-expanded="false" aria-controls="email">
                        <i class="mdi mdi-folder-plus-outline"></i>
                        <span class="nav-text">Data Diagnosis</span> <b class="caret"></b>
                    </a>
                    <ul class="collapse" id="email" data-parent="#sidebar-menu">
                        <div class="sub-menu">
                            <li>
                                <a class="sidenav-item-link" href="{{ route('penyakit.index') }}">
                                    <span class="nav-text">Data Penyakit</span>
                                </a>
                            </li>
                            <li>
                                <a class="sidenav-item-link" href="{{ route('gejala.index') }}">
                                    <span class="nav-text">Data Gejala</span>
                                </a>
                            </li>
                            <li>
                                <a class="sidenav-item-link" href="{{ route('bobot_admin.index') }}">
                                    <span class="nav-text">Data Bobot</span>
                                </a>
                            </li>
                        </div>
                    </ul>
                </li>
                <li class="has-sub">
                    <a class="sidenav-item-link" href="javascript:void(0)" data-toggle="collapse"
                        data-target="#konsultasi" aria-expanded="false" aria-controls="konsultasi">
                        <i class="mdi mdi-folder-search-outline"></i>
                        <span class="nav-text">Hasil Diagnosis</span><b class="caret"></b>
                    </a>
                    <ul class="collapse" id="konsultasi" data-parent="#sidebar-menu">
                        <div class="sub-menu">
                            <li>
                                <a class="sidenav-item-link" href="{{ route('konsultasi_admin.index') }}">
                                    <span class="nav-text">Data Konsultasi</span>
                                </a>
                            </li>
                        </div>
                    </ul>
                </li>
            </ul>
        </div>

        <div class="sidebar-footer">
            <div class="sidebar-footer-content">
                <ul class="d-flex">
                </ul>
            </div>
        </div>
    </div>
</aside>
