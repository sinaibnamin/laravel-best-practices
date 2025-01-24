<div class="row">
    <div class="col-12">
        <div class="card card-default">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fa-solid fa-flag mr-2"></i>
                    Counters
                </h3>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-lg-3 col-6">
                        <a href="/admin_panel/member/list" class="small-box bg-info">
                            <div class="inner">
                                <h3>{{$total_members}}</h3>
                                <p>Total members</p>
                            </div>
                            <div class="dashboard-counter-icon">
                                <i class="fa-solid fa-people-simple"></i>
                            </div>
                        </a>
                    </div>
    
                    <div class="col-lg-3 col-6">
                        <a href="/admin_panel/member/list?status=Active" class="small-box bg-success">
                            <div class="inner">
                                <h3>{{$active_members}}</h3>
                                <p>Active members</p>
                            </div>
                            <div class="dashboard-counter-icon">
                                <i class="fa-solid fa-chart-line-up"></i>
                            </div>
                        </a>
                    </div>
    
                    <div class="col-lg-3 col-6">
                        <a class="small-box bg-warning" href="/admin_panel/member/list?status=Pending">
                            <div class="inner">
                                <h3>{{$pending_members}}</h3>
                                <p>Pending members</p>
                            </div>
                            <div class="dashboard-counter-icon">
                                <i class="fa-solid fa-chart-line-down"></i>
                            </div>
                        </a>
                    </div>
    
                    <div class="col-lg-3 col-6">
                        <a href="/admin_panel/member/archivelist" class="small-box bg-secondary">
                            <div class="inner">
                                <h3>{{$archive_members}}</h3>
                                <p>Members on archive</p>
                            </div>
                            <div class="dashboard-counter-icon">
                                <i class="fa-sharp fa-regular fa-inbox"></i>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-3 col-6">
                        <a href="/admin_panel/member/list?status=Expire" class="small-box bg-danger">
                            <div class="inner">
                                <h3>{{$expire_members}}</h3>
                                <p>Expire Members</p>
                            </div>
                            <div class="dashboard-counter-icon">
                                <i class="fa-solid fa-people-simple"></i>
                            </div>
                        </a>
                    </div>
    
                 
    
                    <div class="col-lg-3 col-6">
                        @php
                            $thirtyDaysBeforeDate = date('Y-m-d', strtotime('-30 days'));
                        @endphp
                        <a href="/admin_panel/payment/list?from_date={{$thirtyDaysBeforeDate}}" class="small-box bg-secondary">

                            <div class="inner">
                                <h3>{{$payment_count}}</h3>
                                <p>Payments collection in last 30 days</p>
                            </div>
                            <div class="dashboard-counter-icon">
                                <i class="fa-solid fa-sack-dollar"></i>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-3 col-6">
                        <a href="/admin_panel/announcement/list" class="small-box bg-secondary">
                            <div class="inner">
                                <h3>{{$total_announcements}}</h3>
                                <p>Total announcements</p>
                            </div>
                            <div class="dashboard-counter-icon">
                                <i class="fa-sharp fa-solid fa-bullhorn"></i>
                            </div>
                        </a>
                    </div>

                    <div class="col-lg-3 col-6">
                        <a href="/admin_panel/trainer/list" class="small-box bg-info">
                            <div class="inner">
                                <h3>{{$total_trainers}}</h3>
                                <p>Trainers</p>
                            </div>
                            <div class="dashboard-counter-icon">
                                <i class="fa-solid fa-person-chalkboard"></i>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-3 col-6">
                        <a href="/admin_panel/payment/list?pay_status=has_due" class="small-box bg-warning">
                            <div class="inner">
                                <h3>{{$due_payment_count}}</h3>
                                <p>Total due pay</p>
                            </div>
                            <div class="dashboard-counter-icon">
                                <i class="fa-regular fa-message-dollar"></i>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-3 col-6">
                        <a href="/admin_panel/package/list" class="small-box bg-info">
                            <div class="inner">
                                <h3>{{$total_packages}}</h3>
                                <p>Toal packages</p>
                            </div>
                            <div class="dashboard-counter-icon">
                                <i class="fa-solid fa-messages-dollar"></i>
                            </div>
                        </a>
                    </div>
                 

                </div>


            </div>

        </div>

    </div>

</div>

