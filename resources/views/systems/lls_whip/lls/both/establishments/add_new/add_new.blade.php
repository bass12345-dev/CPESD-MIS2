@extends('systems.lls_whip.lls.user.layout.user_master')
@section('title', $title)
@section('content')
@include('systems.lls_whip.lls.both.establishments.add_new.sections.form')
@endsection
@section('js')
<script>
    $('#add_form').on('submit', function(e){
        e.preventDefault();
        table = null;
        $(this).find('button').prop('disabled',true);
        $(this).find('button').html('<span class="loader"></span>')
        var url = '/user/act/lls/insert-es';
        let form = $(this);
        _insertAjax(url,form,table);
    });
</script>
@endsection