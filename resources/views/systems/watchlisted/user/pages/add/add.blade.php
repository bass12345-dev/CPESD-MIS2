@extends('systems.watchlisted.user.layout.user_master')
@section('title', $title)
@section('content')
@include('global_includes.title')
@include('systems.watchlisted.both.add.add_form')
@endsection
@section('js')
@include('systems.watchlisted.includes.custom_js.add_js')
@endsection