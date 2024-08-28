@extends('systems.dts.admin.layout.admin_master')
@section('title', $title)
@section('content')
@include('global_includes.title')
@include('systems.dts.user.pages.search_documents.sections.search_form')
@include('systems.dts.user.pages.search_documents.sections.result')
@endsection
@section('js')
@include('systems.dts.includes.custom_js.search_action')
@endsection