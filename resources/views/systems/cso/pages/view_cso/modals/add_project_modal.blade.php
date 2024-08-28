<div class="modal fade" id="add_project_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Add Project</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form id="add_project_form" class="p-2">
                <div class="modal-body">

                    <div class="form-group">
                        <input type="hidden" name="cso_idd">
                        <div class="col-12">Project<span class="text-danger">*</span></div>
                        <input type="text" class="form-control input" name="title_of_project" placeholder="" required>
                    </div>

                    <div class="form-group">

                        <div class="col-12">Amount<span class="text-danger">*</span></div>
                        <input type="text" class="form-control input numbers" name="amount" placeholder="" required>
                    </div>

                    <div class="form-group">

                        <div class="col-12">Year<span class="text-danger">*</span></div>
                        <input type="date" class="form-control input" name="year" placeholder="" required>
                    </div>

                    <div class="form-group">

                        <div class="col-12">Funding Agency<span class="text-danger">*</span></div>
                        <input type="text" class="form-control input" name="funding_agency" placeholder="" required>
                    </div>


                </div>
                <div class="modal-footer" id="update_cso_footer">
                    <button type="button" class="btn btn-danger update-cso-close" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn  btn-add-project sub-button ">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>