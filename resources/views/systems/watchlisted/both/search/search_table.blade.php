<div class="card flex-fill p-3">
    <img src="{{ asset('assets/img/dts/search.jpg') }}" id="search_image">
    <div id="search" hidden>
        <div class="card-header">
            <h5 class="card-title mb-2 text-danger" id="count_result"></h5>

        </div>
        <table class="table table-hover table-striped " id="datatables-buttons" style="width: 100%; ">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Age</th>
                    <th>Address</th>
                    <th>Email</th>
                    <th>Phone Number</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
        </table>
    </div>
</div>