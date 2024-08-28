@extends('systems.dts.receiver.layout.receiver_master')
@section('title', $title)
@section('content')
@include('global_includes.title')
@include('systems.dts.receiver.pages.dashboard.sections.display1')
@include('systems.dts.receiver.pages.dashboard.sections.display2')
@endsection
@section('js')
<script>

</script>
@endsection