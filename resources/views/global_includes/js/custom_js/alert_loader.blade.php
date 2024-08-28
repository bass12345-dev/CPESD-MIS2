<script>
    function toast_message_success(message) {
        Toastify({
            text: message,
            close: true,
            style: {
                background: "#222E3C",
            },
            offset: { // horizontal axis - can be a number or a string indicating unity. eg: '2em'
                y: 250 // vertical axis - can be a number or a string indicating unity. eg: '2em'
            },
            position: "center", // `left`, `center` or `right`
        }).showToast();
    }

    function toast_message_error(message) {
        Toastify({
            text: message,
            close: true,
            style: {
                background: "#dc3545",
            },
            offset: { // horizontal axis - can be a number or a string indicating unity. eg: '2em'
                y: 250 // vertical axis - can be a number or a string indicating unity. eg: '2em'
            },
            position: "center", // `left`, `center` or `right`
        }).showToast();
    }
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

    $(document).ready(function(){
        $('button[type=submit]').prop('disabled',false);
    })
</script>