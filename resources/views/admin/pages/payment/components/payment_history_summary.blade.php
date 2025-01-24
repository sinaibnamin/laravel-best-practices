<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card card-primary">
                @php
                    $summary_array = [];

                    // Member string
                    $member_string = '';
                    $memberId = request()->get('member_id');
                    if ($memberId) {
                        $member = $members->firstWhere('id', $memberId);
                        if ($member) {
                            $member_string = 'Member: ' . $member->full_name;
                            $summary_array[] = $member_string;
                        }
                    }

                    // Package string
                    $package_string = '';
                    $packageId = request()->get('package_id');
                    if ($packageId) {
                        $package = $packages->firstWhere('id', $packageId);
                        if ($package) {
                            $package_string = 'Package: ' . $package->name;
                            $summary_array[] = $package_string;
                        }
                    }

                    // From date string
                    $fromDate_string = '';
                    $fromDate = request()->get('from_date');
                    if ($fromDate) {
                        $fromDate_string = 'From date: ' .  \Carbon\Carbon::parse($fromDate)->format('M d Y');
                        $summary_array[] = $fromDate_string;
                    }

                    // To date string
                    $toDate_string = '';
                    $toDate = request()->get('to_date');
                    if ($toDate) {
                        $toDate_string = 'To date: ' . \Carbon\Carbon::parse($toDate)->format('M d Y');
                        $summary_array[] = $toDate_string;
                    }

                    $total_paid_string = 'Total paid: <b>'. $total_paid.'</b>';
                    $summary_array[] = $total_paid_string;
                    $total_due_string = 'Total due: <b class="text-danger">'. $total_due.'</b>';
                    $summary_array[] = $total_due_string;

                    $d_none_history_class = request()->query() === [] ? 'd-none' : '';

                @endphp

                <div class="card-body p-2 {{$d_none_history_class}}">
                    
                    <div class="m-0 h4"><b>Payment history:</b> {!! implode(' <span class="text-primary text-bold"> | </span> ', $summary_array) !!}</div>
                </div>
            </div>

        </div>
    </div>
</div>