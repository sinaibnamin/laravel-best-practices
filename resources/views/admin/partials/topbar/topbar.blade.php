<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="javascript:void(0)" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            @php
                use App\Models\ManagementSiteSettings;
                $system_name = ManagementSiteSettings::select('system_name')->where('id', 1)->first()->system_name ?? 'Gymnasuim';
                $system_name .= ' Management System';
            @endphp
            <a href="javascript:void(0)" class="nav-link">{{$system_name}}</a>
        </li>
    </ul>
    <ul class="navbar-nav ml-auto">
        <li class="nav-item">
            <a class="btn text-secondary text-bold" href="javascript:void(0)">

                @if (get_user_role() == 'admin')
                    Admin panel
                @endif
                @if (get_user_role() == 'operator')
                    Operator panel
                @endif
                @if (get_user_role() == 'member')
                    Member panel
                @endif
                @if (get_user_role() == 'trainer')
                    Trainer panel
                @endif


            </a>
        </li>
        <li class="nav-item d-flex align-items-center">
            <a class="btn btn-sm btn-danger color-white" href="{{ url('/logout') }}">
                <i class="fa-solid fa-power-off"></i>
                Logout
            </a>
        </li>


    </ul>
</nav>
