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
                            <td>Member</td>
                            <td id="modal_payment_member"></td>
                        </tr>
                        <tr>
                            <td>Uniq ID</td>
                            <td id="modal_payment_uniq_id"></td>
                        </tr>
                        <tr>
                            <td>Package</td>
                            <td id="modal_payment_package"></td>
                        </tr>
                        <tr>
                            <td>Price</td>
                            <td id="modal_payment_price"></td>
                        </tr>
                        <tr>
                            <td>Paid</td>
                            <td id="modal_payment_paid"></td>
                        </tr>
                        <tr>
                            <td>Discounr</td>
                            <td id="modal_payment_discount"></td>
                        </tr>
                        <tr>
                            <td>Due</td>
                            <td id="modal_payment_due"></td>
                        </tr>
                        <tr>
                            <td>Pay date</td>
                            <td id="modal_payment_pay_date"></td>
                        </tr>
                        <tr>
                            <td>Validity</td>
                            <td id="modal_payment_validity"></td>
                        </tr>

                    </tbody>
                </table>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <a id="modal_payment_href" href="#" class="btn btn-danger double-click-link">Delete permanently</a>
            </div>
        </div>
    </div>
</div>

<script>
    function deletefunction(id) {

        $('#modal_payment_member').html($('#member_' + id).html())
        $('#modal_payment_uniq_id').text($('#uniq_id_' + id).text())
        $('#modal_payment_package').text($('#package_' + id).text())
        $('#modal_payment_price').text($('#price_' + id).text())
        $('#modal_payment_paid').text($('#paid_' + id).text())
        $('#modal_payment_discount').text($('#discount_' + id).text())
        $('#modal_payment_due').text($('#due_' + id).text())
        $('#modal_payment_pay_date').text($('#pay_date_' + id).text())
        $('#modal_payment_validity').text($('#validity_' + id).text())
   
        $('#modal_payment_href').attr("href", $('#payment_delete_url_' + id).text())
        $('#deletemodal').modal('show')
    }
</script>
