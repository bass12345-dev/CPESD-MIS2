@extends('systems.rfa.user.layout.user_master')
@section('title', $title)
@section('content')
<div class="main-content-inner">
    <div class="row">
        <div class="col-12 mt-5">
            <div class="card" style="border: 1px solid;">
                <div class="card-body">

                    <div class="row">
                        @include('systems.rfa.user.pages.clients.sections.table')
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>


@endsection
@section('js')
<script>
var rfa_clients_table = $('#rfa_clients_table').DataTable({
   responsive: false,
   "ajax": {
      "url": base_url + '/user/act/rfa/get-my-clients',
      "type": "GET",
      "dataSrc": "",
   },
   'columns': [{
      data: "full_name",
   }, {
      data: "address",
   }, {
      data: "contact_number",
   }, {
      data: "age",
   }, {
      data: null,
      render :function(row){
         return row.gender == '' ? '<span class="text-danger">Please Update Gender</span>' : capitalizeFirstLetter(row.gender)
      }
   }, {
      data: "employment_status",
   },
   {
      data: "count",
   },

]
});

</script>
@endsection