
@extends('systems.lls_whip.whip.'.session('user_type').'.layout.'.session('user_type').'_master')
@section('title', $title)
@section('content')
@include('systems.lls_whip.whip.both.contractors.add_new.sections.form')
@endsection
@section('js')
@include('systems.lls_whip.includes.custom_js.location_js')
<script>
    $('#add_form').on('submit', function(e){
        e.preventDefault();
        table = null;
        $(this).find('button').prop('disabled',true);
        $(this).find('button').html('<span class="loader"></span>')
        var url = '/user/act/whip/insert-contractor';
        let form = $(this);
        _insertAjax(url,form,table);

    });
    
</script>
@endsection