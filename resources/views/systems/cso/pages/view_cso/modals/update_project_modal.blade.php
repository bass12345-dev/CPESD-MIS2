<div class="modal fade" id="update_project_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Update Project</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="update_project_form" class="p-2">
                <div class="modal-body">
                    <div class="form-group">
                        <input type="hidden" name="cso_project_id">
                        <div class="col-12">Project<span class="text-danger">*</span></div>
                        <input type="text" class="form-control input" name="update_title_of_project" placeholder="">
                    </div>
                    <div class="form-group">
                        <div class="col-12">Amount<span class="text-danger">*</span></div>
                        <input type="text" class="form-control input numbers" name="update_amount" placeholder="">
                    </div>
                    <div class="form-group">
                        <div class="col-12">Year<span class="text-danger">*</span></div>
                        <input type="date" class="form-control input" name="update_year" id="currentDate"
                            placeholder="">
                    </div>
                    <div class="form-group">
                        <div class="col-12">Funding Agency<span class="text-danger">*</span></div>
                        <input type="text" class="form-control input" name="update_funding_agency" placeholder="">
                    </div>
                    <div class="form-group">
                        <div class="col-12">Status<span class="text-danger">*</span></div>
                        <select class="form-control" name="update_status">
                            <option value="active">Active</option>
                            <option value="inactive">InActive</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer" id="update_cso_footer">
                    <button type="button" class="btn btn-danger update-cso-close" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn  btn-update-project_ sub-button ">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>