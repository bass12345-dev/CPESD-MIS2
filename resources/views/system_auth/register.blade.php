<!DOCTYPE html>
<html lang="en">

<head>

    @include('global_includes.meta')
    <title>DTS Login</title>
    @include('system_auth.includes.css')
    <style>
        canvas {
            overflow-y: hidden;
            overflow-x: hidden;
            width: 100%;
            margin: 0;
            position: absolute;

        }
    </style>
</head>

<body>
   
    <div id="background"></div>
    <main class="d-flex w-100 ">

        <div class="container d-flex flex-column">
            <div class="row vh-100">
                <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 mx-auto d-table h-100">
                    <div class="d-table-cell align-middle">

                        <div class="card">
                            <div class="card-body">
                                <a href="{{url('/')}}"><i class="fas fa-arrow-left"></i></a>
                                <div class="text-center mt-4">

                                    <h1 class="h2 text-black">Register</h1>

                                </div>
                                <div class="m-sm-3">
                                    <form id="register_form">
                                        <div class="row ">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">First Name<span
                                                        class="text-danger">*</span></label>
                                                <input class="form-control form-control-lg" type="text" name="first_name" />
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Middle Name</label>
                                                <input class="form-control form-control-lg" type="text"
                                                    name="middle_name" />
                                            </div>
                                        </div>

                                        <div class="row ">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Last Name<span
                                                        class="text-danger">*</span></label>
                                                <input class="form-control form-control-lg" type="text" name="last_name" />
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Jr Sr ... Extension</label>
                                                <input class="form-control form-control-lg" type="text" name="extension" />
                                            </div>
                                        </div>

                                        <div class="row ">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Contact Number <span
                                                        class="text-danger">*</span></label>
                                                <input class="form-control form-control-lg" type="number"
                                                    name="contact_number" />
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Email Address <span
                                                        class="text-danger">*</span></label>
                                                <input class="form-control form-control-lg" type="email"
                                                    name="email_address" />
                                            </div>
                                        </div>


                                        <div class="row ">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Barangay<span class="text-danger">*</span></label>
                                                <select class="form-select" name="address">
                                                    <option value="">Select Barangay</option>
                                                    <?php
                                                    foreach ($barangay as $row):

                                                    ?>
                                                        <option value="{{$row}}">{{$row}}</option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Office<span class="text-danger">*</span></label>
                                                <select class="form-select" name="office">
                                                    <option value="21">OCM-CPESD</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Username <span class="text-danger">*</span></label>
                                            <input class="form-control form-control-lg" type="text" name="username" />
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Password <span class="text-danger">*</span></label>
                                            <input class="form-control form-control-lg" type="password" name="password" />
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Confirm Password <span
                                                    class="text-danger">*</span></label>
                                            <input class="form-control form-control-lg" type="password"
                                                name="confirm_password" />
                                        </div>


                                        <div class="d-grid gap-2 mt-3">
                                            <button type="submit" class="btn btn-lg btn-primary">Submit</button>
                                        </div>
                                        @include('components.submit_loader')
                                    </form>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>


    </main>


    @include('system_auth.includes.js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r79/three.min.js"></script>

    <script type="text/javascript">
        $('#register_form').on('submit', function(e) {
            e.preventDefault();
            var form = $('#register_form');
            $.ajax({
                url: base_url + '/register',
                method: 'POST',
                data: $(this).serialize(),
                dataType: 'json',
                beforeSend: function() {
                    before(form);
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                success: function(data) {

                    if (data.response) {
                        $('.submit-loader').addClass('d-none');
                        $('#canvas').removeClass('d-none');
                        Swal.fire({
                            position: "top-end",
                            icon: "success",
                            title: data.message,
                            showConfirmButton: false,
                            timer: 5000
                        });
                        $('#register_form')[0].reset();
                        $('#register_form').find('button').prop('disabled', false);
                        
                    }

                },
                error: function(err) {
                    if (err.status == 422) { // when status code is 422, it's a validation issue
                        $('#register_form').find('button').prop('disabled', false);
                       
                        // // display errors on each form field
                        $.each(err.responseJSON.errors, function(i, error) {
                            var el = $(document).find('[name="' + i + '"]');
                            el.after($('<span style="color: red;" class="error">' + error[0] +
                                '</span>'));

                        });
                        
                    }else if(err.status == '404' || err.status == '500' ) {
                        alert('Server Error')
                    }

                    $('.submit-loader').addClass('d-none');
                    $('button[type=submit]').prop('disabled',false)
                }

            });
        });

     
    </script>
  
    @include('global_includes.js.custom_js.three_js')
</body>

</html>