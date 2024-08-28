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
                    <div class="col-12 mt-3">
                        <section class="wizard-section" style="background-color: #fff;">
                            <div class="row no-gutters">
                                <div class="col-md-12">
                                    <div class="data-tables">
                                        @include('systems.pmas.includes.components.view_transaction')
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
</body>
@include('global_includes.js.global_js')
@include('systems.rfa.includes.js')
<script src="https://cdn.jsdelivr.net/npm/js-loading-overlay@1.1.0/dist/js-loading-overlay.min.js"></script>
@include('systems.rfa.includes.custom_js.layout_js')
@include('systems.pmas.includes.custom_js.view_js')
</html>