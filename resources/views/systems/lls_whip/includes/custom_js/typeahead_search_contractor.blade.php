<script>
    $('input[name=contractor]').typeahead({
        hint: true,
        highlight: true,
        minLength: 1
    }, {
        name: 'Contractor',
        source: function (query, process, processAsync) {

            return $.ajax({
                url: base_url + '/user/act/whip/search-query?key=' + $('input[name="contractor"]').val(),
                type: 'GET',
                dataType: 'json',
                success: function (data) {

                    processAsync($.map(data, function (row) {
                        return [{
                            'contractor_id': row.contractor_id,
                            'contractor_name': capitalizeFirstLetter(row.contractor_name)
                        }];
                    }));
                },
                error: function (jqXHR, except) { }
            });

        },
        name: 'contractor',
        displayKey: 'contractor_name',
        templates: {
            header: '<div class="header-typeahead">Employees</div>',
            empty: [
                '<div class="tt-suggestion tt-selectable">No Record <i class="fa-regular fa-face-sad-tear"></i> </div>'
            ].join('\n'),
            suggestion: function (data) {
                return '<li>' + data.contractor_name + '</li>'
            }
        },
    }).bind('typeahead:selected', function (obj, data, name) {
        $('input[name="contractor_id"]').val(data.contractor_id);
        $('input[name="contractor"]').val(data.contractor);
    });
</script>