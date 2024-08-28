<script>

function datatables_loader(){
    return {
            "processing": '<div class="d-flex justify-content-center "><img class="top-logo mt-4" src="{{asset("assets/img/dts/peso_logo.png")}}"></div>'
        }
}
function datatables_buttons() {
    return [{
            extend: 'copy',
            text: 'Copy',
            className: 'btn btn-warning rounded-pill ',
            footer: true,
            exportOptions: {
                columns: 'th:not(:last-child)',

            }
        },
        {
            extend: 'print',
            text: 'Print',
            className: 'btn btn-info rounded-pill  ms-2',
            footer: true,
            exportOptions: {
                columns: 'th:not(:last-child)'
            }
        }, {
            extend: 'csv',
            text: 'CSV',
            className: 'btn btn-success rounded-pill ms-2',
            footer: true,
            exportOptions: {
                columns: 'th:not(:last-child)',
            }
        },
    ];

}


function get_select_items_datatable(){
    var rows_selected = table.column(0).checkboxes.selected();
      let arr = [];
      $.each(rows_selected, function(index, rowId){
           arr.push(rowId);
      });

     return arr;
}

</script>