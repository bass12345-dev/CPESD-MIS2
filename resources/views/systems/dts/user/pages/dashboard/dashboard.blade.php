@extends('systems.dts.user.layout.user_master')
@section('title', $title)
@section('content')
@include('global_includes.title')
@include('systems.dts.user.pages.dashboard.sections.display1')
@include('systems.dts.user.pages.dashboard.sections.display2')
@endsection
@section('js')
<script>

</script>
@endsection