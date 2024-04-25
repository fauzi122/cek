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
        <?php
			$wsda="979a218e0632df".Auth::user()->username;
		    $djoid=sha1($wsda);
			echo" <a href='http://says.bsi.ac.id/authenx4-$djoid.js' target=_blank>"; 
			?>
                           
                            <i class="icon-log-out1"></i><span class="menu-text">S A Y S</span>
            
                        </a>	
                        {{--  <a href="{{ url('/profil') }}">
                            <i class="icon-account_circle"></i>
                            <span class="menu-text">Profil</span>
                        </a>  --}}

                     {{-- @can('panitiaujian') --}}
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
                        {{-- @endcan --}}

            </li>

            <li class="sidebar-dropdown">
                <a href="#">
                    <i class="icon-calendar1"></i>
                    <span class="menu-text">MBKM</span>
                </a>
                <div class="sidebar-submenu">
                    <ul>
                       
                        <li>
                            <a href="{{ url('/jadwal-mbkm') }}">Jadwal Mengajar MBKM</a>
                        </li>
                        <li>
                            <a href="{{ url('/rekap-mbkm') }}">Rekap Absen MBKM</a>
                        </li>
                        
                        <li>
                            <a href="{{ url('/modul-mbkm-dosen') }}">Modul MBKM</a>
                        </li>
                        @can('picmbkm.index') 
                           <li>
                            <a href="{{ url('/pt-mbkm') }}">PIC PKBN</a>
                        </li>
                        @endcan

                             {{--  @can('nilaipkbn.index')   --}}
                           <li>
                            <a href="{{ url('/nilai-pkbn') }}">Input Nilai PKBN</a>
                        </li>
                        {{--  @endcan  --}}

                        <!--li>
                            <a href="{{url('/rekap-mbkm')}}">Rekap MBKM</a>
                        </li-->
                    </ul>
                </div>
            </li>  

            @can('dosen_praktisi') 
       <li class="sidebar-dropdown">
                <a href="#">
                    <i class="icon-users"></i>
                    <span class="menu-text">Dosen Praktisi</span>
                </a>
                <div class="sidebar-submenu">
                    <ul>
                        <li>
                            <a href="{{ url('/mengajar-praktisi') }}">Jadwal Dosen</a>
                        </li>
                        <li>
                            <a href="{{ url('/rekap-ajar-praktisi') }}">Rekap Ajar Dosen</a>
                        </li>
                    
                        
                    </ul>
                </div>
            </li> 
              @endcan
            <li class="sidebar-dropdown">
                <a href="#">
                    <i class="icon-calendar1"></i>
                    <span class="menu-text">Mengajar</span>
                </a>
                <div class="sidebar-submenu">
                    <ul>
                       
                        <li>
                            <a href="{{url('/jadwal')}}">Jadwal Mengajar</a>
                        </li>
                        <li>
                            <a href="{{ url('/jadwal-pengganti') }}">Perkuliahan Pengganti</a>
                        </li>
                        <li>
                            <a href="{{ url('/jadwal-dosen-pengganti') }}">Jadwal Dosen Pengganti</a>
                        </li>
                        
                        <li>
                            <a href="{{url('/rekap-absen')}}">Rekap Absen</a>
                        </li>
                        <li>
                            <a href="{{ url('/lecturer/rekap') }}">Rekap Pengajaran </a>
                        </li>
                        
                          <li>
                            <a href="{{ url('/latihan') }}">Kuis </a>
                        </li>
                         <li>
                            <a href="{{ url('/list-class') }}">Rekap Kuis </a>
                        </li>
                        @can('latihan.index') 
                          <li>
                            <a href="{{ url('/mengawas-ujian') }}">Mengawas Ujian</a>
                        </li>
                        @endcan
                        {{--  <li>
                            <a href="{{ url('/riwayat-mengajar') }}">Riwayat Mengajar</a>
                        </li>  --}}
                    </ul>
                </div>
            </li>  

            {{--  toef  --}}
                        @can('toef') 
       <li class="sidebar-dropdown">
                <a href="#">
                    <i class="icon-check"></i>
                    <span class="menu-text">TOEFL</span>
                </a>
                <div class="sidebar-submenu">
                    <ul>
                    @can('menu.toef.jadwal.tes') 
                        <li>
                            <a href="{{ url('/toef') }}">Jadwal Tes</a>
                        </li>
                    @endcan
                     @can('menu.toef.rekap.tes') 
                          <li>
                            <a href="{{ url('/list-class-toef') }}">Rekap Tes </a>
                        </li>
                    @endcan
                     @can('menu.toef.data.mhs')
                        <li>
                            <a href="{{ url('/list-toef-mhs') }}">Data Mahasiswa</a>
                        </li>
                    @endcan
                        
                    </ul>
                </div>
            </li> 
              @endcan
            {{--  and toef  --}}
            @can('panitiaujian') 
            <!-- <li class="sidebar-dropdown">
                <a href="#">
                    <i class="icon-record_voice_over"></i>
                    <span class="menu-text">Panita Ujian</span>
                </a>
                <div class="sidebar-submenu">
                    <ul> 
                        <li>
                            <a href="{{url('/jadwal-ujian')}}">Jadwal Ujian</a>
                        </li>   
                    </ul>
                </div>
            </li> -->
            @endcan 
            <li class="sidebar-dropdown">
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
            </li>

            <li class="sidebar-dropdown">
                @can('baak.index')  
                <a href="#">
                    <i class="icon-folder_open"></i>
                    <span class="menu-text">BAAK Management</span>
                </a>
             
                <div class="sidebar-submenu">
                    <ul>
                       <li>
                            <a href="{{ url('/user-ujian') }}">Upload User Ujian</a>
                        </li>
                               @can('addakun.index') 
                        <li>
                            <a href="/lecturer-data">Data Dosen</a>
                        </li>
                         @endcan 
                        <li>
                            <a href="{{ url('/cek-kuliah-pengganti-baak') }}">Cek Kuliah Pengganti</a>
                        </li>
                        <li>
                            <a href="{{ url('/jadwal-dosen') }}">Dosen Pengganti</a>
                        </li>
                        @can('addakunmhs.index') 
                        <li>
                            <a href="{{ url('/std/users/baak') }}">Data Mahasiswa</a>
                        </li>
                        @endcan 
                        @can('temu_baak.index')  
                        <li>
                            <a href="{{ url('/pertemuan') }}">Upload Pertemuan</a>
                        </li>
                        @endcan 
                        @can('agamak_baak.index') 
                        <li>
                            <a href="{{ url('/agamakristen') }}">Upload Pertemuan Agama</a>
                        </li>
                        @endcan 

                        @can('krsagamak_baak.index') 
                        <li>
                            <a href="{{ url('/krs/agama-kristen') }}">Mhs Agama Kristen </a>
                        </li>
                        @endcan 

                        @can('krsmhs_baak.index') 
                        <li>
                            <a href="{{ url('/krs/mhs') }}">KRS Mahasiswa </a>
                        </li>
                        @endcan 

                         @can('permissions.index') 
                        <li>
                            <a href="{{ url('/set/holiday') }}">Setting Hari Libur </a>
                        </li>
                        @endcan
                        
                        @can('mbkm_baak.index') 
                        <li>
                            <a href="{{ url('/upload/jadwal-mbkm') }}">Jadwal MBKM </a>
                        </li>
                           <li>
                            <a href="{{ url('/ajar/dosen-mbkm') }}">Ajar Dosen PKBN </a>
                        </li>
                           <li>
                            <a href="{{ url('/absen/dosen-mbkm') }}">Absen Mhs PKBN ALL </a>
                        </li>
                          <li>
                            <a href="{{ url('/nilai/dosen-mbkm') }}">Nilai PKBN  </a>
                        </li>
                        <li>
                            <a href="{{ url('/nilai/all-mbkm') }}">Nilai PKBN ALL  </a>
                        </li>
                        
                        @endcan  

                    
                    </ul>
                </div>
                @endcan 
            </li>

            
            </li>
            <li class="sidebar-dropdown">
                @can('administrasi.index') 
                <a href="#">
                    <i class="icon-check-circle"></i>
                    <span class="menu-text">Administrasi</span>
                </a>
              
                <div class="sidebar-submenu">
                    <ul>
                        @can('inputmanual_adm.index') 
                        
                        <li>
                            <a href="{{ url('/input-manual') }}">Input Manual Mengajar</a>
                        </li>

                        <li>
                            <a href="{{ url('/rekap/day') }}">Rekap Ajar Dosen</a>
                        </li>
                       
                        @endcan
                        @can('kuliahganti_adm.index') 
                        <li>
                            <a href="{{ url('/cek-kuliah-pengganti') }}">Cek Kuliah Pengganti</a>
                        </li>
                        @endcan
                        @can('userdosen_adm.index') 
                        <li>
                            <a href="{{ url('/std/users') }}">Data Mahasiswa</a>
                        </li>
                        @endcan

                          @can('Data_Kelas.index') 
                        <li>
                            <a href="{{ url('/data/kelas') }}">Data Kelas</a>
                        </li>
                        @endcan

                        @can('userdosen_adm.index') 
                        <li>
                            <a href="{{ url('/lecturer/users') }}">Data Dosen</a>
                        </li>
                        @endcan
                        @can('jadwaldosen_adm.index') 
                        <li>
                            <a href="{{ url('lecturer/schedule') }}">Jadwal Dosen</a>
                        </li>
                        @endcan
                    </ul>
                </div>
                @endcan 
            </li>

            <li class="sidebar-dropdown">
                @can('btiadmin.index') 
                <a href="#">
                    <i class="icon-devices_other"></i>
                    <span class="menu-text">Admin BTI</span>
                </a>
              
                <div class="sidebar-submenu">
                    <ul>
                       @can('umum.index') 
                        <li>
                            <a href="/announce">Upload Pengumuman</a>
                        </li>
                        @endcan 
                         {{--  @can('btiadmin.index') 
                        <li>
                            <a href="/account-staff">Tambah User Staff</a>
                        </li>
                         @endcan   --}}
                           @can('addakun.index') 
                        <li>
                            <a href="/lecturer-data">Data Dosen</a>
                        </li>
                        <li>
                            <a href="/log">Log Aktivitas</a>
                        </li>
                         @endcan 

                    
                    </ul>
                </div>
                @endcan 
            </li>
            <li class="sidebar-dropdown">
                @can('ip_ruang.index') 
                <a href="#">
                    <i class="icon-check"></i>
                    <span class="menu-text"> TS</span>
                </a>
              
                <div class="sidebar-submenu">
                    <ul>
                       @can('ip_ruang.index') 
                        <li>
                            <a href="/ip-ruang">IP Ruang</a>
                        </li>
                        @endcan 
                         

                    
                    </ul>
                </div>
                @endcan 
            </li>

            <li class="sidebar">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-dropdown-link :href="route('logout')"
                                     onclick="event.preventDefault();
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