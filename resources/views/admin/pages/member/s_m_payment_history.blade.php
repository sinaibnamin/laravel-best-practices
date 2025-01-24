@extends('admin.master')
@section('content')
    @include('admin/partials/helpers/session_alert')

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                  
                        <h1 class="m-0">Payment history</h1>
                 
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Member</a></li>
                        <li class="breadcrumb-item active">Payment history</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>


    <section class="content member-list-page">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body table-responsive p-0">
                            @include('admin/pages/payment/components/payment_list_loop')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

 

@endsection


@section('pagejs')
    <script>
    
    menu_parent_active('payment-history')
    
    </script>
@endsection

@section('pagecss')
    <style>
      
    </style>
@endsection
