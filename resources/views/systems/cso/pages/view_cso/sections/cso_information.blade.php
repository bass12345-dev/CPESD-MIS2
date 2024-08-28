
    <div class="col-md-6">
        <table class="tablesaw table-bordered table-hover table" style="width: 100%;" data-tablesaw-mode="swipe" data-tablesaw-sortable data-tablesaw-sortable-switch data-tablesaw-minimap data-tablesaw-mode-switch id="_table">
            <tr>
                <td colspan="2"> <a href="javascript:;" class="mt-2  mb-2 btn sub-button text-center  btn-rounded btn-md btn-block"><i class="fa fa-user" aria-hidden="true"></i> CSO Information</a>
                    <a href="javascript:;" id="update-cso-information" class="mt-2  mb-2  text-center  btn-rounded btn-md btn-block" data-toggle="modal" data-target="#update_cso_information_modal"><i class="fa fa-edit" aria-hidden="true"></i> Update CSO Information</a>
                </td>
            </tr>
            <tr>
                <td>CSO Code</td>
                <input type="hidden" value="{{$row->cso_id}}" name="cso_id">
                <td class="cso_code"></td>
            </tr>
            <tr>
                <td>CSO</td>
                <td class="cso_name"></td>
            </tr>
            <tr>
                <td>Address</td>
                <td class="cso_address"></td>
            </tr>
            <tr>
                <td>Contact Person</td>
                <td class="contact_person"></td>
            </tr>
            <tr>
                <td>Contact Number</td>
                <td class="contact_number"></td>
            </tr>
            <tr>
                <td>Telephone Number</td>
                <td class="telephone_number"></td>
            </tr>
            <tr>
                <td>Email Address</td>
                <td class="email"></td>
            </tr>
            <tr>
                <td>CSO Classification</td>
                <td class="classification"></td>
            </tr>
            <tr>
                <td>CSO Status</td>
                <td class="cso_status"> </td>
            </tr>
            <tr>
                <td>COR</td>
                <td>
                    <a href="javascript:;" class="view-pdf" data-type="cor">View COR </a>
                    <a href="javascript:;" class="btn btn-rounded btn-secondary pull-right update_file" data-title="COR" data-type="cor" data-toggle="modal" data-target="#update_files_modal">Update COR</a>

                </td>
            </tr>
            <tr>
                <td>Bylaws</td>
                <td>
                    <a href="javascript:;" class="view-pdf" data-type="bylaws">View Bylaws</a> <a href="javascript:;" class="btn btn-rounded btn-secondary pull-right update_file" data-title="ByLaws" data-type="bylaws" data-toggle="modal" data-target="#update_files_modal">Update Bylaws</a>
                </td>
            </tr>
            <tr>
                <td>Article</td>
                <td>
                    <a href="javascript:; " class="view-pdf" data-type="articles">View AOC/AOI </a>
                    <a href="javascript:;" class="btn btn-rounded btn-secondary pull-right update_file" data-title="AOC/AOI" data-type="aoc" data-toggle="modal" data-target="#update_files_modal">Update AOC/AOI </a>
                </td>
            </tr>

        </table>
    </div>

