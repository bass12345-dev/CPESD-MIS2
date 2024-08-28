<script>
    var base_url = '<?php echo url(''); ?>';
    var table;
    var table_image_loader = '<img class="top-logo mt-4" src="{{asset("assets/img/dts/peso_logo.png")}}">';
    var _validFileExtensions = [".pdf"];
    function loader() {

        JsLoadingOverlay.show({
            'overlayBackgroundColor': '#666666',
            'overlayOpacity': 0.6,
            'spinnerIcon': 'square-loader',
            'spinnerColor': '#000',
            'spinnerSize': '3x',
            'overlayIDName': 'overlay',
            'spinnerIDName': 'spinner',
            'offsetY': 0,
            'offsetX': 0,
            'lockScroll': false,
            'containerID': null,
            'spinnerZIndex': 99999,
            'overlayZIndex': 99998
        });

    }
    function reload_page() {
        location.reload();
    }

    function capitalizeFirstLetter(string) {
        return string.charAt(0).toUpperCase() + string.slice(1);
    }

  


</script>