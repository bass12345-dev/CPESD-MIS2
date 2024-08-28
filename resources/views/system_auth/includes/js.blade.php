<script type="text/javascript"> var base_url = '<?php echo url('/'); ?>';  </script>
<script src=" {{ asset('dts/js/app.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.4/dist/sweetalert2.all.min.js"></script>
<script async src="https://www.google.com/recaptcha/api.js"></script>
<script>
   function before(form){

        $('span.error').remove();
        $('.submit-loader').removeClass('d-none');
        form.find('button[type="submit"]').prop('disabled',true);
    }
</script>