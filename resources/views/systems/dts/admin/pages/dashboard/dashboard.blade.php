@extends('systems.dts.admin.layout.admin_master')
@section('title', $title)
@section('content')
@include('global_includes.title')
@include('systems.dts.admin.pages.dashboard.sections.display1')
@include('systems.dts.admin.pages.dashboard.sections.display2')
@endsection
@section('js')
<script>

</script>
@endsection