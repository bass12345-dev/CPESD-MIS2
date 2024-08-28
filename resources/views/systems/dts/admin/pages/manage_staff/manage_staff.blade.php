@extends('systems.dts.admin.layout.admin_master')
@section('title', $title)
@section('content')
@include('global_includes.title')
@include('systems.dts.admin.pages.manage_staff.sections.set_receiver_form')
@include('systems.dts.admin.pages.manage_staff.sections.set_oic_form')
@endsection
@section('js')
<script>

    function get_receiver() {
        const xhr = new XMLHttpRequest();
        xhr.open("GET", base_url + "/admin/act/dts/g-c-r");
        xhr.send();
        xhr.responseType = "json";
        xhr.onload = () => {
            if (xhr.status == 200) {
                $('h2.receiver_name').html(xhr.response.full_name);
                $('form#update_receiver_form').find('select[name=user_id]').val(xhr.response.user_id);
                $('input[name=receiver_id]').val(xhr.response.user_id);
            } else {
                console.log(`Error: ${xhr.status}`);
            }
        };
    }

    function get_oic() {
        const xhr = new XMLHttpRequest();
        xhr.open("GET", base_url + "/admin/act/dts/g-c-oic");
        xhr.send();
        xhr.responseType = "json";
        xhr.onload = () => {
            if (xhr.status == 200) {
                $('h2.oic_name').html(xhr.response.full_name);
                $('form#update_oic_form').find('select[name=user_id]').val(xhr.response.user_id);
                $('input[name=oic_id]').val(xhr.response.user_id);
            } else {
                console.log(`Error: ${xhr.status}`);
            }
        };
    }

    $('#update_receiver_form').on('submit', function (e) {
        e.preventDefault();
        $(this).find('button').prop('disabled', true);
        $(this).find('button').html('<div class="spinner-border text-info" role="status"><span class="sr-only">Loading...</span></div>')
        var url = '/admin/act/dts/update-receiver';
        let form = $(this);
        _updatetAjax(url, form, table);
        setTimeout(() => {
            get_receiver();
        }, 1000);
        
        
    });

    $('#update_oic_form').on('submit', function (e) {
        e.preventDefault();
        $(this).find('button').prop('disabled', true);
        $(this).find('button').html('<div class="spinner-border text-info" role="status"><span class="sr-only">Loading...</span></div>')
        var url = '/admin/act/dts/update-oic';
        let form = $(this);
        _updatetAjax(url, form, table);
        setTimeout(() => {
            get_oic();
        }, 1000);
        
    });


    get_oic();
    get_receiver();
</script>
@endsection