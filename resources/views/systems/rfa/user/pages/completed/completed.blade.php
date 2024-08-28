@extends('systems.rfa.user.layout.user_master')
@section('title', $title)
@section('content')
<div class="main-content-inner">
    <div class="row">
        <div class="col-12 mt-5">
            <div class="card" style="border: 1px solid;">
                <div class="card-body">

                    <div class="row">
                        @include('systems.rfa.user.pages.completed.sections.table')
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection
@section('js')
<script>
$('#rfa_completed_table').DataTable({
   responsive: false,
   "ordering": false,
   "ajax": {
      "url": base_url + '/user/act/rfa/get-user-completed-rfa',
      "type": "GET",
      "dataSrc": "",
   },
   'columns': [{
      data: "ref_number",
   }, {
      data: "name",
   }, {
      data: "address",
   }, {
      data: "type_of_request_name",
   }, {
      data: "type_of_transaction",
   }, {
      data: null,
      render: function (data, type, row) {
         return '<ul class="d-flex justify-content-center">\ <li><a href="'+base_url+'/user/rfa/view-rfa/'+data['rfa_id']+'" data-id="' + data['rfa_id'] + '"   class="text-secondary action-icon"><i class="ti-eye"></i></a></li>\ </ul>';
      }
   }, ]
});

</script>
@endsection