<script>
    $('.dropdown-toggle').dropdown();
    var preloader = $('#preloader');
    $(window).on('load', function () {
        setTimeout(function () {
            preloader.fadeOut('slow', function () {
                $(this).remove();
            });
        }, 300)
    });
    if (window.innerWidth <= 1364) {
        $('.page-container').addClass('sbar_collapsed');
    }
    $('.nav-btn').on('click', function () {
        $('.page-container').toggleClass('sbar_collapsed');
    });
    var e = function () {
        var e = (window.innerHeight > 0 ? window.innerHeight : this.screen.height) - 5;
        (e -= 67) < 1 && (e = 1), e > 67 && $(".main-content").css("min-height", e + "px")
    };
    $(window).ready(e), $(window).on("resize", e);
    $("#menu").metisMenu();
    $('.menu-inner ').slimScroll({
        height: 'auto',
    });
    $('.nofity-list').slimScroll({
        height: '435px'
    });
    $('.timeline-area').slimScroll({
        height: '500px'
    });
    $('.recent-activity').slimScroll({
        height: 'calc(100vh - 114px)'
    });
    $('.settings-list').slimScroll({
        height: 'calc(100vh - 158px)'
    });
    $(window).on('scroll', function () {
        var scroll = $(window).scrollTop(),
            mainHeader = $('#sticky-header'),
            mainHeaderHeight = mainHeader.innerHeight();
        if (scroll > 1) {
            $("#sticky-header").addClass("sticky-menu");
        } else {
            $("#sticky-header").removeClass("sticky-menu");
        }
    });
    $('[data-toggle="popover"]').popover();
    window.addEventListener('load', function () {
        var forms = document.getElementsByClassName('needs-validation');
        var validation = Array.prototype.filter.call(forms, function (form) {
            form.addEventListener('submit', function (event) {
                if (form.checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    }, false);
    $('ul#nav_menu').slicknav({
        prependTo: "#mobile_menu"
    });
    $('.form-gp input').on('focus', function () {
        $(this).parent('.form-gp').addClass('focused');
    });
    $('.form-gp input').on('focusout', function () {
        if ($(this).val().length === 0) {
            $(this).parent('.form-gp').removeClass('focused');
        }
    });
    $('.settings-btn, .offset-close').on('click', function () {
        $('.offset-area').toggleClass('show_hide');
        $('.settings-btn').toggleClass('active');
    });

</script>