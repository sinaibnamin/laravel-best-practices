<aside class="main-sidebar sidebar-dark-primary elevation-4">
    @include('admin/partials/sidebar/branding')
    <div class="sidebar">

        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                @php
                    $member_img_url = asset('/') . 'site_images/statics/user_dummy.jpg';
                @endphp

                <img src="{{ $member_img_url }}" class="img-circle elevation-2" alt="User Image">

            </div>
            <div class="info">
                <a href="javascript:void(0)" class="d-block">developer</a>
            </div>
        </div>

        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent" data-widget="treeview" role="menu"
                data-accordion="false">

                <li class="nav-item">
                    <a href="/developer_panel/sms/count/form" class="nav-link" data-active="sms-count">
                        <i class="nav-icon fa-solid fa-chart-pie-simple"></i>
                        <p>
                            Sms count
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/developer_panel/system-setting" class="nav-link" data-active="system-setting">
                        <i class="nav-icon fa-solid fa-chart-pie-simple"></i>
                        <p>
                            system setting
                        </p>
                    </a>
                </li>
              

            </ul>
        </nav>
    </div>
</aside>
