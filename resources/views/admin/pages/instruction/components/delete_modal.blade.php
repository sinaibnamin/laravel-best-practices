
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
                            <td>Instruction</td>
                            <td id="modal_instruction"></td>
                        </tr>
                      
                        <tr>
                            <td>Member</td>
                            <td id="modal_member"></td>
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
        $('#modal_instruction').html($('#instruction_' + id).text())

        // console.log($('#member_' + id).html());
     
        $('#modal_member').html($('#member_' + id).html())
        $('#modal_delete_href').attr("href", $('#delete_href_' + id).text())
        
        $('#deletemodal').modal('show')
    }
</script>
