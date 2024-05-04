<div class="sidebar-content">

    <!-- sidebar menu start -->
    <div class="sidebar-menu">
        <ul>
            <li class="header-menu">Menu</li>
            <li class="sidebar">
                <a href="{{ url('/dashboard') }}">
                    <i class="icon-devices_other"></i>
                    <span class="menu-text">Dashboard</span>

                </a>
                  
		    </a>

                         <a href="{{ url('/master-soal') }}">
                            <i class="icon-folder"></i>
                            <span class="menu-text">Master Soal</span>
                        </a>

                        @can('examschedule.index') 
                        <a href="{{ url('/dashboard-ujian') }}"target="_blank">
                            <i class="icon-bookmark1"></i>
                            <span class="menu-text">Panitia Ujian</span>
                        </a>
                        @endcan 
                       

            </li>


            {{-- <li class="sidebar-dropdown">
                @can('users.index') 
                <a href="#">
                    <i class="icon-settings1"></i>
                    <span class="menu-text">User Management</span>
                </a>
               
                <div class="sidebar-submenu">
                    <ul>
                        @can('users.index') 
                        <li>
                            <a href="{{ url('/user') }}"> Akun Staff</a>
                        </li>
                       
                        @endcan 
                         @can('permissions.index') 
                        <li>
                            <a href="{{ url('/permission') }}">Permission</a>
                        </li>
                         @endcan 
                         @can('roles.index') 
                        <li>
                            <a href="{{ url('/role') }}">Account Setting</a>
                        </li>
                        @endcan 
                    </ul>
                </div>
                @endcan 
            </li> --}}
            <li class="sidebar">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-dropdown-link :href="route('logout')"
                                     onclick="event.preventDefault();
                                              this.closest('form').submit();">
                        <i class="icon-log-out1"></i> <!-- Ikon logout ditambahkan di sini -->
                        
                        <span class="menu-text">{{ __('Kembali ke Mybest') }}</span>
                    </x-dropdown-link>
                </form>
            </li>
            
        </ul>

           
    </div>
    <!-- sidebar menu end -->

</div>