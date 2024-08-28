<div class="card flex-fill p-3">
    @include('components.dts.filter_by_month')
    <hr>
    <p class="text-danger ">*This month Actions</p>
    <table class="table table-hover  " id="datatables-buttons" style="width: 100%; ">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Action</th>
                <th>Type</th>
                <th>Date And Time</th>

            </tr>
        </thead>

    </table>
</div>