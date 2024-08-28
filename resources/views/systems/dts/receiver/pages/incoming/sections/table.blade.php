<div class="card flex-fill p-3">
    <div class="card-header">
        <button class="btn btn-success " id="complete">Complete</button>
        <a class="ml-2" href="{{url('/receiver/dts/find-document')}}">Can't find the Document?</a>
    </div>
    <table class="table table-hover table-striped " id="datatable_with_select" style="width: 100%; ">
        <thead>
            <tr>
                <th></th>
                
                <th>#</th>
                <th>Tracking Number</th>
                <th>Document Name</th>
                <th>From</th>
                <th>Document Type</th>
                <th>Remarks</th>
                <th>Released Date - Time</th>

            </tr>
        </thead>
      

    </table>
</div>