@php( $logout_url = View::getSection('logout_url') ?? config('adminlte.logout_url', 'logout') )
@php( $profile_url = View::getSection('profile_url') ?? config('adminlte.profile_url', 'logout') )

@if (config('adminlte.usermenu_profile_url', false))
    @php( $profile_url = Auth::user()->adminlte_profile_url() )
@endif

@if (config('adminlte.use_route_url', false))
    @php( $profile_url = $profile_url ? route($profile_url) : '' )
    @php( $logout_url = $logout_url ? route($logout_url) : '' )
@else
    @php( $profile_url = $profile_url ? url($profile_url) : '' )
    @php( $logout_url = $logout_url ? url($logout_url) : '' )
@endif

<li class="nav-item dropdown user-menu">

    {{-- User menu toggler --}}
    <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
        @if(config('adminlte.usermenu_image'))
            <img src="{{ Auth::user()->adminlte_image() }}"
                 class="user-image img-circle elevation-2"
                 alt="{{ Auth::user()->fullname }}">
        @endif
        <span @if(config('adminlte.usermenu_image')) class="d-none d-md-inline" @endif>
            {{ Auth::user()->fullname }}
        </span>
    </a>

    {{-- User menu dropdown --}}
    <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right p-0">

        {{-- User menu header --}}
        @if(!View::hasSection('usermenu_header') && config('adminlte.usermenu_header'))
            <li class="user-header bg-white text-center border-bottom @if(!config('adminlte.usermenu_image')) h-auto @endif">
                <div class="mt-3 mb-2">
                    @if(config('adminlte.usermenu_image'))
                        <img src="{{ Auth::user()->adminlte_image() }}"
                             class="img-circle elevation-2"
                             alt="{{ Auth::user()->fullname }}"
                             style="width:64px;height:64px;object-fit:cover;">
                    @endif
                </div>
                <p class="mt-0 mb-1 font-weight-bold">
                    {{ Auth::user()->fullname }}
                </p>
                @if(config('adminlte.usermenu_desc'))
                    <p class="mb-1">
                        <span class="badge badge-success text-uppercase small px-2 py-1">
                            {{ Auth::user()->adminlte_desc() }}
                        </span>
                    </p>
                @endif
                @if(method_exists(Auth::user(), 'getEmailForPasswordReset') || isset(Auth::user()->email))
                    <p class="mb-3 text-muted small">
                        {{ Auth::user()->email ?? Auth::user()->getEmailForPasswordReset() }}
                    </p>
                @endif
            </li>
        @else
            @yield('usermenu_header')
        @endif

        {{-- User menu body & configured links, styled as a vertical menu --}}
        <li class="user-body p-0">
            <div class="px-3 py-2 border-bottom d-flex align-items-center justify-content-between">
                <span class="text-muted small">{{ __('Status') }}</span>
                <span class="d-inline-flex align-items-center">
                    <span class="badge badge-success mr-2" style="width:10px;height:10px;border-radius:50%;padding:0;"></span>
                    <span class="text-success small font-weight-semibold">{{ __('Active') }}</span>
                </span>
            </div>

            @hasSection('usermenu_body')
                <div class="px-3 py-2 border-bottom">
                    @yield('usermenu_body')
                </div>
            @endif

            <div class="list-group list-group-flush">
                @if($profile_url)
                    <a href="{{ $profile_url }}" class="list-group-item list-group-item-action d-flex align-items-center">
                        <i class="fa fa-fw fa-user mr-2 text-muted"></i>
                        <span>{{ __('adminlte::menu.profile') }}</span>
                    </a>
                @endif

                {{-- Configured user menu links --}}
                @each('adminlte::partials.navbar.dropdown-item', $adminlte->menu("navbar-user"), 'item')
            </div>
        </li>

        {{-- User menu footer --}}
        <li class="user-footer border-top">
            <a class="btn btn-default btn-flat btn-block text-left"
               href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fa fa-fw fa-power-off text-red mr-2"></i>
                {{ __('adminlte::adminlte.log_out') }}
            </a>
            <form id="logout-form" action="{{ $logout_url }}" method="POST" style="display: none;">
                @if(config('adminlte.logout_method'))
                    {{ method_field(config('adminlte.logout_method')) }}
                @endif
                {{ csrf_field() }}
            </form>
        </li>

    </ul>

</li>
