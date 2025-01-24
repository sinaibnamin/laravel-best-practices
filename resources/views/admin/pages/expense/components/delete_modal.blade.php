<div class="modal fade" id="deletemodal" tabindex="-1" role="dialog" aria-labelledby="deletemodalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h5 class="modal-title" id="deletemodalLabel">Are You Sure To Delete?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <td>Expense date</td>
                            <td id="modal_date"></td>
                        </tr>
                        <tr>
                            <td>Expense type</td>
                            <td id="modal_expense_type"></td>
                        </tr>
                        <tr>
                            <td>Description</td>
                            <td id="modal_description"></td>
                        </tr>
                        <tr>
                            <td>Amount</td>
                            <td id="modal_amount"></td>
                        </tr>
                       

                    </tbody>
                </table>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <a id="modal_delete_href" href="#" class="btn btn-danger double-click-link">Delete permanently</a>
            </div>
        </div>
    </div>
</div>

<script>
    function deletefunction(id) {

        $('#modal_date').html($('#date_' + id).html())
        $('#modal_expense_type').text($('#expense_type_' + id).text())
        $('#modal_description').text($('#description_' + id).text())
        $('#modal_amount').text($('#amount_' + id).text())
   
        $('#modal_delete_href').attr("href", $('#delete_url_' + id).text())
        $('#deletemodal').modal('show')
    }
</script>
