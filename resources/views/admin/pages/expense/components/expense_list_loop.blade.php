<table class="table table-hover text-nowrap">
    <thead>
        <tr>
            <th>Expense date</th>
            <th>Expense type</th>
            <th>Description</th>
            <th class="text-right">amount</th>
            @if (!$print_page)
                <th>Action </th>
            @endif

        </tr>
    </thead>
    <tbody>



        @foreach ($expenses as $expense)
            <tr class="{{ $expense->due > 0 ? 'due-row-bg' : '' }}">

                <td id="date_{{ $expense->id }}">
                    @if ($expense->date)
                        {{ \Carbon\Carbon::parse($expense->date)->format('M d, Y') }}
                    @else
                        N/A
                    @endif
                </td>

                <td id="expense_type_{{ $expense->id }}">
                    {{ $expense->expense_type->title }}
                </td>

                <td style="text-wrap: wrap;min-width:200px;" id="description_{{ $expense->id }}">
                    {{ $expense->description ?? 'N/A' }}
                </td>
                <td class="text-right" id="amount_{{ $expense->id }}">
                    {{ $expense->amount }}
                </td>



                <td style="display: none;" id="delete_url_{{ $expense->id }}">
                    {{ url('/admin_panel/expense/delete/' . $expense->id) }}</td>


                @if (!$print_page)
                    <td>
                        @if (get_user_role() == 'admin')
                            <a class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Edit"
                                href="{{ url('/admin_panel/expense/edit/' . $expense->id) }}">
                                <i class="fas fa-pencil-alt">
                                </i>
                            </a>

                            <a class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top"
                                title="Permanent delete" href="javascript:void(0)"
                                onclick="deletefunction('{{ $expense->id }}')">
                                <i class="fa-sharp fa-regular fa-trash"></i>
                            </a>
                            @else 
                            N/A
                        @endif

                    </td>
                @endif
            </tr>
        @endforeach
        @if (count($expenses) == 0)
            <tr>
                @if (request()->query() === [])
                    <td colspan='5' class="text-primary text-bold">Please apply some filter
                        to see data</td>
                @else
                    <td colspan='5' class="text-danger text-bold">sorry no data here</td>
                @endif
            </tr>
        @endif
    </tbody>
</table>
