<div class="row mt-4">
    <div class="col-lg-6">
        <div class="data-tables border p-3">
            <h2 class="mb-3">Project/s Implemented</h2>
            <button class="btn sub-button pull-left mb-3 " data-toggle="modal" data-target="#add_project_modal">Add
                Project</button>
            <table id="project_table" style="width:100%" class="text-center mb-3">
                <thead class="bg-light text-capitalize" style="width:100%">
                    <tr>
                        <th>Title Of Project</th>
                        <th>Amount</th>
                        <th>Year</th>
                        <th>Funding Agency</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
    <div class="col-lg-6">
        <h3 class="mb-3">Activities Report</h3>
        <div class="row">
            <div class="col-md-6 pull-right  mb-2">
                <select class="custom-select" id="admin_year" onchange="load_graph(this)">
                    <?php  for ($i = 2023; $i <= 2030; $i++) {
                        $selected = $i == date('Y') ? "selected" : "";

                        echo '<option ' . $selected . '>' . $i . '</option>';

                    }    ?>
                </select>
            </div>
            <div class="col-sm-12 ">
                <div class="card border">
                    <div class="card-header bg-primary text-white">
                        Activities
                    </div>
                    <ul class="list-group list-group-flush">
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
</div>