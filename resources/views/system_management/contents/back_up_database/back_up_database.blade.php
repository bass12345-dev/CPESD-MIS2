@extends('system_management.layout.system_master')
@section('title', $title)
@section('content')
@include('global_includes.title')
<div class="card flex-fill p-3">
    <div class="card-header">
        <div class="card-header d-flex">
            <button class="btn btn-success" id="back-up-db">Back Up Now</button>
        </div>
        <div class="card flex-fill p-3" id="samp">
            <div class="card-header">
                <h5 class="card-title mb-0">Final Actions</h5>
            </div>
            <table class="table table-hover  " id="datatables" style="width: 100%; ">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>File Name</th>
                        <th>Size (in bytes) </th>
                        <th>Modified Time</th>
                        <th>Actions</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

</div>

@endsection
@section('js')
<script>

document.addEventListener("DOMContentLoaded", function() {
      table = $("#datatables").DataTable({
         responsive: true,
         ordering: false,
         processing: true,
         pageLength: 25,
         language: {
            "processing": '<div class="d-flex justify-content-center "> <img class="top-logo mt-4" src="{{asset("assets/img/dts/peso_logo.png")}}"></div>'
         },
         "dom": "<'row'<'col-sm-12 col-md-4'l><'col-sm-12 col-md-4'B><'col-sm-12 col-md-4'f>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
         buttons: datatables_buttons(),
         ajax: {
            url: base_url + "/admin/sysm/act/get-databases",
            method: 'GET',
            headers: {
               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            dataSrc: ""
         },
         columns: [{
            data: 'i'
         }, {
            data: 'file_name'
         }, {
            data: 'file_size'
         }, {
            data: 'modified_time'
         }, {
            data: 'i'
         } ],
         columnDefs: [
            {
               targets: -1,
               data: null,
               render: function(data, type, row) {
                  var button1 =  '<li class="dropdown-item "><a href="https://drive.google.com/file/d/'+row.file_id+'/view"  target="_blank">View</a></li>' ;
                  var button2 = '<li class="dropdown-item "><a href="https://drive.google.com/uc?export=download&id='+row.file_id+'"  target="_blank">Download</a></li> ' ;
                  return ' <div class="btn-group dropstart">\
                        <i class="fa fa-ellipsis-v " class="dropdown-toggle" data-bs-toggle="dropdown"aria-expanded="false"></i>\
                        <ul class="dropdown-menu">' + button1 + ' ' + button2 + '</ul></div>';
               }
            }


         ],
         
      });
   });
    document.getElementById('back-up-db').addEventListener('click', function() {

        loader();
        fetch(base_url + '/admin/sysm/act/back-up-db')
            .then(response => response.json())
            .then(data => {
                if (data) {
                    JsLoadingOverlay.hide();
                    toast_message_success(data.message)
                    table.ajax.reload()
                }

                // document.getElementById('message').innerText = data.message;
            })
            .catch(error => {
                console.error('There was an error:', error);
                // document.getElementById('message').innerText = 'Error occurred during backup.';
            });
    });
</script>
@endsection