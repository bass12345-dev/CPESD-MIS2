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
                        @include('systems.rfa.includes.components.view_rfa_data')
                     </div>
                  </section>
               </div>
            </div>
         </div>
      </div>
</body>
@include('global_includes.js.global_js')
@include('systems.rfa.includes.js')
@include('systems.rfa.includes.custom_js.layout_js')

<script>

</script>

</html>