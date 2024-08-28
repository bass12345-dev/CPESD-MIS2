@extends('system_management.layout.system_master')
@section('title', $title)
@section('content')
@include('global_includes.title')
@include('system_management.contents.login_history.sections.table')
@endsection
@section('js')
<script>
var month = $('input[name=month]').val();
jSuites.calendar(document.getElementById('calendar'), {
    type: 'year-month-picker',
    format: 'MMMM-YYYY',
});
$(document).on('click', '#by-month', function() {
    month = $('input[name=month]').val();
    show_logs(month);
});

$(document).on('click', '#all_data', function() {
    show_logs(month = null);
});

let show_logs = function (month) {
      var add_to_url='';
      if(month!=null){
         add_to_url = '?m='+month
      }
      loader();
      $.ajax({
         type: "GET",
         url: base_url + "/admin/sysm/act/g-a-l-l"+add_to_url,
         headers: {
                     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                  },
         datatype: "json",
         traditional: true
      }).done(function (data) {
         JsLoadingOverlay.hide();
            table = $("#datatables").DataTable({
               responsive: true,
               ordering: false,
               processing: true,
               pageLength: 25,
               destroy: true,
               language: {
                  "processing": '<div class="d-flex justify-content-center "> <img class="top-logo mt-4" src="{{asset("assets/img/peso_logo.png")}}"></div>'
               },
               "dom": "<'row'<'col-sm-12 col-md-4'l><'col-sm-12 col-md-4'B><'col-sm-12 col-md-4'f>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
               buttons: datatables_buttons(),
               data: data,
               columns: [
                  {
                     data: 'number',
                  },
                  {
                     data: 'name',
                  },
                  {
                     data: 'datetime'
                  },

               ],
            });


         });
   };

$(document).ready(function(){
   show_logs(month);
});
</script>
@endsection