@extends('systems.lls_whip.whip.' . session('user_type') . '.layout.' . session('user_type') . '_master')
@section('title', $title)
@section('content')
@include('systems.lls_whip.whip.both.projects.add_new.sections.form')
@endsection
@section('js')
@include('systems.lls_whip.includes.custom_js.location_js')
@include('systems.lls_whip.includes.custom_js.typeahead_search_contractor')
<script>

    $('#add_form').on('submit', function (e) {
        e.preventDefault();
        if($('input[name=contractor_id]').val() == null){
            toast_message_error('Please Seach Contractor');
        }else {
            table = null;
        $(this).find('button').prop('disabled', true);
        $(this).find('button').html('<span class="loader"></span>')
        var url = '/user/act/whip/insert-project';
        let form = $(this);
        _insertAjax(url, form, table);
        }
       

    });

    $(".numbers").keyup(function (e) {
      checkNumbersOnly($(this));
   });

   function checkNumbersOnly(myfield) {
      if (/[^\d\.]/g.test(myfield.val())) {
         myfield.val(myfield.val().replace(/[^\d\.]/g, ''));
      }
   }


</script>
@endsection