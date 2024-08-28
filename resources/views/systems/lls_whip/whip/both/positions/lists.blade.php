@extends('systems.lls_whip.whip.' . session('user_type') . '.layout.' . session('user_type') . '_master')
@section('title', $title)
@section('content')
<div class="notika-status-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-7 col-md-7 col-sm-7 col-xs-12">
                @include('systems.lls_whip.both.positions.table')
            </div>
            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                @include('systems.lls_whip.both.positions.add_update_position')
            </div>
        </div>
    </div>
</div>

@endsection
@section('js')
@include('systems.lls_whip.includes.custom_js.position_js')
<script>
    $(document).ready(function () {
        var url = "/user/act/whip/a-p";
        table = position_table(url);
    });

    $('#add_update_form').on('submit', function (e) {
        e.preventDefault();
        $(this).find('button').prop('disabled', true);
        $(this).find('button').html('<span class="loader"></span>')
        var url = '/user/act/whip/i-u-p';
        let form = $(this);
        add_update_ajax(url, form, table);

    });

</script>
@endsection