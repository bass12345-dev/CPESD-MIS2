@extends('systems.lls_whip.whip.' . session('user_type') . '.layout.' . session('user_type') . '_master')
@section('title', $title)
@section('content')

<div class="notika-status-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                @include('systems.lls_whip.whip.both.projects.view.sections.information')
            </div>
            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                @include('systems.lls_whip.whip.both.projects.view.sections.timeline')
            </div>
           
        

        </div>
    </div>
    <hr>

    
</div>

@endsection
@section('js')
@include('systems.lls_whip.includes.custom_js.update_js')
@include('systems.lls_whip.includes.custom_js.typeahead_search_contractor')
<script>
    $(document).on('click', 'button.submit', function () {
        let data = {
            'project_id'        : $('input[name=project_id]').val(),
            'contractor_id'     : $('input[name=contractor_id]').val(),
            'project_title'     : $('input[name=project_title]').val(),
            'project_cost'      : $('input[name=project_cost]').val(),
            'project_nature_id' : $('select[name=project_nature]').val(),
            'barangay'          : $('select[name=barangay]').val(),
            'street'            : $('input[name=street]').val(),
            'project_status'    : $('select[name=status]').val(),
            'date_started'      : $('input[name=project_date_started]').val(),
            'date_completed'    : $('input[name=project_date_completed]').val()     
        }



        
        var url = "/user/act/whip/update-project";
        Swal.fire({
            title: "Review First Before Submitting",
            text: "",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Submit"
        }).then((result) => {
            if (result.isConfirmed) {

                $.ajax({
                    url: base_url + url,
                    method: 'POST',
                    data: data,
                    dataType: 'json',
                    beforeSend: function () {
                        $('button.submit').find('button').attr('disabled', true);
                        loader();
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    },
                    success: function (data) {
                        JsLoadingOverlay.hide();
                        if(data.response) {
                            toast_message_success(data.message);
                        }else {
                            toast_message_success(data.message);
                        }

                        setTimeout(() => {
                            location.reload();
                        }, 1500);
                    },
                    error: function () {
                        alert('something Wrong');
                        location.reload();
                        JsLoadingOverlay.hide();
                    }

                });


            }
        });


    });

</script>
@endsection