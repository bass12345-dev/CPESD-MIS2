@extends('systems.lls_whip.whip.admin.layout.admin_master')
@section('title', $title)
@section('content')
@include('systems.lls_whip.whip.admin.pages.dashboard.sections.count1')
@include('systems.lls_whip.whip.both.dashboard.contractors_table')
@endsection
@section('js')
@endsection