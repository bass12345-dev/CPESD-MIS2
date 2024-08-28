<div class="modal fade" id="search_name_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Add Client</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <span class="text-danger">*Try to search "First Name" or "Last Name" Only</span>
                            <div class="form-group">
                                <div class="col-12">First Name<span class="text-danger">*</span></div>
                                <input type="text" name="search_first_name" class="form-control">
                            </div>
                            <div class="form-group">
                                <div class="col-12">Last Name<span class="text-danger">*</span></div>
                                <input type="text" name="search_last_name" class="form-control">
                            </div>

                            <button class="btn sub-button btn-block" id="search_client">Search Client</button>


                        </div>
                    </div>
                </div>
                <div class="row mt-3" id="search_name_result" hidden>
                    <div class="col-md-12">
                        <div class="card">
                            <div class="row mt-2">
                                <div class="col-md-12">
                                    <button class="btn  mb-3 mt-2 btn-danger pull-right ml-2"
                                        id="close_search_client"><i class="ti-close "></i></button>
                                    <button class="btn  mb-3 mt-2 sub-button pull-right" id="add_client">Add
                                        Client</button>
                                </div>
                            </div>
                            <table id="search_name_result_table" style="width:100%" class="text-center">
                                <thead class="bg-light text-capitalize">
                                    <tr>
                                        <th>First Name</th>
                                        <th>Middle Name</th>
                                        <th>Last Name</th>
                                        <th>Extension</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>