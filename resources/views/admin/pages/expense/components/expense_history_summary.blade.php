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

                    // ExpenseType string
                    $expense_type_string = '';
                    $expense_typeId = request()->get('expense_type_id');
                    if ($expense_typeId) {
                        $expense_type = $expense_types->firstWhere('id', $expense_typeId);
                        if ($expense_type) {
                            $expense_type_string = 'Expense type: ' . $expense_type->title;
                            $summary_array[] = $expense_type_string;
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

                    $total_expense_string = 'Total expense: <b>'. $total_expense.'</b>';
                    $summary_array[] = $total_expense_string;
               

                    $d_none_history_class = request()->query() === [] ? 'd-none' : '';

                @endphp

                <div class="card-body p-2 {{$d_none_history_class}}">
                    
                    <div class="m-0 h4"><b>Expense history:</b> {!! implode(' <span class="text-primary text-bold"> | </span> ', $summary_array) !!}</div>
                </div>
            </div>

        </div>
    </div>
</div>