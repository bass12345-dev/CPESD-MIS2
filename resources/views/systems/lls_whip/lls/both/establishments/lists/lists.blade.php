@extends('systems.lls_whip.lls.user.layout.user_master')
@section('title', $title)
@section('content')
@include('systems.lls_whip.lls.both.establishments.lists.sections.table')
@endsection
@section('js')
<script>
    $(document).ready(function() {
   
   table =  $('#data-table-basic').DataTable({
        responsive: true,
        ordering: false,
        processing: true,
        searchDelay: 500,
        pageLength: 25,
        language: {
            "processing": '<div class="d-flex justify-content-center "><img class="top-logo mt-4" src="{{asset("assets/img/dts/peso_logo.png")}}"></div>'
        },
        "dom": "<'row'<'col-sm-12 col-md-4'l><'col-sm-12 col-md-4'B><'col-sm-12 col-md-4'f>>" +
            "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
        buttons : datatables_buttons(),
        ajax: {
            url: base_url + "/user/act/lls/g-a-e",
            method: 'GET',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            dataSrc: ""
        },
        columns: [
            {
                data: 'establishment_id'
            },{
                data: 'establishment_code'
            }, {
                data: null
            },
            {
                data: 'full_address'
            },
            {
                data: 'contact_number'
            }, {
                data: 'email_address'
            }, {
                data: 'authorized_personnel'
            }, {
                data: 'position'
            },
            {
                data: null
            },
        ],
        'select': {
            'style': 'multi',
        },
        columnDefs: [{
                'targets': 0,
                'checkboxes': {
                    'selectRow': true
                }
            },
            {
                targets: -1,
                data: null,
                orderable: false,
                className: 'text-center',
                render: function(data, type, row) {
                    return row.status == 'active' ?
                        '<span class="badge notika-bg-success">Active</span>' :
                        '<span class="badge notika-bg-danger">Inactive</span>';
                }
            },
            {
                targets: 2,
                data: null,
                orderable: false,
                className: 'text-center',
                render: function(data, type, row) {
                    return '<a href="' + base_url + '/user/lls/establishment/' + row
                        .establishment_id + '">' + row.establishment_name + '</a>'
                }
            }
        ]

    });
});

$('button#multi-delete').on('click', function() {

    var button_text = 'Delete selected items';
    var text = '';
    var url = '/user/act/lls/d-e';
    let items = get_select_items_datatable();
    var data = {
        id: items,
    };

    if (items.length == 0) {
        toast_message_error('Please Select at Least One')
    } else {
        delete_item(data, url, button_text, text, table);
        
 
    }

});
</script>

@endsection