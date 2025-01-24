<aside class="main-sidebar sidebar-dark-primary elevation-4">
    @include('admin/partials/sidebar/branding')
    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset('/') }}site_images/statics/super_admin_dummy.jpg" class="img-circle elevation-2"
                    alt="User Image">
            </div>
            <div class="info">
                <a href="javascript:void(0)" class="d-block">{{ get_user_name() }}</a>
            </div>
        </div>

        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent" data-widget="treeview" role="menu"
                data-accordion="false">

                <li class="nav-item">
                    <a href="/admin_panel" class="nav-link" data-active="dashboard">
                        <i class="nav-icon fa-solid fa-chart-pie-simple"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>

                <li class="nav-header">MEMBER</li>

                <li class="nav-item">
                    <a href="#" class="nav-link" data-active="member">
                        <i class="nav-icon fa-solid fa-people-simple"></i>
                        <p>
                            Members
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="/admin_panel/member/create" class="nav-link" data-active="member-create">
                                <i class="nav-icon fa-sharp fa-thin fa-arrow-right"></i>
                                <p>Create</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/admin_panel/member/list" class="nav-link" data-active="member-list">
                                <i class="nav-icon fa-sharp fa-thin fa-arrow-right"></i>
                                <p>List</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/admin_panel/member/archivelist" class="nav-link" data-active="member-archivelist">
                                <i class="nav-icon fa-sharp fa-thin fa-arrow-right"></i>
                                <p>Archive</p>
                            </a>
                        </li>
                    </ul>
                </li>



                <li class="nav-item">
                    <a href="#" class="nav-link" data-active="member_attendance">

                        <i class="fa-sharp fa-solid fa-table nav-icon"></i>
                        <p>
                            Member Attendances
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="/admin_panel/member_attendance/monthly_report" class="nav-link"
                                data-active="member_attendance-monthly_report">
                                <i class="nav-icon fa-sharp fa-thin fa-arrow-right"></i>
                                <p>Monthly Report</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/admin_panel/member_attendance/daily_track" class="nav-link"
                                data-active="member_attendance-list">
                                <i class="nav-icon fa-sharp fa-thin fa-arrow-right"></i>
                                <p>Daily Track</p>
                            </a>
                        </li>

                    </ul>
                </li>



                <li class="nav-header">TRAINER</li>


                <li class="nav-item">
                    <a href="#" class="nav-link" data-active="trainer">

                        <i class="nav-icon fa-solid fa-person-chalkboard"></i>
                        <p>
                            Trainers
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="/admin_panel/trainer/create" class="nav-link" data-active="trainer-create">
                                <i class="nav-icon fa-sharp fa-thin fa-arrow-right"></i>
                                <p>Create</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/admin_panel/trainer/list" class="nav-link" data-active="trainer-list">
                                <i class="nav-icon fa-sharp fa-thin fa-arrow-right"></i>
                                <p>List</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/admin_panel/trainer/trashlist" class="nav-link" data-active="trainer-trashlist">
                                <i class="nav-icon fa-sharp fa-thin fa-arrow-right"></i>
                                <p>Trash</p>
                            </a>
                        </li>

                    </ul>
                </li>




                <li class="nav-item">
                    <a href="#" class="nav-link" data-active="instruction">

                        <i class="nav-icon fa-solid fa-pen-nib"></i>
                        <p>
                            Trainer Instructions
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">

                        @if ($get_user_role == 'admin')
                            <li class="nav-item">
                                <a href="/admin_panel/instruction/create" class="nav-link"
                                    data-active="instruction-create">
                                    <i class="nav-icon fa-sharp fa-thin fa-arrow-right"></i>
                                    <p>Create</p>
                                </a>
                            </li>
                        @endif


                        <li class="nav-item">
                            <a href="/admin_panel/instruction/list" class="nav-link" data-active="instruction-list">
                                <i class="nav-icon fa-sharp fa-thin fa-arrow-right"></i>
                                <p>List</p>
                            </a>
                        </li>



                    </ul>
                </li>







                <li class="nav-header">PAYMENT</li>


                <li class="nav-item">
                    <a href="#" class="nav-link" data-active="package">

                        <i class="nav-icon fa-solid fa-messages-dollar"></i>
                        <p>
                            Packages
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @if ($get_user_role == 'admin')
                            <li class="nav-item">
                                <a href="/admin_panel/package/create" class="nav-link" data-active="package-create">
                                    <i class="nav-icon fa-sharp fa-thin fa-arrow-right"></i>
                                    <p>Create</p>
                                </a>
                            </li>
                        @endif

                        <li class="nav-item">
                            <a href="/admin_panel/package/list" class="nav-link" data-active="package-list">
                                <i class="nav-icon fa-sharp fa-thin fa-arrow-right"></i>
                                <p>List</p>
                            </a>
                        </li>

                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link" data-active="payment">
                        <i class="nav-icon fa-solid fa-sack-dollar"></i>
                        <p>
                            Payments
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="/admin_panel/payment/create" class="nav-link" data-active="payment-create">
                                <i class="nav-icon fa-sharp fa-thin fa-arrow-right"></i>
                                <p>Create</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/admin_panel/payment/list" class="nav-link" data-active="payment-list">
                                <i class="nav-icon fa-sharp fa-thin fa-arrow-right"></i>
                                <p>List</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/admin_panel/payment/fail" class="nav-link" data-active="payment-fail">
                                <i class="nav-icon fa-sharp fa-thin fa-arrow-right"></i>
                                <p>Failed payments</p>
                            </a>
                        </li>

                    </ul>
                </li>





                <li class="nav-header">EXPENSE</li>


                <li class="nav-item">
                    <a href="#" class="nav-link" data-active="expense_type">

                        <i class="nav-icon fa-solid fa-messages-dollar"></i>
                        <p>
                            Expense types
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="/admin_panel/expense_type/create" class="nav-link"
                                data-active="expense_type-create">
                                <i class="nav-icon fa-sharp fa-thin fa-arrow-right"></i>
                                <p>Create</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/admin_panel/expense_type/list" class="nav-link"
                                data-active="expense_type-list">
                                <i class="nav-icon fa-sharp fa-thin fa-arrow-right"></i>
                                <p>List</p>
                            </a>
                        </li>

                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link" data-active="expense">
                        <i class="nav-icon fa-solid fa-sack-dollar"></i>
                        <p>
                            Expenses
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="/admin_panel/expense/create" class="nav-link" data-active="expense-create">
                                <i class="nav-icon fa-sharp fa-thin fa-arrow-right"></i>
                                <p>Create</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/admin_panel/expense/list" class="nav-link" data-active="expense-list">
                                <i class="nav-icon fa-sharp fa-thin fa-arrow-right"></i>
                                <p>List</p>
                            </a>
                        </li>

                    </ul>
                </li>

                <li class="nav-header">OTHERS</li>

                <li class="nav-item">
                    <a href="#" class="nav-link" data-active="announcement">

                        <i class="nav-icon fa-sharp fa-solid fa-bullhorn"></i>
                        <p>
                            Annouuncement
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="/admin_panel/announcement/create" class="nav-link"
                                data-active="announcement-create">
                                <i class="nav-icon fa-sharp fa-thin fa-arrow-right"></i>
                                <p>Create</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/admin_panel/announcement/list" class="nav-link"
                                data-active="announcement-list">
                                <i class="nav-icon fa-sharp fa-thin fa-arrow-right"></i>
                                <p>List</p>
                            </a>
                        </li>

                    </ul>
                </li>

                <li class="nav-item">
                    <a href="/admin_panel/setting/system_schedule" class="nav-link" data-active="gym_schedule">
                        <i class="nav-icon fa-solid fa-calendar-lines-pen"></i>
                        <p>
                            Gym Schedule
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
                            <a href="/admin_panel/setting/changepassword" class="nav-link"
                                data-active="setting-changepassword">
                                <i class="nav-icon fa-sharp fa-thin fa-arrow-right"></i>
                                <p>Change Password</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/admin_panel/setting/system_info" class="nav-link"
                                data-active="setting-system_info">
                                <i class="nav-icon fa-sharp fa-thin fa-arrow-right"></i>
                                <p>System info</p>
                            </a>
                        </li>


                    </ul>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link" data-active="setting">
                        <i class="nav-icon fa-solid fa-microchip"></i>
                        <p>
                            Automations
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">

                        <li class="nav-item">
                            <a href="/admin_panel/automation/task_scheduler" class="nav-link"
                                data-active="automation-task_scheduler">
                                <i class="nav-icon fa-sharp fa-thin fa-arrow-right"></i>
                                <p>Task scheduler</p>
                            </a>
                        </li>
                        @if (env('APP_ENV') != 'demo')
                            <li class="nav-item">
                                <a href="/download_daily_backup" class="nav-link"
                                    data-active="automation-download_daily_backup">
                                    <i class="nav-icon fa-sharp fa-thin fa-arrow-right"></i>
                                    <p>Daily Backup</p>
                                </a>
                            </li>
                        @endif



                    </ul>
                </li>








            </ul>
        </nav>
    </div>
</aside>
