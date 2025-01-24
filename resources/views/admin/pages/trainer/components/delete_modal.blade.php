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
                            <td>Trainer name</td>
                            <td id="modal_trainer_name"></td>
                        </tr>
                        <tr>
                            <td>Trainer Photo</td>
                            <td id="modal_trainer_photo"></td>
                        </tr>
                        <tr>
                            <td>Trainer Phone</td>
                            <td id="modal_trainer_phone"></td>
                        </tr>
                        <tr>
                            <td>Trainer age</td>
                            <td id="modal_trainer_age"></td>
                        </tr>

                    </tbody>
                </table>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <a id="modal_trainer_href" href="#" class="btn btn-danger double-click-link">Delete permanently</a>
            </div>
        </div>
    </div>
</div>

<script>
    function deletefunction(id) {
        $('#modal_trainer_name').text($('#name_' + id).text())
        $('#modal_trainer_phone').text($('#phone_' + id).text())
        $('#modal_trainer_age').text($('#age_' + id).text())
        $('#modal_trainer_photo').html($('#photo_' + id).html())
        $('#modal_trainer_href').attr("href", $('#trainer_delete_url_' + id).text())
        $('#deletemodal').modal('show')
    }
</script>
