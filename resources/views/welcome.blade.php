<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <!-- Styles -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href=" {{ asset('/welcome.css') }} " rel="stylesheet">

</head>

<body>
    <section class="vh-100">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-7">
                    <div class="img-container">
                        <img class="right-bg" src="{{ asset('assets/img/auth_bg/auth_bg.jpg')}}">
                    </div>

                </div>
                <div class="col-md-5">
                    <div class="card vh-100">
                        <div class="card-container p-3">
                            <div class="form-title d-flex justify-content-center align-items-center mt-5">
                                <h4>CPESD MIS</h4>
                            </div>
                            <form class="mt-5">
                                <!-- Email input -->
                                <div class="mb-3">
                                    <label class="form-label">Username</label>
                                    <input class="form-control form-control-lg" type="text" name="username"
                                        placeholder="Enter your Username" />
                                </div>

                                <!-- Password input -->
                                <div class="mb-3">
                                    <label class="form-label">Password</label>
                                    <input class="form-control form-control-lg" type="text" name="password"
                                        placeholder="Enter your Password" />
                                </div>


                                <!-- Submit button -->
                                <div class="d-grid gap-2 mt-5">
                                    <a href="{{url('/home')}}" class="btn btn-lg btn-primary">Submit</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>

</html>