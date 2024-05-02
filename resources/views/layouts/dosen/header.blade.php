<header class="header">
    <div class="toggle-btns">
        <a id="toggle-sidebar" href="#">
            <i class="icon-list"></i>
        </a>
        <a id="pin-sidebar" href="#">
            <i class="icon-list"></i>
        </a>
    </div>
    <div class="header-items">
        <!-- Custom search start -->
       
        <!-- Custom search end -->

        <!-- Header actions start -->
        <ul class="header-actions">
            
           
            <li class="dropdown">
                <a href="#" id="userSettings" class="user-settings" data-toggle="dropdown" aria-haspopup="true">
                    <span class="user-name">{{ Auth::user()->username }}</span>
                    <span class="avatar"><i class="icon-user"></i><span class="status busy"></span></span>
                </a>
                {{-- <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userSettings">
                    <div class="header-profile-actions">
                        <div class="header-user-profile">
                         
                        </div>

                        <a href="{{ url('/profile') }}"><i class="icon-settings1"></i> Account Settings</a>

                        
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                                 onclick="event.preventDefault();
                                                          this.closest('form').submit();">
                                    <i class="icon-log-out1"></i> <!-- Ikon logout ditambahkan di sini -->
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>

                            
                        
                    </div>
                </div> --}}
            </li>
        </ul>						
        <!-- Header actions end -->
    </div>
</header>