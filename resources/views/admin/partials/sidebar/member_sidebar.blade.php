<aside class="main-sidebar sidebar-dark-primary elevation-4">
    @include('admin/partials/sidebar/branding')
    <div class="sidebar">

        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                @php
                    use App\Models\Member;
                    use App\Models\ManagementSiteSettings;
                    $member = Member::where('phone_number', get_user_id())->first();
                    $member_img_url = asset('/') . 'site_images/statics/user_dummy.jpg';
                    if ($member->image) {
                        $member_img_url = asset('/') . 'site_images/uploaded/member_images/' . $member->image;
                    }

                    // Check if online payment enabled
                    $online_payment_enable =
                        ManagementSiteSettings::select('online_payment_enable')->where('id', 1)->first()
                            ->online_payment_enable ?? 'false';

                @endphp

                <img src="{{ $member_img_url }}" class="img-circle elevation-2" alt="User Image">

            </div>
            <div class="info">
                <a href="javascript:void(0)" class="d-block">{{ $member->full_name }}</a>
            </div>
        </div>

        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent" data-widget="treeview" role="menu"
                data-accordion="false">

                <li class="nav-item">
                    <a href="/member_panel" class="nav-link" data-active="dashboard">
                        <i class="nav-icon fa-solid fa-chart-pie-simple"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/member_panel/trainer_instructions" class="nav-link" data-active="trainer-instructions">
                        <i class="nav-icon fa-solid fa-pen-nib"></i>
                        <p>
                            Trainer instructions
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/member_panel/payment_history" class="nav-link" data-active="payment-history">

                        <i class="nav-icon fa-solid fa-sack-dollar"></i>
                        <p>
                            Payment History
                        </p>
                    </a>
                </li>

                @if ($online_payment_enable == 'true')
                    <li class="nav-item">
                        <a href="/member_panel/pay/form" class="nav-link" data-active="pay-now">
                            <i class="nav-icon fa-solid fa-sack-dollar"></i>
                            <p>
                                Pay now
                            </p>
                        </a>
                    </li>
                @endif




                <li class="nav-item">
                    <a href="/member_panel/packages" class="nav-link" data-active="package">
                        <i class="nav-icon fa-solid fa-messages-dollar"></i>
                        <p>
                            Packages
                        </p>
                    </a>
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
                            <a href="/member_panel/profile" class="nav-link" data-active="setting-profile">

                                <i class="nav-icon fa-sharp fa-thin fa-arrow-right"></i>
                                <p>Profile</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/member_panel/changepassword" class="nav-link"
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
