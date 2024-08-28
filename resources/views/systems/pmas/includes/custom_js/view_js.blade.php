<script>
    function load_transaction_data() {
        $.ajax({
            type: "POST",
            url: base_url + '/user/act/pmas/get-transaction-data',
            data: {
                'id': $('input[name=transact_id]').val()
            },
            cache: false,
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            beforeSend: function () {

                loader();
            },
            success: function (data) {
                if (data) {
                    JsLoadingOverlay.hide();

                    $('#project_section').attr('hidden', 'hidden');
                    $('#training_section').attr('hidden', 'hidden');
                    $('#meeting_section').attr('hidden', 'hidden');
                    $('input[name=transaction_id]').val(data.transaction_id);
                    $('input[name=pmas_number]').val(data.number);
                    $('input[name=year]').val(data.year);
                    $('input[name=month]').val(data.month);
                    $('select[name=type_of_monitoring_id]').val(data.responsible_section_id);
                    $('select[name=type_of_activity_id]').val(data.type_of_activity_id);
                    $('select[name=responsibility_center_id]').val(data.responsibility_center_id).trigger('change');
                    $('select[name=cso_id]').val(data.cso_id).trigger('change');
                    $('input[name=date_time]').val(data.date_and_time);
                    $('input[name=select_under_type_id]').val(data.under_type_of_activity);
                    $('.pmas_no').text(data.pmas_no);
                    $('.date_and_time_filed').text(data.date_and_time_filed);
                    $('.responsible_section_name').text(data.responsible_section_name);
                    $('.type_of_activity_name').text(data.type_of_activity_name + ' - ' + data.under_type_activity);
                    $('.responsibility_center_name').text(data.responsibility_center_name);
                    $('.cso_name').text(data.cso_name);
                    $('.date_and_time').text(data.date_time);
                    $('.annotations').html(data.annotations);
                    $('.last_updated').html(data.last_updated);
                    if (data.training_data.length > 0) {
                        $('#under_type_activity_select').removeAttr('hidden').fadeIn("slow");
                        $('.for_training').removeAttr('hidden').fadeIn("slow");
                        $('.for_project_monitoring').attr('hidden', 'hidden');
                        $('.for_project_meeting').attr('hidden', 'hidden');
                        $('input[name=title_of_training]').val(data.training_data[0].title_of_training);
                        $('input[name=number_of_participants]').val(data.training_data[0].number_of_participants);
                        $('input[name=female]').val(data.training_data[0].female);
                        $('input[name=over_all_ratings]').val(data.training_data[0].overall_ratings);
                        $('input[name=name_of_trainor]').val(data.training_data[0].name_of_trainor);
                        $('#training_section').removeAttr('hidden');
                        $('#project_section').attr('hidden', 'hidden');
                        $('#meeting_section').attr('hidden', 'hidden');
                        $('.title_of_training').text(data.training_data[0].title_of_training);
                        $('.number_of_participants').text(data.training_data[0].number_of_participants);
                        $('.female').text(data.training_data[0].female);
                        $('.male').text(data.training_data[0].male);
                        $('.over_all_ratings').text(data.training_data[0].overall_ratings);
                        $('.name_of_trainor').text(data.training_data[0].name_of_trainor);
                    }
                    if (data.project_monitoring_data.length > 0) {
                        $('#under_type_activity_select').attr('hidden', 'hidden');
                        $('.for_training').attr('hidden', 'hidden');
                        $('.for_project_monitoring').removeAttr('hidden').fadeIn("slow");
                        $('.for_project_meeting').attr('hidden', 'hidden');
                        $('input[name=project_title]').val(data.project_monitoring_data[0].project_title);
                        $('input[name=period]').val(data.project_monitoring_data[0].period);
                        $('input[name=present]').val(data.project_monitoring_data[0].present);
                        $('input[name=absent]').val(data.project_monitoring_data[0].absent);
                        $('input[name=delinquent]').val(data.project_monitoring_data[0].delinquent);
                        $('input[name=overdue]').val(data.project_monitoring_data[0].overdue);
                        $('input[name=total_production]').val(data.project_monitoring_data[0].total_production);
                        $('input[name=total_collection]').val(data.project_monitoring_data[0].total_collection_sales.replace(",", ""));
                        $('input[name=total_released]').val(data.project_monitoring_data[0].total_released_purchases.replace(",", ""));
                        $('input[name=total_deliquent]').val(data.project_monitoring_data[0].total_delinquent_account.replace(",", ""));
                        $('input[name=total_overdue]').val(data.project_monitoring_data[0].total_over_due_account.replace(",", ""));
                        $('input[name=cash_in_bank]').val(data.project_monitoring_data[0].cash_in_bank.replace(",", ""));
                        $('input[name=cash_on_hand]').val(data.project_monitoring_data[0].cash_on_hand.replace(",", ""));
                        $('input[name=inventories]').val(data.project_monitoring_data[0].inventories.replace(",", ""));
                        $('#training_section').attr('hidden', 'hidden');
                        $('#project_section').removeAttr('hidden');
                        $('#meeting_section').attr('hidden', 'hidden');
                        $('.project_title').text(data.project_monitoring_data[0].project_title);
                        $('.period').text(data.project_monitoring_data[0].period);
                        $('.present').text(data.project_monitoring_data[0].present);
                        $('.absent').text(data.project_monitoring_data[0].absent);
                        $('.delinquent').text(data.project_monitoring_data[0].delinquent);
                        $('.overdue').text(data.project_monitoring_data[0].overdue);
                        $('.total_production').text(data.project_monitoring_data[0].total_production);
                        $('.total_collection_sales').text('₱ ' + data.project_monitoring_data[0].total_collection_sales);
                        $('.total_released_purchases').text('₱ ' + data.project_monitoring_data[0].total_released_purchases);
                        $('.total_delinquent_account').text('₱ ' + data.project_monitoring_data[0].total_delinquent_account);
                        $('.total_over_due_account').text('₱ ' + data.project_monitoring_data[0].total_over_due_account);
                        $('.cash_in_bank').text('₱ ' + data.project_monitoring_data[0].cash_in_bank);
                        $('.cash_on_hand').text('₱ ' + data.project_monitoring_data[0].cash_on_hand);
                        $('.inventories').text('₱ ' + data.project_monitoring_data[0].inventories);
                        $('.total_volume_of_business').text('₱ ' + data.project_monitoring_data[0].total_volume_of_business);
                        $('.total_cash_position').text('₱ ' + data.project_monitoring_data[0].total_cash_position);
                    }
                    if (data.project_meeting_data.length > 0) {
                        $('#under_type_activity_select').attr('hidden', 'hidden');
                        $('.for_training').attr('hidden', 'hidden');
                        $('.for_project_monitoring').attr('hidden', 'hidden');
                        $('.for_project_meeting').removeAttr('hidden').fadeIn("slow");
                        $('input[name=meeting_present]').val(data.project_meeting_data[0].meeting_present);
                        $('input[name=meeting_absent]').val(data.project_meeting_data[0].meeting_absent);
                        $('#training_section').attr('hidden', 'hidden');
                        $('#project_section').attr('hidden', 'hidden');
                        $('#meeting_section').removeAttr('hidden');
                        $('.meeting_present').text(data.project_meeting_data[0].meeting_present);
                        $('.meeting_absent').text(data.project_meeting_data[0].meeting_absent);
                    }
                }
            },
            error: function (xhr) {
                alert("Data don't load properly ! Please Reload the Page");
                JsLoadingOverlay.hide();
            },
        });
    }


    $(document).ready(function () {
        load_transaction_data();
    });
</script>