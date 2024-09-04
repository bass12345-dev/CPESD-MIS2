<!DOCTYPE html>
<html lang="en">

<head>

    @include('global_includes.meta')
    <title>DTS Login</title>
    @include('system_auth.includes.css')
</head>

<body>
    <div id="background"></div>
    <main class="d-flex w-100">
        <div class="container d-flex flex-column">
            <div class="row vh-100">
                <div class="col-sm-10 col-md-8 col-lg-6 col-xl-5 mx-auto d-table h-100">
                    <div class="d-table-cell align-middle">
                        <div class="card">
                            <div class="card-body">
                               
                                <div class="text-center mt-4">
                                    <h1 class="h2 text-black">Welcome back to!</h1>
                                    <h1 class="h2 text-black">CPESD MIS</h1>
                                    <p class="lead text-black">
                                        Sign in to your account to continue
                                    </p>
                                </div>
                                <div class="m-sm-3">
                                    <form id="login_form">
                                        <div class="mb-3">
                                            <label class="form-label">Username</label>
                                            <input class="form-control form-control-lg" type="text" name="username"
                                                placeholder="Enter your Username" />
                                        </div>
                                        <label class="form-label">Password</label>
                                        <div class="input-group flex-nowrap pass" style="height: 40px;">

                                            <input type="password" class="form-control password" name="password"
                                                placeholder="Enter your Password" aria-label="Password"
                                                aria-describedby="addon-wrapping">
                                            <span class="input-group-text show_con">
                                                <i class="fas fa-eye show_icon"></i>
                                                <i class="fas fa-eye-slash hidden_icon" hidden></i>
                                            </span>
                                        </div>
                                        <div class="g-recaptcha mt-4" data-sitekey={{config('services.recaptcha.key')}}>
                                        </div>
                                        <div class="d-grid gap-2 mt-5">
                                            <button type="submit" class="btn btn-lg btn-primary">Submit</button>
                                        </div>
                                        @include('components.submit_loader')

                                    </form>
                                    <div class="text-center mb-3 text-black mt-4">
                                        Don't have an account? <a href="{{url('/register')}}">Sign up</a>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </main>
</body>

@include('system_auth.includes.js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r79/three.min.js"></script>

<script type="text/javascript">
    $('#login_form').on('submit', function (e) {
        e.preventDefault();
        var form = $('#login_form');
        $.ajax({
            url: base_url + '/v-u',
            method: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            beforeSend: function () {
                before(form);
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            success: function (data) {
                Swal.close();
                if (data.response) {

                    Swal.fire({
                        position: "top-end",
                        icon: "success",
                        title: data.message,
                        showConfirmButton: false,
                        timer: 1500
                    });
                    location.reload();

                } else {

                    alert(data.message)
                    location.reload();
                }
            },
            error: function (err) {
                Swal.close();
                if (err.status == 422) { // when status code is 422, it's a validation issue
                    form.find('button[type="submit"]').prop('disabled', false);
                    $('.submit-loader').addClass('d-none');
                    // // display errors on each form field
                    $.each(err.responseJSON.errors, function (i, error) {


                        if (i == 'password') {
                            console.log('hey')
                            var e = $(document).find('.pass');
                            e.after($('<br><span style="color: red;" class="error">' + error[
                                0] +
                                '</span>'));
                        } else {
                            var el = $(document).find('[name="' + i + '"]');
                            el.after($('<span style="color: red;" class="error">' + error[0] +
                                '</span>'));

                        }

                    });
                }
            }

        });
    });

    $(document).on('click', 'span.show_con', function () {
        var input = $('input.password');
        var show_eye = $('i.show_icon');
        var hide_eye = $('i.hidden_icon');
        show_icon(input, show_eye, hide_eye)
    });

    function show_icon(input, show_eye, hide_eye) {
        if (input.attr('type') === 'password') {
            input.prop('type', 'text');
            show_eye.attr('hidden', true)
            hide_eye.removeAttr('hidden')
        } else {
            input.prop('type', 'password');
            hide_eye.attr('hidden', true)
            show_eye.removeAttr('hidden')
        }

    }

 
</script>
@include('global_includes.js.custom_js.three_js')
</html>