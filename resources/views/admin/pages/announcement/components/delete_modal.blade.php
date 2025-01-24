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
                            <td>Announcement</td>
                            <td id="modal_announcement"></td>
                        </tr>
                       
                        <tr>
                            <td>Status</td>
                            <td id="modal_announcement_status"></td>
                        </tr>

                    </tbody>
                </table>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <a id="modal_announcement_href" href="#" class="btn btn-danger double-click-link">Delete permanently</a>
            </div>
        </div>
    </div>
</div>

<script>
    function deletefunction(id) {
        $('#modal_announcement').html($('#announcement_' + id).html())
        $('#modal_announcement_status').html($('#status_' + id).html())
        $('#modal_announcement_href').attr("href", $('#announcement_delete_url_' + id).text())
        $('#deletemodal').modal('show')
    }
</script>
