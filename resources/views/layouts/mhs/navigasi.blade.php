<div class="sidebar-content">

    <!-- sidebar menu start -->
    <div class="sidebar-menu">
        <ul>
            <li class="header-menu">Menu</li>
            <li class="sidebar">
                <a href="{{ url('user/dashboard') }}">
                    <i class="icon-home"></i>
                    <span class="menu-text">Dashboard</span>
                </a>
                
        	 
                <a href="{{ url('/profile') }}">
                    <i class="icon-account_circle"></i>
                    <span class="menu-text">Profil</span>
                </a>
                <a href="{{ route('Ujian.redirect') }}">
                    <i class="icon-account_circle"></i>
                    <span class="menu-text">Ujian</span>
                </a>

            </li>

            <li class="sidebar-dropdown">
                <a href="#">
                    <i class="icon-calendar1"></i>
                    <span class="menu-text">MBKM</span>
                </a>
                <div class="sidebar-submenu">
                    <ul>
                        <li>
                            <a href="{{ url('/modul-mbkm') }}">Modul MBKM</a>
                        </li>

                        <!--li>
                            <a href="{{url('/rekap-mbkm')}}">Rekap MBKM</a>
                        </li-->
                    </ul>
                </div>
            </li>

            <li class="sidebar-dropdown">
                <a href="#">
                    <i class="icon-calendar"></i>
                    <span class="menu-text">Jadwal </span>
                </a>
                <div class="sidebar-submenu">
                    <ul>

                        <li>
                            <a href="{{url('/sch')}}">Jadwal Kuliah</a>
                        </li>
                        <li>
                            <a href="{{url('/kuliah-pengganti')}}">Kuliah Pengganti</a>
                        </li>
                        <li>
                            <a href="/exercise">Kuis</a>
                        </li>



                    </ul>
                </div>
            </li>
            <li class="sidebar">
                <a href="{{ url('toefl') }}">
                    <i class="icon-calendar"></i><span class="menu-text">TOEFL</span>
                </a>
            </li>

            <li class="sidebar">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-dropdown-link :href="route('logout')" onclick="event.preventDefault();
                                              this.closest('form').submit();">
                        <i class="icon-log-out1"></i> <!-- Ikon logout ditambahkan di sini -->

                        <span class="menu-text">{{ __('Log Out') }}</span>
                    </x-dropdown-link>
                </form>
            </li>

        </ul>
    </div>
    <!-- sidebar menu end -->

</div>