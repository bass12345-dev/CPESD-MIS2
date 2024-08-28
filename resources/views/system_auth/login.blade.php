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
                                <a href="{{url('/')}}"><i class="fas fa-arrow-left"></i></a>
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
                                        <!-- <div class="mb-3">
											<label class="form-label">Password</label>
											<input class="form-control form-control-lg" type="password" name="password" placeholder="Enter your password" autocomplete required />
										</div> -->
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
                                </div>
                            </div>
                        </div>

                        <div class="text-center mb-3 text-white">
                            Don't have an account? <a href="{{url('/dts/register')}}">Sign up</a>
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

    var con = console;
    var camera, scene, renderer, composer;
    var sw = window.innerWidth, sh = window.innerHeight;
    var mouse = { down: false, x: 0, y: 0 };
    var bits = 6;
    var depth = 24;
    var walls = 5;
    var size = 10;
    var padding = 1;
    var boxSize = size - padding * 2;
    var tunnel;
    var groups = [];
    var blocks = [];
    
    var can = document.createElement("canvas"); // originally used for debugging lattice, now texture too!
    //document.body.appendChild(can);
    can.width = walls * (bits * size - size);// + size);
    can.height = depth * size;
    var ctx = can.getContext("2d");
    ctx.fillStyle = "#333";
    ctx.fillRect(0, 0, can.width, can.height);

    var y = 0;
    var lineOffsets = []; // a simple way of getting something like a "box joint" in wood joinery
    while (y < depth) {
        lineOffsets[y] = Math.random() > 0.5 ? 1 : 0;
        y++;
    }


    var w = 0;
    while (w < walls) {
        y = 0;
        var xo = w * (bits * size);// + size);
        blocks[w] = [];

        while (y < depth) {
            var lineoffset = lineOffsets[y];
            var x = 0;
            blocks[w][y] = [];
            while (x < bits) {
                var block = Math.ceil(Math.random() * 4);
                var lastOne = false;
                if (x + block > bits) {
                    block = bits - x;
                }
                ctx.fillStyle = "#555";
                ctx.fillRect(
                    xo + (lineoffset + x - 1) * size + padding,
                    y * size + padding,
                    block * size - padding * 2,
                    size - padding * 2
                );
                blocks[w][y].push(block);

                x += block;

            }
            y += 1;
        }

        w++
    };
    //con.log(blocks);

    var texture = new THREE.Texture(can);//Texture);
    texture.needsUpdate = true;
    var material = new THREE.MeshLambertMaterial({ color: 0xff2430, map: texture });


    function listen(eventNames, callback) {
        for (var i = 0; i < eventNames.length; i++) {
            window.addEventListener(eventNames[i], callback);
        }
    }

    function createBox(w, h, d) {
        var geometry = new THREE.BoxGeometry(w, h, d);
        box = new THREE.Mesh(geometry, material);
        box.castShadow = true;
        box.receiveShadow = true;
        return box;
    }

    function init() {
        //return;
        scene = new THREE.Scene();
        scene.fog = new THREE.FogExp2(0, 0.008);

        renderer = new THREE.WebGLRenderer({ antialias: true });
        renderer.setSize(sw, sh);
        renderer.setClearColor(scene.fog.color);
        renderer.shadowMapEnabled = true;
        var bo = document.getElementById("background");
        bo.appendChild(renderer.domElement);

        camera = new THREE.PerspectiveCamera(100, sw / sh, 1, 1000);
        scene.add(camera);
        /*
          var spotLight = new THREE.SpotLight(0xffffff, 1);
          spotLight.position.set(0, 800, 0);
          spotLight.castShadow = true;
          spotLight.shadowMapWidth = 2048
          spotLight.shadowMapHeight = 2048;
          spotLight.shadowCameraNear = 760;
          spotLight.shadowCameraFar = 4000;
          spotLight.shadowCameraFov = 30;
          scene.add( spotLight );
        */
        var lightTop = new THREE.DirectionalLight(0xffffff, 1);
        lightTop.position.set(-0.5, 1, 0);
        scene.add(lightTop);

        var lightFront = new THREE.DirectionalLight(0xc0c0e0, 1);
        lightFront.position.set(0.2, 0, 1);
        scene.add(lightFront);

        var lightBack = new THREE.DirectionalLight(0x705060, 1);
        lightBack.position.set(1, 0, -1);
        scene.add(lightBack);

        var lightAmbient = new THREE.AmbientLight(0x404040);
        scene.add(lightAmbient);


        var rotationZ = 1 / walls * Math.PI * 2
        var offsetY = bits * size / 2 / Math.tan(rotationZ / 2);

        tunnel = new THREE.Group();
        scene.add(tunnel);

        for (var w = 0; w < walls; w++) {

            groups[w] = [];

            var wall = new THREE.Group();
            wall.rotation.set(0, 0, w * rotationZ);
            tunnel.add(wall);

            for (var j = 0; j < depth; j++) {
                var group = new THREE.Group();
                group.position.set(0, 0, j * size);
                var numInLayer = blocks[w][j].length;
                var x = bits * size / -2 + (lineOffsets[j] ? 1 : -1) * (size - padding) / 2;
                for (var i = 0; i < numInLayer; i++) {
                    var width = blocks[w][j][i] * size;
                    box = createBox(width - padding * 2, boxSize + boxSize * Math.random(), boxSize);
                    x += width / 2;
                    var y = offsetY;
                    var z = 0;
                    box.position.set(x, y, z);
                    box.rotation.set(0, 0, 0.3 * (Math.random() - 0.5));
                    group.add(box);
                    x += width / 2;
                };
                wall.add(group);
                groups[w][j] = group;
            };

        }

        listen(["resize"], function (e) {
            sw = window.innerWidth;
            sh = window.innerHeight
            camera.aspect = sw / sh;
            camera.updateProjectionMatrix();
            renderer.setSize(sw, sh);
        });

        render(0);
    }

    function render(time) {

        tunnel.rotation.set(0, 0, time * 0.00005);

        for (var j = 0; j < depth; j++) {
            for (var w = 0; w < walls; w++) {
                var group = groups[w][j];
                group.position.z += 0.2;
                group.position.z %= size * depth;
            };
        }

        var camX = 0;//Math.sin(time * 0.00001976) * 50;
        var camY = 0;//Math.sin(time * 0.00002324) * 50;
        camera.position.set(camX, camY, 200);

        //camera.position.set(40, 0, 0);
        //camera.lookAt(new THREE.Vector3(0,0,0));
        //camera.rotation.set(0, 0, time * 0.00002);

        renderer.render(scene, camera)
        requestAnimationFrame(render);
    }

    init();
</script>

</html>