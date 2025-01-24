@php
    $an_hidden_class = '';
    if (count($announcements) == 0) {
        $an_hidden_class = 'd-none';
    };
@endphp


<div class="row {{$an_hidden_class}}">
    <div class="col-12">
        <div class="card card-default">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-bullhorn mr-2"></i>
                    Announcements
                </h3>
            </div>

            <div class="card-body">
                @foreach ($announcements as $announcement)
                  @include('admin/pages/dashboard/components/announcement/announcement')
                @endforeach




            </div>

        </div>

    </div>

</div>
