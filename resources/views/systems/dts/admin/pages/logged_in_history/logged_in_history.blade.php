@extends('systems.dts.admin.layout.admin_master')
@section('title', $title)
@section('content')
@include('global_includes.title')
@include('systems.dts.admin.pages.logged_in_history.sections.table')
@endsection
@section('js')
@include('global_includes.js.custom_js.select_by_month')
<script>
var search = function(month) {
        var add_to_url = '';
        if (month != null) {
            add_to_url = '?date=' + month
        }

        table = $("#datatables-buttons").DataTable({
            responsive: true,
            ordering: false,
            processing: true,
            pageLength: 25,
            destroy: true,
            language: {
                "processing": '<div class="d-flex justify-content-center ">' + table_image_loader + '</div>'
            },
            "dom": "<'row'<'col-sm-12 col-md-4'l><'col-sm-12 col-md-4'B><'col-sm-12 col-md-4'f>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
            buttons: datatables_buttons(),
            ajax: {
                url: base_url + "/admin/act/dts/logged-in-history" + add_to_url,
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                dataSrc: "",
                error: function (xhr, textStatus, errorThrown) {
                    toast_message_error('Documents is not displaying... Please Reload the Page Or Contact the developer')
               }
            },

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

    };

    $(document).ready(function() {
        search(month);
    });
</script>
@endsection