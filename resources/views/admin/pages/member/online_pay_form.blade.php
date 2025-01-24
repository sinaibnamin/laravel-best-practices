@extends('admin.master')
@section('content')
    @include('admin/partials/helpers/session_alert')


    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Pay now</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Member</a></li>
                        <li class="breadcrumb-item active">Pay now</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary">

                        @if ($overview->member->status == 'Active' || $overview->member->status == 'Approve')
                            @include('admin/pages/member/components/pay_form')
                        @else
                        <p class="text-bold text-danger p-3">You are not an active member, please contact with admin to pay</p>
                        @endif

                    




                    </div>

                </div>
            </div>
        </div>
        </div>
    </section>
@endsection


@section('pagecss')
    <!-- Select2 -->
    <link rel="stylesheet" href="/admin_assets/plugins/select2/css/select2.min.css">
    <style>
        .payment-amount-digits {
            font-size: 25px !important;
            font-weight: bold !important;

        }
    </style>
@endsection



@section('pagejs')
    <script>
        menu_parent_active('pay-now')
    </script>
    <!-- Select2 -->
    <script src="/admin_assets/plugins/select2/js/select2.full.min.js"></script>

    <script>
        //Initialize Select2 Elements
        $('.select2').select2()
    </script>
    @include('admin/pages/payment/components/paymentjs')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            $('#packageselection').on('change', function(event) {
                const paid_input = document.querySelector('input[name="paid"]');
                const selectedOption = event.target.options[event.target.selectedIndex];
                const packagePrice = parseInt(selectedOption.getAttribute('data-price'), 10) || 0;
                if (packagePrice > 0) {
                    paid_input.disabled = true;
                } else {
                    paid_input.disabled = false;
                }

            });
        });
    </script>
@endsection
