<script>
    
    var province_options = $("#province_select");
    var city_options = $("#city_select");
    var brgy_options = $("#barangay_select");
    function load_provinces() {
        province_options.append(new Option('Select Province', ''));
        $.ajax({
            url: 'https://psgc.cloud/api/provinces', method: 'GET', dataType: 'json', beforeSend: function () { province_options.after('<span class="text-warning loading_provinces" >Loading Provinces...</span><a href="javascript:;" class="refetch_provinces"></a>'); }
        }).done(function (data) {
            $('span.loading_provinces').remove();
            $.each(data, function (i, row) {
                province_options.append(new Option(row.name, row.code));
            });
            province_options.removeAttr('disabled');
            province_options.val($('input[name=province_code]').val());
        });
    }


    province_options.on('change', function () {
        city_options.find('optgroup').remove();
        city_options.find('option').remove();
        var province_string = $(this).find(":selected").val().split("-");
        var province_selected = province_string[0];
        var url = 'https://psgc.cloud/api/provinces/' + province_selected + '/cities-municipalities';
        let city_arr = [];
        $.ajax({
            url: url, method: 'GET', dataType: 'json', beforeSend: function () { city_options.after('<span class="text-warning loading_cities" >Loading Cities and Municipalities...</span>'); }
        }).done(function (cities) {
            $('span.loading_cities').remove();
            var filteredMun = $(cities).filter(function (idx) {
                return cities[idx].type === "Mun"
            });
            var filteredCities = $(cities).filter(function (idx) {
                return cities[idx].type === "City"
            });
            var optgroup = "<optgroup label='Cities'>";
            $(filteredCities).each(function () {
                name = this.name;
                optgroup += "<option value='" + this.code + "'>" + name + "</option>"
            });
            optgroup += "</optgroup>"
            city_options.append(optgroup);

            var optgroup = "<optgroup label='Municipalities'>";
            $(filteredMun).each(function () {
                name = this.name;
                optgroup += "<option value='" + this.code + "'>" + name + "</option>"
            });
            optgroup += "</optgroup>"
            city_options.append(optgroup);
            city_options.prepend(new Option('Select City Or Municipalities', ''));
            $(`#city_select option[value='']`).prop('selected', true);
            city_options.removeAttr('disabled');


        });
    });


    city_options.on('change', function () {

        brgy_options.find('option').remove();
        var city_string = $(this).find(":selected").val().split("-");
        var city_selected = city_string[0];
        brgy_options.append(new Option('Select Barangay', ''));
        var url = 'https://psgc.cloud/api/cities-municipalities/' + city_selected + '/barangays';
        let city_arr = [];
        $.ajax({
            url: url, method: 'GET', dataType: 'json', beforeSend: function () { brgy_options.after('<span class="text-warning loading_brgy" >Loading Brgy...</span>'); }
        }).done(function (data) {
            $('span.loading_brgy').remove();
            $.each(data, function (i, row) {
                brgy_options.append(new Option(row.name, row.code));
            });
            brgy_options.removeAttr('disabled');
        });
    });



    function load_selected_city() {
        city_options.append(new Option($('input[name=city_name]').val(), $('input[name=city_code]').val()));
    }

    function load_selected_barangay() {
        brgy_options.append(new Option($('input[name=barangay_name]').val(), $('input[name=barangay_code]').val()));
    }
    load_selected_barangay();
    load_selected_city();
    load_provinces();

</script>