@if (Session::has('message'))
    @php
        $icon = Session::has('icon-class') ? Session::get('icon-class') : 'fas fa-check';
        $alert_class = Session::has('alert-class') ? Session::get('alert-class') : 'primary';
    @endphp

    <div class="content-header pb-0 alert-content-header">
        <div class="container-fluid">
            <div class="row ">
                <div class="col-12">
                    <div class="alert alert-{{ $alert_class }} alert-dismissible mb-0">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h5 class="mb-0"><i class="icon {{ $icon }}"></i>
                            {{ Session::get('message') }} </h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif


@if ($errors->any())
    <div class="content-header pb-0">
        <div class="container-fluid">
            <div class="row ">
                <div class="col-12">
                    <div class="alert alert-danger alert-dismissible mb-0">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
