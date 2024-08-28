<!doctype html>
<html class="no-js" lang="en">

<head>
    @include('global_includes.meta')
    @include('systems.rfa.includes.css')
</head>

<body>
    @include('components.pmas_rfa.preloader')
    <div class="page-container sbar_collapsed">
        <div class="main-content">
            @include('systems.rfa.includes.components.add_rfa_topbar')
            <div class="main-content-inner">
                <div class="row">
                    <div class="col-12 mt-5">
                        <div class="card border">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <button class="btn sub-button pull-right mb-3 " data-toggle="modal"
                                            data-target="#print_option_modal"><i class="fa fa-print"></i> Print</button>
                                    </div>
                                </div>
                                <div class="row">
                                    @include('systems.cso.pages.view_cso.sections.cso_information')
                                    @include('systems.cso.pages.view_cso.sections.cso_officers')
                                </div>
                                <hr>
                                @include('systems.cso.pages.view_cso.sections.projects')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('systems.cso.pages.manage_cso.modals.update_cso_status_modal')
        @include('systems.cso.pages.view_cso.modals.update_cso_information')

        @include('systems.cso.pages.view_cso.modals.add_officer_modal')
        @include('systems.cso.pages.view_cso.modals.update_officer_modal')

        @include('systems.cso.pages.view_cso.modals.add_project_modal')
        @include('systems.cso.pages.view_cso.modals.update_project_modal')

        @include('systems.cso.pages.view_cso.modals.update_cor_modal')
        @include('systems.cso.pages.view_cso.modals.view_file_modal')
</body>
</body>
@include('global_includes.js.global_js')
@include('systems.rfa.includes.js')
<script src="https://cdn.jsdelivr.net/npm/js-loading-overlay@1.1.0/dist/js-loading-overlay.min.js"></script>
@include('systems.rfa.includes.custom_js.layout_js')
@include('global_includes.js.custom_js.wizard_js')
@include('global_includes.js.custom_js.alert_loader')
@include('global_includes.js.custom_js._ajax')
@include('systems.cso.pages.view_cso.scripts.cso_js')
@include('systems.cso.pages.view_cso.scripts.officers_js')
@include('systems.cso.pages.view_cso.scripts.project_js')
@include('systems.cso.pages.view_cso.scripts.activities_js')
@include('systems.cso.pages.view_cso.scripts.file_js')
<script>
    $(document).ready(function () {
        get_cso_information();
        load_cso_officers();
        load_projects();
        load_cso_chart(year);
    })
</script>

</html>