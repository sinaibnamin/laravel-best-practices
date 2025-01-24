<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Payments print</title>
</head>

<style>
    * {
        margin: 0;
        padding: 0;
        font-family: sans-serif;
    }
</style>

<style>
    .print-wrapper {
        width: 100%;

    }

    table,
    th,
    td {

        border-collapse: collapse;
    }

    th,
    td {
        padding: 10px;
        border: 1px solid black;

    }

    .text-right {
        text-align: right;
    }

    .text-bold {
        font-weight: bold;
    }

    .first-two-table-wrapper {
        display: flex;
        flex-direction: row;
        justify-content: space-between;
        gap: 10px;
        margin-bottom: 20px;
    }



    .payment-table-wrapper table {
        width: 100%;
    }

    .payment-table-wrapper td {
        font-size: 12px;
        padding: 6px;
    }

    .payment-table-wrapper th {
        font-size: 13px;
        padding: 6px;
        text-align: left;
    }

    .site-logo-placeholder {
        max-width: 200px;
        max-height: 80px;
        margin: 0 auto;
    }
</style>


<style>
    /* Prevent table rows from breaking */
    tr {
        page-break-inside: avoid;
    }
</style>

@php
    $system_logo = asset('/') . 'site_images/statics/system_logo.png';

    $system_info_img_folder = asset('/') . 'site_images/uploaded/system_info/';

    $system_logo = $gym_logo ? $system_info_img_folder . $gym_logo : $system_logo;
@endphp

<body>

    <div class="print-wrapper">
        <div style="width: 100%;display: flex;justify-content: center;">
            <img class="site-logo-placeholder" src="{{ $system_logo }}" alt="">
        </div>
        {!! $print_header !!}
        <div style="margin-bottom: 30px;"></div>

        @include('admin/pages/payment/components/payment_history_summary')
        <div style="margin-bottom: 10px;"></div>

        <div class="payment-table-wrapper">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>SL</th>
                        <th>Member</th>

                        <th>Package</th>
                        <th class="text-right">Price</th>
                        <th class="text-right">Paid</th>
                        <th class="text-right">Dis.</th>
                        <th class="text-right">Due</th>
                        <th>Pay by</th>
                        <th>Pay Date</th>
                        <th>Validity</th>
                        <th>Comments</th>
                        <th>status</th>

                    </tr>
                </thead>
                <tbody>

                    @foreach ($payments as $index => $payment)
                        <tr>
                            <td>{{ $index + 1 }}</td>

                            <td style="text-wrap: wrap;width:120px;">
                                <div>{{ $payment->member->full_name ?? 'not found' }}</div>
                                <div>Uniq ID: {{ $payment->member->uniq_id ?? 'not found' }}</div>


                            </td>

                            <td>
                                {{ $payment->package->name }}
                            </td>
                            <td class="text-right">
                                @if ($payment->package_price == 0)
                                    N/A
                                @else
                                    <span>{{ $payment->package_price }}</span>
                                @endif
                            </td>
                            <td class="text-right">
                                {{ $payment->paid }}
                            </td>
                            <td class="text-right">
                                {{ $payment->discount }}
                            </td>
                            <td class="text-right {{ $payment->due > 0 ? 'text-bold text-danger' : '' }}">
                                {{ $payment->due }}
                            </td>
                            <td>
                                {{ $payment->pay_by }}
                            </td>
                            <td style="text-wrap: wrap;width:120px;">
                                {{ \Carbon\Carbon::parse($payment->date)->format('M d, Y') }}
                            </td>
                            <td style="text-wrap: wrap;width:120px;">
                                @if ($payment->validity)
                                    {{ \Carbon\Carbon::parse($payment->validity)->format('M d, Y') }}
                                @else
                                    N/A
                                @endif

                            </td>
                            <td style="text-wrap: wrap; min-width: 100px; max-width: 150px;">
                                @if (strlen($payment->comments ?? '') > 42)
                                    <span class="short-text">
                                        {{ Str::limit($payment->comments, 42) }}
                                    </span>
                                @else
                                    {{ $payment->comments ?? 'N/A' }}
                                @endif
                            </td>
                            <td>
                                {{ $payment->status ?? 'N/A' }}
                            </td>

                        </tr>
                    @endforeach

                </tbody>
            </table>

        </div>



    </div>

    <script>
        window.onafterprint = window.close;
        window.print();
    </script>

</body>

</html>
