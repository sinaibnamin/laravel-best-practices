<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Expense print</title>
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



    .expense-table-wrapper table {
        width: 100%;
    }

    .expense-table-wrapper td {
        font-size: 12px;
        padding: 6px;
    }

    .expense-table-wrapper th {
        font-size: 13px;
        padding: 6px;
        text-align: left;
    }
</style>


<style>
    /* Prevent table rows from breaking */
    tr {
        page-break-inside: avoid;
    }

</style>

<body>

    <div class="print-wrapper">

        {!! $print_header !!}
        <div style="margin-bottom: 30px;"></div>
     
        @include('admin/pages/expense/components/expense_history_summary')
        <div style="margin-bottom: 10px;"></div>

        <div class="expense-table-wrapper">
            @include('admin/pages/expense/components/expense_list_loop')
        </div>



    </div>

    <script>
         window.onafterprint = window.close;
         window.print();
    </script>

</body>

</html>
