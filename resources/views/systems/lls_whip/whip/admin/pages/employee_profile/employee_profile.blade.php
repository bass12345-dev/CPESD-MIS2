@extends('systems.lls_whip.whip.' . session('user_type') . '.layout.' . session('user_type') . '_master')
@section('title', $title)
@section('content')

<div class="notika-status-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                @include('systems.lls_whip.whip.both.employee_profile.employee_information')
            </div>
            <div class="col-lg-7 col-md-7 col-sm-7 col-xs-12">
                @include('systems.lls_whip.whip.both.employee_profile.job_table')
            </div>
           
        

        </div>
    </div>
    <hr>

    
</div>

@endsection
@section('js')
@include('systems.lls_whip.includes.custom_js.update_js')
<script>
     $(document).on('click', 'button.submit', function () {
        let data = {
            'employee_id'       : $('input[name=employee_id]').val(),
            'first_name'        : $('input[name=first_name]').val(),
            'middle_name'       : $('input[name=middle_name]').val(),
            'last_name'         : $('input[name=last_name]').val(),
            'extension'         : $('input[name=extension]').val(),
            'province_code'     : province_options.find(":selected").val(),
            'province'          : province_options.find(":selected").text(),
            'city_code'         : city_options.find(":selected").val(),
            'city'              : city_options.find(":selected").text(),
            'barangay_code'     : brgy_options.find(":selected").val(),
            'barangay'          : brgy_options.find(":selected").text(),
            'street'            : $('input[name=street]').val(),
            'birthdate'         : $('input[name=birthdate]').val(),
            'gender'            : $('select[name=gender]').val(),
            'contact_number'    : $('input[name=contact_number]').val(),
        }

        

        var url = "/user/act/update-employee";
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
                        }

                        setTimeout(() => {
                            location.reload();
                        }, 1500);
                    },
                    error: function () {
                        alert('something Wrong');
                        // location.reload();
                        JsLoadingOverlay.hide();
                    }

                });


            }
        });


    });

</script>
@include('systems.lls_whip.includes.custom_js.update_info_location')
@endsection