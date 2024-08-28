<div class="modal fade" id="update_files_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title modal_file_title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="update_files_form" class="p-2">
                <div class="modal-body">

                    <input type="hidden" value="{{$row->cso_id}}" name="cso_id">
                    <input type="hidden" name="file_type">
                    <div class="form-group">
                        <label for="exampleInputPassword1" class="file_title"></label><span
                            class="text-danger">*</span><span class="pull-right text-danger">*Pdf file only</span>
                        <input type="file" class="form-control" name="update_file" placeholder=""
                            onchange="Validate_file(this);" required>
                    </div>
                    <div class="prog_cent" hidden>
                        <span id="percent" class="h2 text-primary">0%</span>
                        <div class="progress">
                            <div class="progress-bar"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" id="update_cso_footer">
                    <button type="button" class="btn btn-danger update-cso-close" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn sub-button save_file_button">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>