@extends('systems.rfa.admin.layout.admin_master')
@section('title', $title)
@section('content')
<div class="main-content-inner">
    <div class="row">
        <div class="col-12 mt-5">
            <div class="card" style="border: 1px solid;">
                <div class="card-body">
                    @include('components.pmas_rfa.report_filter')
                    @include('systems.rfa.admin.pages.report.sections.table')
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
@include('systems.rfa.includes.custom_js.date_range_filter_js')
<script>
$(document).on('click', 'button#generate-rfa-report', function (e) {
   var date_filter = $('input[name="daterange_completed_filter"]').val();
   $('#completed_transactions_table').DataTable().destroy();
   generate_rfa_report(date_filter);
});
$(document).on('click', 'button#close_rfa_report_section', function (e) {
   $('#generate_rfa_report_section').attr("hidden", true);
});

function generate_rfa_report(date_filter) {
   $.ajax({
      url: base_url + '/admin/act/rfa/generate-rfa-report',
      type: "POST",
      data: {
         date_filter,
      },
      dataType: "json",
      beforeSend: function () {
         $('#generate-rfa-report').html('Fetching Data...');
      },
      headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
      success: function (data) {
         $('#generate-rfa-report').html('Generate Report');
         $('#generate_rfa_report_section').removeAttr('hidden');
         $('#completed_transactions_table').DataTable({
            "ordering": false,
            "paging": true,
            search: true,
            autoWidth: true,
            responsive: false,
            "data": data,
            "dom": "<'row'<'col-sm-12 col-md-4'l><'col-sm-12 col-md-4'B><'col-sm-12 col-md-4'f>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
            buttons: [{
               extend: 'excel',
               text: 'Excel',
               className: 'btn btn-default ',
               footer: true,
               exportOptions: {
                  columns: 'th:not(:last-child)'
               }
            }, {
               extend: 'pdf',
               text: 'pdf',
               className: 'btn btn-default',
               footer: true,
               exportOptions: {
                  columns: 'th:not(:last-child)'
               }
            }, {
               extend: 'print',
               text: 'print',
               className: 'btn btn-default',
               footer: true,
               exportOptions: {
                  columns: 'th:not(:last-child)'
               }
            }, ],
            'columns': [{
               data: null,
               render: function (data, type, row) {
                  return '<span href="javascript:;"    style="color: #000;" >' + data['ref_number'] + '</span>';
               }
            }, {
               data: null,
               render: function (data, type, row) {
                  return '<a href="javascript:;"       style="color: #000;"  >' + data['name'] + '</a>';
               }
            }, {
               data: null,
               render: function (data, type, row) {
                  return '<a href="javascript:;"       style="color: #000;"  >' + data['address'] + '</a>';
               }
            }, {
               data: null,
               render: function (data, type, row) {
                  return '<a href="javascript:;"       style="color: #000;"  >' + data['type_of_request_name'] + '</a>';
               }
            }, {
               data: null,
               render: function (data, type, row) {
                  return '<a href="javascript:;"       style="color: #000;"  >' + data['type_of_transaction'] + '</a>';
               }
            }, {
               data: null,
               render: function (data, type, row) {
                  return '<ul class="d-flex justify-content-center">\ <li><a href="'+base_url+'/admin/rfa/view-rfa/'+data['rfa_id'] +'" data-id="' + data['rfa_id'] + '"   id=""  class="text-secondary action-icon"><i class="ti-eye"></i></a></li>\ </ul>';
               }
            }, ],
         })
      }
   })
}
</script>
@endsection