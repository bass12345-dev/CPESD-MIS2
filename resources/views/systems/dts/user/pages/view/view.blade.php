@extends('systems.dts.user.layout.user_master')
@section('title', $title)
@section('content')
@include('global_includes.title')
<div class="row">
    <div class="col-12 col-md-12">
        @include('systems.dts.both.view.sections.document_information')
    </div>
</div>

<div class="row">
    <div class="col-12  col-md-12 ">
        @include('systems.dts.both.view.sections.history')
    </div>
</div>
@endsection
@section('js')
<script>

</script>
@endsection