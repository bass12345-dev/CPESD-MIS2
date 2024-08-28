@extends('systems.dts.user.layout.user_master')
@section('title', $title)
@section('content')
@include('global_includes.title')

<div class="row">
   <div class="col-md-12 col-12   ">
        @include('systems.dts.user.pages.received.sections.table')
   </div>
</div>
@include('systems.dts.user.pages.received.modal.forward_modal')
@include('systems.dts.user.pages.received.modal.outgoing_modal')
@include('systems.dts.includes.components.final_action_off_canvas')

@endsection
@section('js')
<script>
   
document.addEventListener("DOMContentLoaded", function () {
   table = $("#datatable_with_select").DataTable({
      responsive: true,
      ordering: false,
      processing: true,
      pageLength: 25,
      language: {
         "processing": '<div class="d-flex justify-content-center ">'+table_image_loader+'</div>'
      },
      "dom": "<'row'<'col-sm-12 col-md-4'l><'col-sm-12 col-md-4'B><'col-sm-12 col-md-4'f>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
      buttons: datatables_buttons(),
      ajax: {
         url: base_url + "/user/act/dts/received-documents",
         method: 'GET',
         headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
         },
         dataSrc: "",
         error: function (xhr, textStatus, errorThrown) {
                    toast_message_error('Documents is not displaying... Please Reload the Page Or Contact the developer')
               }
      },
      columns: [{
         data: 'his_tn'
      }, {
         data: 'number'
      }, {
         data: 'tracking_number'
      }, {
         data: null
      }, {
         data: 'type_name'
      }, {
         data: 'remarks'
      }, {
         data: 'received_date'
      }, ],
      'select': {
         'style': 'multi',
      },
      columnDefs: [{
         'targets': 0,
         'checkboxes': {
            'selectRow': true
         },
      }, {
         targets: 3,
         data: null,
         render: function (data, type, row) {
            return view_document(row);
         }
      }]
   });
});

$(document).on('click', 'button#multiple_forward', function(){
   let array = get_select_items_datatable();
   let html = '';
   if (array.length > 0) {
      $('#forward_modal').modal('show');
      $('input[name=history_track1]').val(array);
      array.forEach(element => {
         const myArray = element.split("-");
         const first = myArray[0];
         const second = myArray[1];
         html += '<li class="text-danger h3">' + second + '</li>';
      });
      $('.display_tracking_number').html(html);
   } else {
      toast_message_error('Please Select at least One')
   }
});
$('#forward_form2').on('submit', function (e) {
   e.preventDefault();
   var form = $(this).serialize();
   Swal.fire({
      title: "Are you sure?",
      text: "",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Foward Document"
   }).then((result) => {
      if (result.isConfirmed) {
         $(this).find('button').prop('disabled', true);
         $(this).find('button').html('<div class="spinner-border text-info" role="status"><span class="sr-only">Loading...</span></div>');
         var url = '/user/act/dts/forward-documents';
         let form = $(this);
         _insertAjax(url, form, table);
         $('#forward_modal').modal('hide');
         $('#forward_form2')[0].reset();
      }
   });
});


$(document).on('click', 'button#received_error', function(){
   selected_items = get_select_items_datatable();
   if (selected_items.length == 0) {
      toast_message_error('Please Select at least One')
   } else {
      var url = '/user/act/dts/receive-errors';
      let form = {
         items: selected_items
      };
      delete_item(form, url, button_text = 'Submit', text = 'The documents that you\'ve selected will be back to incoming section',table);
   }
});


$(document).on('click', 'button#outgoing', function(){
   let array = get_select_items_datatable();
   let html = '';
   if (array.length > 0) {
      $('#outgoing_modal').modal('show');
      $('input[name=history_track2]').val(array);
      array.forEach(element => {
         const myArray = element.split("-");
         const first = myArray[0];
         const second = myArray[1];
         html += '<li class="text-danger h3">' + second + '</li>';
      });
      $('.display_tracking_number1').html(html);
   } else {
      toast_message_error('Please Select at least One')
   }
});

$('#outgoing_form').on('submit', function (e) {
   e.preventDefault();
   var form = $(this).serialize();
   Swal.fire({
      title: "Are you sure?",
      text: "",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Submit"
   }).then((result) => {
      if (result.isConfirmed) {
         $(this).find('button').prop('disabled', true);
         $(this).find('button').html('<div class="spinner-border text-info" role="status"><span class="sr-only">Loading...</span></div>');
         var url = '/user/act/dts/outgoing-documents';
         let form = $(this);
         _insertAjax(url, form, table);
         $('#outgoing_modal').modal('hide');
         $('#outgoing_form')[0].reset();
      }
   });
});

var myOffcanvas = document.getElementById('offcanvasExample1');
var bsOffcanvas = new bootstrap.Offcanvas(myOffcanvas);


$(document).on('click', 'button#complete', function(){
   let array = get_select_items_datatable();
   let html = '';
   
   if (array.length > 0) {
      bsOffcanvas.show();
      $('input[name=c_t_number]').val(array);
      $('input[name=user_type]').val('user');
      array.forEach(element => {
         const myArray = element.split("-");
         const first = myArray[0];
         const second = myArray[1];
         html += '<li class="text-danger h3">' + second + '</li>';
      });
      $('.display_tracking_number2').html(html);
   } else {
      alert('Please Select at least one');
   }
});



</script>
@include('systems.dts.includes.custom_js.complete_action')
@endsection