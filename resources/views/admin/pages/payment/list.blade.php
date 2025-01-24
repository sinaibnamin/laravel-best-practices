@extends('admin.master')
@section('content')
    @include('admin/partials/helpers/session_alert')

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">

                    @if ($fail_page)
                        <h1 class="m-0">Failed payment list</h1>
                    @else
                        <h1 class="m-0">Payment list</h1>
                    @endif


                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Payment</a></li>
                        <li class="breadcrumb-item active">List</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>






    <section class="content payment-list-page">


        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary">

                        @php
                            $action_url = route('admin_panel.payment.index');
                            if($fail_page){
                                $action_url = route('admin_panel.payment.fail');
                            }
                        @endphp
                        {{-- filter form  --}}

                        <form action="{{ $action_url }}" method="get" enctype="multipart/form-data">

                            <div class="card-body row align-items-end">

                                <div class="form-group mb-0 col-12 col-md-6 col-lg-4 col-xl-3">
                                    <label>Member name</label>
                                    <select name='member_id' class="form-control select2" style="width: 100%;">
                                        <option value="">Select member</option>
                                        @foreach ($members as $member)
                                            <option {{ old('member_id') == $member->id ? 'selected' : '' }}
                                                {{ request()->get('member_id') == $member->id ? 'selected' : '' }}
                                                value="{{ $member->id }}">{{ $member->full_name }} (uniq id:
                                                {{ $member->uniq_id }})</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group mb-0 col-12 col-md-6 col-lg-3 col-xl-2">
                                    <label>Package</label>
                                    <select name='package_id' class="form-control select2" style="width: 100%;">
                                        <option value="">Select package</option>
                                        @foreach ($packages as $package)
                                            <option {{ old('package_id') == $package->id ? 'selected' : '' }}
                                                {{ request()->get('package_id') == $package->id ? 'selected' : '' }}
                                                value="{{ $package->id }}">{{ $package->name }} </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group mb-0 col-12 col-md-6 col-lg-3 col-xl-2 col-xxl-1">
                                    <label>Pay status</label>
                                    <select name='pay_status' class="form-control">
                                        <option value="all">All</option>

                                        <option {{ request()->get('pay_status') == 'has_due' ? 'selected' : '' }}
                                            value="has_due">
                                            has_due</option>
                                    
                                    </select>
                                </div>

                                <div class="form-group mb-0 col-12 col-md-6 col-lg-3 col-xl-2">
                                    <label>From Date</label>
                                    <input value="{{ request()->get('from_date') }}" name="from_date" type="date"
                                        class="form-control" placeholder="Inquery no">
                                </div>
                                <div class="form-group mb-0 col-12 col-md-6 col-lg-3 col-xl-2">
                                    <label>To Date</label>
                                    <input value="{{ request()->get('to_date') }}" name="to_date" type="date"
                                        class="form-control" placeholder="Inquery no">
                                </div>


                                <div class="col-auto">
                                    <button type="submit" class="btn btn-primary mt-3"><i class="fa-regular fa-filter"></i>
                                        Filter</button>
                                    @php
                                        $url = request()->fullUrl();
                                        $urlParts = explode('?', $url);
                                        $queryString = isset($urlParts[1]) ? $urlParts[1] : '';
                                    @endphp
                                    <a target="_blank" href="{{ url('/admin_panel/payment/print') . '?' . $queryString }}"
                                        class="btn btn-warning mt-3 {{$fail_page ? 'd-none' : ''}}">
                                        <i class="fa-regular fa-print"></i> Print
                                    </a>
                                </div>

                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>


        @include('admin/pages/payment/components/payment_history_summary')


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

    @include('admin.pages.payment.components.delete_modal')
@endsection


@section('pagejs')
    <script>
        const fail_page = '{{$fail_page}}';
        if(fail_page){
            menu_make_active('payment-fail')
        }else{
            menu_make_active('payment-list')
        }
        
        $('[data-toggle="tooltip"]').tooltip()
    </script>

    <!-- Select2 -->
    <script src="/admin_assets/plugins/select2/js/select2.full.min.js"></script>

    <script>
        //Initialize Select2 Elements
        $('.select2').select2()
    </script>
@endsection

@section('pagecss')
    <!-- Select2 -->
    <link rel="stylesheet" href="/admin_assets/plugins/select2/css/select2.min.css">
@endsection
