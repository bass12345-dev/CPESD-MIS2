<div class="card flex-fill p-3">
@include('components.dts.filter_by_month')
    <div class="card-header">
        <h5 class="card-title mb-0">Action Logs</h5>
    </div>
    <table class="table table-hover  " id="datatables-buttons" style="width: 100%; ">
        <thead>
            <tr>
                <th>#</th>
                <th>Action</th>
                <th>Date And Time</th>
            </tr>
        </thead>
    </table>
</div>