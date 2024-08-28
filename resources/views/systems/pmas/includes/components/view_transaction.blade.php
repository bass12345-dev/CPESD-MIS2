<table class="tablesaw table-bordered table-hover table">
            <input type="hidden" value="{{$row->transaction_id}}" name="transact_id">
            <tr>
                <td colspan="2">
                    <a href="javascript:;"
                        class="mt-2  mb-2 btn sub-button text-center  btn-rounded btn-md btn-block"><i
                            class="fa fa-user" aria-hidden="true"></i>PMAS Information</a>
                </td>
            </tr>
            <tr>
                <td>PMAS Number</td>
                <td class="pmas_no"></td>
            </tr>
            <tr>
                <td>Date & Time Filed</td>
                <td class="date_and_time_filed"></td>
            </tr>
            <tr>
                <td>Responsible Section</td>
                <td class="responsible_section_name"></td>
            </tr>
            <tr>
                <td>Type of Activity</td>
                <td class="type_of_activity_name"></td>
            </tr>
            <tr>
                <td>Responsibility Center</td>
                <td class="responsibility_center_name"></td>
            </tr>
            <tr>
                <td>CSO</td>
                <td class="cso_name"></td>
            </tr>
            <tr>
                <td>Date & Time</td>
                <td class="date_and_time"></td>
            </tr>
        </table>
        <table class="tablesaw table-bordered table-hover table" id="training_section" hidden>
            <tr>
                <td colspan="2">
                    <a href="javascript:;"
                        class="mt-2  mb-2 btn sub-button text-center  btn-rounded btn-md btn-block">About Training</a>
                </td>
            </tr>
            <tr>
                <td>Title of Training</td>
                <td class="title_of_training"></td>
            </tr>
            <tr>
                <td>Number of Participants</td>
                <td class="number_of_participants"></td>
            </tr>
            <tr>
                <td>Female</td>
                <td class="female"></td>
            </tr>
            <tr>
                <td>Male</td>
                <td class="male"></td>
            </tr>
            <tr>
                <td>Over All Ratings</td>
                <td class="over_all_ratings"></td>
            </tr>
            <tr>
                <td>Name of Trainor</td>
                <td class="name_of_trainor"></td>
            </tr>
        </table>
        <table class="tablesaw table-bordered table-hover table" id="meeting_section" hidden>
            <tr>
                <td colspan="2">
                    <a href="javascript:;"
                        class="mt-2  mb-2 btn sub-button text-center  btn-rounded btn-md btn-block">About Project
                        Meeting</a>
                </td>
            </tr>
            <tr>
                <td>Meeting Present</td>
                <td class="meeting_present"></td>
            </tr>
            <tr>
                <td>Meeting Absent</td>
                <td class="meeting_absent"></td>
            </tr>
        </table>
        <table class="tablesaw table-bordered table-hover table" id="project_section" hidden>
            <tr>
                <td colspan="2">
                    <a href="javascript:;"
                        class="mt-2  mb-2 btn sub-button text-center  btn-rounded btn-md btn-block">Project
                        Monitoring</a>
                </td>
            </tr>
            <tr>
                <td>Project Title</td>
                <td class="project_title"></td>
            </tr>
            <tr>
                <td>Period (Mo - Year)/as of</td>
                <td class="period"></td>
            </tr>
            <tr>
                <td colspan="2">
                    <h5 class="  text-center">Attendance</h5>
                </td>
            </tr>
            <tr>
                <td>Present</td>
                <td class="present"></td>
            </tr>
            <tr>
                <td>Absent</td>
                <td class="absent"></td>
            </tr>
            <tr>
                <td colspan="2">
                    <h5 class="  text-center">Nom - Borrowers</h5>
                </td>
            </tr>
            <tr>
                <td>Delinquent</td>
                <td class="delinquent"></td>
            </tr>
            <tr>
                <td>Overdue</td>
                <td class="overdue"></td>
            </tr>
            <tr>
                <td>Total Production</td>
                <td class="total_production"></td>
            </tr>
            <tr>
                <td>Total Collection/Sales</td>
                <td class="total_collection_sales"></td>
            </tr>
            <tr>
                <td>Total Released/Purchases</td>
                <td class="total_released_purchases"></td>
            </tr>
            <tr>
                <td>Total Delinquent Account</td>
                <td class="total_delinquent_account"> </td>
            </tr>
            <tr>
                <td>Total Over-due Account</td>
                <td class="total_over_due_account"></td>
            </tr>
            <tr>
                <td>Cash in bank</td>
                <td class="cash_in_bank"> </td>
            </tr>
            <tr>
                <td>Cash on hand</td>
                <td class="cash_on_hand"></td>
            </tr>
            <tr>
                <td>Inventories(Store)</td>
                <td class="inventories"></td>
            </tr>
            <tr>
                <td><b>Total Volume of Business</b></td>
                <td style="font-weight: bold;" class="total_volume_of_business"> </td>
            </tr>
            <tr>
                <td><b>Total Cash Position</b></td>
                <td style="font-weight: bold;" class="total_cash_position"></td>
            </tr>
        </table>
        <table class="tablesaw table-bordered table-hover table">
            <tr>
                <td colspan="2">
                    <a href="javascript:;"
                        class="mt-2  mb-2 btn sub-button text-center  btn-rounded btn-md btn-block">Notes/Proceedings</a>
                </td>
            </tr>
            <tr>
                <td class="annotations p-5" colspan="2"></td>
            </tr>

            <tr>
                <td><b>Last Updated</b></td>
                <td style="font-weight: bold;" class="last_updated"></td>
            </tr>
        </table>