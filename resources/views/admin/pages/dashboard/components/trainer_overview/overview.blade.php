<div class="row ">
    <div class="col-12">
        <div class="card card-default">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fa-sharp fa-solid fa-street-view mr-2"></i>
                    Trainer overview
                </h3>
            </div>

            <div class="card-body">

                <h4 class="text-bold"> Welcome to GymForest</h4>

                @if ($trainer->status == 'Pending')
                    <div class="callout callout-warning">
                        <p>Your trainnership status is <b>pending</b>. Please complete your profile.</p>
                    </div>
                @endif
                @if ($trainer->status == 'Active')
                    <div class="callout callout-success">
                        <p>Your trainnership status is <b>active</b>. Thank you for being with us.</p>
                    </div>
                @endif
              


            </div>

        </div>

    </div>

</div>