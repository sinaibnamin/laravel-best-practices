<aside class="main-sidebar sidebar-dark-primary elevation-4">
    @include('admin/partials/sidebar/branding')
    <div class="sidebar">

        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                @php
                    use App\Models\Trainer;
                    $trainer = Trainer::where('phone_number', get_user_id())->first();

                    $trainer_img_url = asset('/') . 'site_images/statics/super_user_dummy.jpg';
                    if ($trainer->image) {
                        $trainer_img_url = asset('/') . 'site_images/uploaded/trainer_images/' . $trainer->image;
                    }
                @endphp


                <img src="{{ $trainer_img_url }}" class="img-circle elevation-2" alt="User Image">

            </div>
            <div class="info">
                <a href="javascript:void(0)" class="d-block">{{ $trainer->full_name }}</a>
            </div>
        </div>

        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent" data-widget="treeview" role="menu"
                data-accordion="false">

                <li class="nav-item">
                    <a href="/trainer_panel" class="nav-link" data-active="dashboard">
                        <i class="nav-icon fa-solid fa-chart-pie-simple"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>



                <li class="nav-item">
                    <a href="#" class="nav-link" data-active="instruction">
                        <i class="nav-icon fa-solid fa-pen-nib"></i>
                        <p>
                            Instructions
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="/trainer_panel/instruction/create" class="nav-link"
                                data-active="instruction-create">
                                <i class="nav-icon fa-sharp fa-thin fa-arrow-right"></i>
                                <p>Create</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/trainer_panel/instruction/list" class="nav-link" data-active="instruction-list">
                                <i class="nav-icon fa-sharp fa-thin fa-arrow-right"></i>
                                <p>List</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link" data-active="setting">
                        <i class="nav-icon fa-solid fa-gear"></i>
                        <p>
                            Settings
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="/trainer_panel/profile" class="nav-link" data-active="setting-profile">
                                <i class="nav-icon fa-sharp fa-thin fa-arrow-right"></i>
                                <p>Profile</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/trainer_panel/changepassword" class="nav-link"
                                data-active="setting-changepassword">
                                <i class="nav-icon fa-sharp fa-thin fa-arrow-right"></i>
                                <p>Change Password</p>
                            </a>
                        </li>
                    </ul>
                </li>


            </ul>
        </nav>
    </div>
</aside>
