
@extends('systems.lls_whip.whip.user.layout.user_master')
@section('title', $title)
@section('content')
<div class="notika-status-area">
    <div class="container">
        @include('components.lls.header_title_container')
        @include('systems.lls_whip.whip.user.pages.project_monitoring.report.sections.top_information')
    </div>
</div>
@endsection
@section('js')
<script>

</script>
@endsection