@extends('systems.lls_whip.lls.user.layout.user_master')
@section('title', $title)
@section('content')

<div class="notika-status-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                @include('systems.lls_whip.both.employees.employee_information')
            </div>
            <div class="col-lg-7 col-md-7 col-sm-7 col-xs-12">
                @include('systems.lls_whip.lls.both.employee_info.sections.job_table')
            </div>
        </div>
    </div>
    <hr>

    
</div>

@endsection
@section('js')
@include('systems.lls_whip.includes.custom_js.update_js')
@include('systems.lls_whip.includes.custom_js.update_employee_info_js')
@include('systems.lls_whip.includes.custom_js.update_info_location')
@endsection