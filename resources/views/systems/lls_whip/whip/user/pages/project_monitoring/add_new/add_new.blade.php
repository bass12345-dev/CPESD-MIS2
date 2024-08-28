
@extends('systems.lls_whip.whip.user.layout.user_master')
@section('title', $title)
@section('content')
@include('systems.lls_whip.whip.user.pages.project_monitoring.add_new.sections.form')
@endsection
@section('js')
<script>
    $('input[name=project_title]').typeahead({
        hint: true,
        highlight: true,
        minLength: 1
    }, {
        name: 'Project',
        source: function (query, process, processAsync) {

            return $.ajax({
                url: base_url + '/user/act/whip/search-project?key=' + $('input[name="project_title"]').val(),
                type: 'GET',
                dataType: 'json',
                success: function (data) {

                    processAsync($.map(data, function (row) {
                        return [{
                            'project_id': row.project_id,
                            'project_title': capitalizeFirstLetter(row.project_title)
                        }];
                    }));
                },
                error: function (jqXHR, except) { }
            });

        },
        name: 'project',
        displayKey: 'project_title',
        templates: {
            header: '<div class="header-typeahead">Projects</div>',
            empty: [
                '<div class="tt-suggestion tt-selectable">No Record <i class="fa-regular fa-face-sad-tear"></i> </div>'
            ].join('\n'),
            suggestion: function (data) {
                return '<li>' + data.project_title + '</li>'
            }
        },
    }).bind('typeahead:selected', function (obj, data, name) {
        $('input[name="project_id"]').val(data.project_id);
        $('input[name="project_title"]').val(data.project_title);
    });



    $('#add_form').on('submit', function (e) {
        e.preventDefault();
        $(this).find('button').prop('disabled', true);
        $(this).find('button').html('<span class="loader"></span>')
        var url = '/user/act/whip/i-p-m';
        let form = $(this);
        table = null;
        _insertAjax(url, form, table);
       

    });

</script>
@endsection