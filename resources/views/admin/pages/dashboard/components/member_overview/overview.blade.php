<div class="row ">
    <div class="col-12">
        <div class="card card-default">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fa-sharp fa-solid fa-street-view mr-2"></i>
                    Member overview
                </h3>
            </div>

            <div class="card-body">

                <p class="h5 text-bold mb-1">Hi, {{$member->full_name}} ( <span class="text-primary">{{$member->uniq_id}}</span>  )</p>

                <h4 class="text-bold mb-2"> Welcome to {{$system_name}}</h4>

                @if ($member->status == 'Pending')
                    <div class="callout callout-warning">
                        <p>Your membership status is <b>pending</b>. Please complete your profile.</p>
                    </div>
                @endif
                @if ($member->status == 'Approve')
                    <div class="callout callout-warning">
                        <p>Your membership status is <b>approved</b>. Please complete your payment to activate
                            your
                            account.</p>
                    </div>
                @endif
                @if ($member->status == 'Active')
                    <div class="callout callout-success">
                        <p>Your membership status is <b>active</b>. Thank you for being with us</p>
                    </div>
                @endif
                @if ($member->status == 'Expire')
                    <div class="callout callout-danger">
                        <p>Your membership status is <b class="text-danger">Expired</b>. Please complete your
                            payment to activate your account.</p>
                    </div>
                @endif






                @if ($member->validity)
                    @php
                        $validityDate = \Carbon\Carbon::parse($member->validity);
                        $today = \Carbon\Carbon::today();
                    @endphp
                    @if ($validityDate->isBefore($today))
                        <div class="callout callout-danger">
                            <p>Your membership status was expired on <b
                                    class="text-danger">{{ $validityDate->format('d F Y') }}</b></p>
                        </div>
                    @elseif ($validityDate->isSameDay($today))
                        <div class="callout callout-warning">
                            <p>Your membership status expires today on
                                <b>{{ $validityDate->format('d F Y') }}</b>
                            </p>
                        </div>
                    @else
                        <div class="callout callout-info">
                            <p>Your membership status will expire on <b>{{ $validityDate->format('d F Y') }}</b>
                            </p>
                        </div>
                    @endif
                @endif



                @if ($overview->last_due_payment)
                    <div class="callout callout-danger">
                        <p class="text-bold text-danger">You have some due payments</p>
                    </div>
                @endif
                @if ($overview->last_package)
                    <div class="callout callout-info">
                        <p>You paid
                            <b>{{ $overview->last_package->package->name }}</b> package in last package pay
                        </p>
                    </div>
                @endif

            </div>

        </div>

    </div>

</div>