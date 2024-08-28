<div class="row">
    <div class="col-md-6">
        <div class="input-group mb-3 ">
            <input type="text" class="form-control pull-right mt-2 mb-2" name="daterange_completed_filter" value=""
                style="height: 45px;" />

            <div class="input-group-append">
                <div class="col-md-12"> <a href="javascript:;" id="reset"
                        class="btn  mb-3 mt-2 sub-button pull-right"><i class="ti-calendar"></i></a> </div>
            </div>
        </div>
    </div>
    <div class="col-md-5">
        <select class="custom-select mt-2 mb-2" style="height: 45px;" id="filter_type_of_activity">
            <option value="">Select Type Of Activity</option>
            <?php  foreach ($activities as $row): ?>
            <option value="<?php    echo $row->type_of_activity_id  ?>"><?php    echo $row->type_of_activity_name ?>
            </option>
            <?php  endforeach; ?>
        </select>
    </div>
    <div class="col-md-1">
        <button class="btn sub-button btn-block mt-2 mb-2" style="height: 45px;" id="reset-filter-options"><i
                class="ti-reload"></i>
        </button>
    </div>
</div>
<div class="row mb-3 " id="select_cso_section" hidden>
    <div class="col-md-6 p">
        <select class="custom-select js-example-basic-single" id="select_cso" name="cso" style="width: 100%; ">
            <option value="0">Select CSO</option>
            <?php foreach ($cso as $row):?>
            <option value="<?php    echo $row->cso_id ?>"><?php    echo $row->cso_code . ' - ' . $row->cso_name ?></option>
            <?php endforeach; ?>
        </select>
    </div>
</div>
<div class="row">
    <button class="btn sub-button btn-block" style="width: 100%;" id="generate-pmas-report">Generate Report</button>
</div>