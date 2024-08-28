@extends('systems.watchlisted.admin.layout.admin_master')
@section('title', $title)
@section('content')
@include('global_includes.title')


<div class="row">
    <div class="col-md-4">
        @include('systems.watchlisted.both.search.search_form')
    </div>
    <div class="col-md-8">
        @include('systems.watchlisted.both.search.search_table')
    </div>
</div>


@endsection
@section('js')
@include('systems.watchlisted.includes.custom_js.search_js')

@endsection