@extends('systems.pmas.user.layout.user_master')
@section('title', $title)
@section('content')
<div class="row">
    <div class="col-12 mt-5">
        <div class="card" style="border: 1px solid;">
            <div class="card-body">
               
                <div class="row">
                    @include('systems.pmas.user.pages.completed.sections.table')
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
<script>

function fetch_user_completed_transactions() {
   $.ajax({
      url: base_url + '/user/act/pmas/get-user-completed-transactions',
      type: "GET",
      dataType: "json",
      success: function (data) {
         $('#user_completed_transactions_table').DataTable({
            "ordering": false,
            "data": data,
            'columns': [{
               data: null,
               render: function (data, type, row) {
                  return '<b><a href="javascript:;"   data-id="' + data['res_center_id'] + '"  style="color: #000;"  >' + data['pmas_no'] + '</a></b>';
               }
            }, {
               data: null,
               render: function (data, type, row) {
                  return '<a href="javascript:;"   data-id="' + data['res_center_id'] + '"  style="color: #000;"  >' + data['date_and_time_filed'] + '</a>';
               }
            }, {
               data: null,
               render: function (data, type, row) {
                  return '<a href="javascript:;"   data-id="' + data['res_center_id'] + '"  style="color: #000;"  >' + data['type_of_activity_name'] + '</a>';
               }
            }, {
               data: null,
               render: function (data, type, row) {
                  return '<a href="javascript:;"   data-id="' + data['res_center_id'] + '"  style="color: #000;"  >' + data['cso_name'] + '</a>';
               }
            }, {
               data: null,
               render: function (data, type, row) {
                  return '<a href="javascript:;"   data-id="' + data['res_center_id'] + '"  style="color: #000;"  >' + data['name'] + '</a>';
               }
            }, {
               data: null,
               render: function (data, type, row) {
                  return '<ul class="d-flex justify-content-center">\ <li class="mr-3 "><a href="'+base_url+'/user/pmas/view-transaction/'+data['transaction_id']+'" class="text-secondary action-icon" data-id="' + data['transaction_id'] + '"   ><i class="fa fa-eye"></i></a></li>\ </ul>';
               }
            }]
         })
      }
   })
}
fetch_user_completed_transactions();

</script>
@endsection