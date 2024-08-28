<script>
    $('#complete_form').on('submit', function (e) {
        e.preventDefault();
        // 
        var form = $(this).serialize();
        Swal.fire({
            title: "Are you sure?",
            text: "",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Complete Document"
        }).then((result) => {
            if (result.isConfirmed) {
                $(this).find('button').prop('disabled', true);
                $(this).find('button').html('<div class="spinner-border text-info" role="status"><span class="sr-only">Loading...</span></div>');
                let form = $(this);
                var url = '/user/act/dts/complete-docs';
                _insertAjax(url, form, table);
                bsOffcanvas.hide();
            }
        });
    });
</script>