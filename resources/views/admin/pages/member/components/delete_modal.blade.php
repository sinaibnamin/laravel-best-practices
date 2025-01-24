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
                            <td>Uniq ID</td>
                            <td id="modal_member_uniq_id"></td>
                        </tr>
                        <tr>
                            <td>Member</td>
                            <td id="modal_member_photo"></td>
                        </tr>
                        <tr>
                            <td>Member Phone</td>
                            <td id="modal_member_phone"></td>
                        </tr>
                        <tr>
                            <td>Member age</td>
                            <td id="modal_member_age"></td>
                        </tr>

                    </tbody>
                </table>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <a id="modal_member_href" href="#" class="btn btn-danger double-click-link">Delete permanently</a>
            </div>
        </div>
    </div>
</div>

<script>
    function deletefunction(id) {
        $('#modal_member_uniq_id').text($('#uniq_id_' + id).text())
        $('#modal_member_phone').text($('#phone_' + id).text())
        $('#modal_member_age').text($('#age_' + id).text())
        $('#modal_member_photo').html($('#photo_' + id).html())
        $('#modal_member_href').attr("href", $('#member_delete_url_' + id).text())
        $('#deletemodal').modal('show')
    }
</script>
