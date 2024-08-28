@extends('systems.dts.user.layout.user_master')
@section('title', $title)
@section('content')
@include('global_includes.title')

<div class="row">
    <div class="col-md-12 col-12   ">
        @include('systems.dts.user.pages.outgoing.sections.table')
    </div>
</div>
@include('systems.dts.user.pages.outgoing.modals.update_outgoing_modal')
@endsection
@section('js')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        table = $("#datatables-buttons").DataTable({
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
                url: base_url + "/user/act/dts/outgoing-documents",
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
                    data: 'doc_id',
                },
                {
                    data: 'number',
                },
                {
                    data: 'tracking_number',
                },
                {
                    data: null,
                },

                {
                    data: 'office',
                },
                {
                    data: 'type_name',
                },
                {
                    data: null,
                },
                {
                    data: 'outgoing_date',
                }, {
                    data: null,
                },
            ],
            'select': {
                'style': 'multi',
            },
            columnDefs: [{
                    'targets': 0,
                    'checkboxes': {
                        'selectRow': true
                    },
                },
                {
                    targets: 6,
                    data: null,
                    render: function(data, type, row) {
                        return '<a href="javascript:;" data-remarks="' + row.remarks + '" id="view_remarks">View Remarks</a>';
                    }
                },
                {
                    targets: 3,
                    data: null,
                    render: function(data, type, row) {
                        return view_document(row);
                    }
                },
                {
                    targets: -1,
                    data: null,
                    orderable: false,
                    className: 'text-center',
                    render: function(data, type, row) {
                        return '<div class="btn-group dropstart">\
                           <i class="fa fa-ellipsis-v " class="dropdown-toggle"  data-bs-toggle="dropdown" aria-expanded="false"></i>\
                              <ul class="dropdown-menu">\
                                 <li><a class="dropdown-item " data-remarks="' + row.remarks + '" data-outgoing-id="' + row.outgoing_id + '" data-office="' + row.office_id + '" id="update_outgoing">Update</a></li>\
                              </ul>\
                           </i>\
                        </div>\
               ';



                    }
                }

            ]

        });
    });


    $(document).on('click', 'a#received_documents', function() {
        selected_items = get_select_items_datatable();
        if (selected_items.length == 0) {
            toast_message_error('Please Select at least One')
        } else {
            var url = '/user/act/dts/r-f-o';
            let form = {
                items: selected_items
            };
            delete_item(form, url, button_text = 'Receive Document', text = '', table);

        }
    });


    $(document).on('click', 'a#update_outgoing', function() {
        $('#update_outgoing_modal').modal('show');
        $('textarea[name=remarks]').val($(this).data('remarks'));
        $('select[name=office]').val($(this).data('office'));
        $('input[name=outgoing_id]').val($(this).data('outgoing-id'));
    });

    $('#update_outgoing_form').on('submit', function(e) {
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
                var url = '/user/act/dts/u-o-d';
                let form = $(this);
                _insertAjax(url, form, table);
                $('#update_outgoing_form')[0].reset();
                $('#update_outgoing_modal').modal('hide');
            }
        });
    });
</script>
@endsection