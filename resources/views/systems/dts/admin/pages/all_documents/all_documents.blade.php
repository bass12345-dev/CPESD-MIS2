@extends('systems.dts.admin.layout.admin_master')
@section('title', $title)
@section('content')
@include('global_includes.title')
@include('systems.dts.admin.pages.all_documents.sections.table')
@include('systems.dts.includes.components.final_action_off_canvas')
@include('systems.dts.user.pages.my_documents.modals.cancel_modal')
@endsection
@section('js')
@include('global_includes.js.custom_js.select_by_month')
<script>
   var search = function (month) {
      var add_to_url = '';
      if (month != null) {
         add_to_url = '?date=' + month
      }

      table = $("#datatable_with_select").DataTable({
         responsive: true,
         ordering: false,
         processing: true,
         pageLength: 25,
         language: {
            "processing": '<div class="d-flex justify-content-center ">' + table_image_loader + '</div>'
         },
         "dom": "<'row'<'col-sm-12 col-md-4'l><'col-sm-12 col-md-4'B><'col-sm-12 col-md-4'f>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
         buttons: datatables_buttons(),
         ajax: {
            url: base_url + "/admin/act/dts/all-documents" + add_to_url,
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
            data: 'data'
         }, {
            data: 'number'
         }, {
            data: 'tracking_number'
         }, {
            data: null
         }, {
            data: 'type_name'
         }, {
            data: 'created'
         }, {
            data: 'history_status'
         }, {
            data: null
         },],
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
            render: function(data, type, row) {
                  return '<a href="' + base_url + '/admin/dts/view?tn=' + row.tracking_number + '" data-toggle="tooltip" data-placement="top" title="View ' + row.tracking_number + '">' + row.document_name + '</a>';
               }
         },
         {
            targets: -2,
            data: null,
            render: function (data, type, row) {
               var status;
               switch (row.history_status) {
                  case 'completed':
                     status = '<span class="badge p-2 bg-success">Completed</span>';
                     break;
                  case 'pending':
                     status = '<span class="badge p-2 bg-danger">Pending</span>';
                     break;
                  case 'cancelled':
                     status = '<span class="badge p-2 bg-warning">Canceled</span>';
                     break;
                  case 'outgoing':
                     status = '<span class="badge p-2 bg-secondary">Outgoing</span>';
                     break;

                  default:
                     break;
               }
               return status;
            }
         },
         {
            targets: -1,
            data: null,
            render: function (data, type, row) {
               var html = '';
               if (row.history_status != 'completed' && row.history_status != 'outgoing') {

                  html += '<div class="btn-group dropstart">\
                            <i class="fa fa-ellipsis-v " class="dropdown-toggle"  data-bs-toggle="dropdown" aria-expanded="false"></i>\
                            <ul class="dropdown-menu">';
                  if (row.history_status != 'pending' && row.history_status == 'cancelled') {

                     html += '<li><a class="dropdown-item" id="revert_document" href="#" data-history-id="' + row.history_id + '"\
                  data-tracking-number="' + row.tracking_number + '">Revert</a></li>';
                  }

                  if (row.history_status != 'completed' && row.history_status == 'pending' && row.history_status != 'cancelled') {
                     html += '<li><a class="dropdown-item" id="forward_icon" href="#" data-history-id="' + row.history_id + '"\
                  data-tracking-number="' + row.tracking_number + '" >Complete Document</a></li>';
                  }

               }

               return html;
            }
         }

         ],
         initComplete: function () {

            var column = table.column(6);
            let select = document.createElement('select');
            select.className = "form-select";
            select.add(new Option(''));
            column.header().replaceChildren(select);
            //   this.api()
            //       .columns()
            //       .every(function () {
            //           let column = this;

            //           // Create select element
            //           let select = document.createElement('select');
            //           select.add(new Option(''));
            //           column.footer().replaceChildren(select);

            //           // Apply listener for user change in value
            select.addEventListener('change', function () {
               column
                  .search(select.value, {
                     exact: true
                  })
                  .draw();
            });

            // Add list of options
            column
               .data()
               .unique()
               .sort()
               .each(function (d, j) {
                  select.add(new Option(d));
               });
            // });
         }
      });

   }
   $(document).ready(function () {
      search(month);
   });

   $('button#delete').on('click', function () {


      var rows_selected = table.column(0).checkboxes.selected();
      if (rows_selected.length == 0) {
         toast_message_error('Please Select at least One')
      } else {
         var button_text = 'Delete selected items';
         var text = 'Document History will be deleted also';
         var url = '/admin/act/dts/delete-documents';
         let arr = [];
         $.each(rows_selected, function (index, rowId) {
            const myArray = rowId.split(",");
            arr.push(myArray[8]);
         });
         var data = { id: arr };
         delete_item(data, url, button_text, text = '', table);
      }

   });



   $(document).on('click', 'a#cancel_documents', function (e) {

      var rows_selected = get_select_items_datatable();
      let html = '';
      let arr = [];

      if (rows_selected.length == 0) {
         toast_message_error('Please Select at least One')
      } else {
         $('#cancel_document_modal').modal('show');
         $('input[name=user_type]').val('admin');
         rows_selected.forEach(element => {
            const myArray = element.split(",");
            const first = myArray[0];
            const second = myArray[1];
            arr.push(myArray[8]);
            html += '<li class="text-danger h3">' + second + '</li>';
         });

         $('input[name=document_ids]').val(arr);
         $('.display_tracking_number').html(html);
      }
   });




   $(document).on('click', 'a#forward_icon', function () {
      $('input[name=id]').val($(this).data('history-id'));
      $('input[name=t_number]').val($(this).data('tracking-number'));
      $('.offcanvas-title').text('Document #' + $(this).data('tracking-number'))
   });

   var myOffcanvas = document.getElementById('offcanvasExample1');
   var bsOffcanvas = new bootstrap.Offcanvas(myOffcanvas);

   $(document).on('click', 'button#complete', function () {
      let array = get_select_items_datatable();
      let html = '';
      let arr = [];
      if (array.length > 0) {
         bsOffcanvas.show();

         $('input[name=user_type]').val('admin');
         array.forEach(element => {
            const myArray = element.split(",");
            const first = myArray[0];
            const second = myArray[1];
            arr.push(myArray[9] + '-' + second);
            
            html += '<li class="text-danger h3">' + second + '</li>';
         });
         $('input[name=c_t_number]').val(arr);
         $('.display_tracking_number2').html(html);
      } else {
         toast_message_error('Please Select at least One')
      }
   });


   $(document).on('click', 'a#forward_icon', function () {
      $('input[name=c_t_number]').val($(this).data('history-id') + '-' + $(this).data('tracking-number'));
      $('.offcanvas-title').text('Document #' + $(this).data('tracking-number'))
      bsOffcanvas.show();
   });


   $(document).on('click', 'a#revert_document', function () {
      var t = $(this).data('tracking-number');

      let form = { t: t }
      var url = '/admin/act/dts/revert-document';

      Swal.fire({
         title: "Are you sure?",
         text: "",
         icon: "warning",
         showCancelButton: true,
         confirmButtonColor: "#3085d6",
         cancelButtonColor: "#d33",
         confirmButtonText: "Revert Document #" + t
      }).then((result) => {
         if (result.isConfirmed) {
            $.ajax({
               url: base_url + url,
               method: 'POST',
               data: form,
               dataType: 'json',
               beforeSend: function () {
                  loader();
               },
               headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
               },
               success: function (data) {
                  JsLoadingOverlay.hide();
                  if (data.response) {

                     Swal.fire({
                        position: "top-end",
                        icon: "success",
                        title: data.message,
                        showConfirmButton: false,
                        timer: 1500
                     });
                     table.ajax.reload();

                  }

               },
               error: function () {
                  alert('something Wrong');
                  location.reload();
                  JsLoadingOverlay.hide();
               }

            });

         }
      });

   });

</script>
@include('systems.dts.includes.custom_js.print_slip')
@include('systems.dts.includes.custom_js.complete_action')
@include('systems.dts.includes.custom_js.cancel_action')
@endsection