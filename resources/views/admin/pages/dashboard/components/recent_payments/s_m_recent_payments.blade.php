
<div class="row ">
    <div class="col-12">
        <div class="card card-default">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fa-solid fa-sack-dollar"></i>
                    Recent payments
                </h3>
            </div>

            <div class="card-body table-responsive">
                <table class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Paid</th>
                            <th>Package</th>
                            <th>Comments</th>
                        </tr>
                    </thead>
                    <tbody>




                        @foreach ($recent_payments as $payment)
                        <tr>
                            <td>
                               {{$payment->created_at}}
                            </td>
                            <td>
                               {{$payment->paid}}
                            </td>
                            <td>
                               {{$payment->package->name}}
                            </td>
                            <td>
                               {{$payment->comments}}
                            </td>
                          
                        </tr>
                    @endforeach
                    @if (count($recent_payments) == 0)
                        <tr>
                            <td colspan='3' class="text-danger text-bold">sorry no data here</td>
                        </tr>
                    @endif


                    </tbody>
                </table>


                <a href="/member_panel/payment_history" class="btn btn-primary mt-3">
                    <i class="fa-solid fa-border-all"></i> See all</a>
            </div>

        </div>

    </div>

</div>