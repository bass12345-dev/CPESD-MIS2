<script>
  $(document).on('click', 'a.generate-report', function() {
    var project_monitoring_id = $('input[name=project_monitoring_id]').val();
    var project_id = $('input[name=project_id]').val();
    $.ajax({
      url: base_url + "/user/act/whip/generate-report",
      method: 'POST',
      data: {
        project_monitoring_id: project_monitoring_id,
        project_id: project_id
      },
      dataType: 'json',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
      },
      success: function(data) {
        if (data) {
          display_report(data);
        }

      },
      error: function(xhr, status, error) {

        toast_message_error('Server Error')

      },
    });
  });







  function display_report(data) {

    var newWin = open('', 'windowName', 'height=1000,width=1000');
    let con = '';

    // Total 
    let total_skilled = 0;
    let total_skilled_percentage = 0;
    let total_unskilled = 0;
    let total_unskilled_percentage = 0;

    //Skilled Outside
    let total_skilled_outside = 0;
    let total_skilled_outside_percentage = 0;
    //Unskilled Outside
    let total_unskilled_outside = 0;
    let total_unskilled_outside_percentage = 0;

    //Skilled Inside
    let total_skilled_inside = 0;
    let total_skilled_inside_percentage = 0;
    //UnSkilled Inside
    let total_unskilled_inside = 0;
    let total_unskilled_inside_percentage = 0;


    //Skilled Within
    let total_skilled_within = 0;
    let total_skilled_within_percentage = 0;
    //Unskilled Within
    let total_unskilled_within = 0;
    let total_unskilled_within_percentage = 0;


     //Skilled Near
    let total_skilled_near = 0;
    let total_skilled_near_percentage = 0;
    //Unskilled Near
    let total_unskilled_near = 0;
    let total_unskilled_near_percentage = 0;

    //Skilled Far
    let total_skilled_far = 0;
    let total_skilled_far_percentage = 0;
    //Unskilled Far
    let total_unskilled_far = 0;
    let total_unskilled_far_percentage = 0;
    
    var compliant_text_within_city_skilled = 'NON-COMPLIANT';
    var compliant_text_within_project_skilled = 'NON-COMPLIANT';
    var compliant_text_within_city_unskilled = 'NON-COMPLIANT';
    var compliant_text_within_project_unskilled = 'NON-COMPLIANT';
    






    //Total
    total_skilled = data.s_u.skilled;
    total_unskilled = data.s_u.unskilled;

    if(data.s_u.skilled != 0){
      total_skilled_percentage = 100;
    }

    if(data.s_u.unskilled != 0){
      total_unskilled_percentage = 100;
    }

    if (data.outside_oroquieta.length > 0) {
      $.each(data.outside_oroquieta, function(index, row) {
        if (row.nature_of_employment == 'skilled') {
          total_skilled_outside = row.count_nature;
          total_skilled_outside_percentage = parseFloat(total_skilled_outside / total_skilled * 100).toFixed(2);
        }

        if (row.nature_of_employment == 'unskilled') {
          total_unskilled_outside = row.count_nature;
          total_unskilled_outside_percentage = parseFloat(total_unskilled_outside / total_unskilled * 100).toFixed(2);
        }

      });
    }


    if (data.inside_oroquieta.length > 0) {
      $.each(data.inside_oroquieta, function(index, row) {
        if (row.nature_of_employment == 'skilled') {
          total_skilled_inside = row.count_nature;
          total_skilled_inside_percentage = parseFloat(total_skilled_inside / total_skilled * 100).toFixed(2);
          if(total_skilled_inside_percentage >= 30){
            compliant_text_within_city_skilled = 'COMPLIANT';
          }
      
        }

        if (row.nature_of_employment == 'unskilled') {
          total_unskilled_inside = row.count_nature;
          total_unskilled_inside_percentage = parseFloat(total_unskilled_inside / total_unskilled * 100).toFixed(2);
          if(total_unskilled_inside_percentage >= 50){
            compliant_text_within_city_unskilled = 'COMPLIANT';
          }
          
  
        }

      });
    }


    if (data.within_project.length > 0) {
      $.each(data.within_project, function(index, row) {
        if (row.nature_of_employment == 'skilled') {
          total_skilled_within = row.count_nature;
          total_skilled_within_percentage = parseFloat(total_skilled_within / total_skilled_inside * 100).toFixed(2);
          if(total_skilled_within_percentage >= 30){
            compliant_text_within_project_skilled = 'COMPLIANT';
          }
          
        }

        if (row.nature_of_employment == 'unskilled') {
          total_unskilled_within = row.count_nature;
          total_unskilled_within_percentage = parseFloat(total_unskilled_within / total_unskilled_inside * 100).toFixed(2);
          if(total_unskilled_within_percentage >= 50){
            compliant_text_within_project_unskilled = 'COMPLIANT';
          }
        
        }

      });
    }

    if (data.near_project.length > 0) {
      $.each(data.near_project, function(index, row) {
        if (row.nature_of_employment == 'skilled') {
          total_skilled_near = row.count_nature;
          total_skilled_near_percentage = parseFloat(total_skilled_near / total_skilled_inside * 100).toFixed(2);
        }

        if (row.nature_of_employment == 'unskilled') {
          total_unskilled_near = row.count_nature;
          total_unskilled_near_percentage = parseFloat(total_unskilled_near / total_unskilled_inside * 100).toFixed(2);
        }

      });
    }



    if (data.far_project.length > 0) {
      $.each(data.far_project, function(index, row) {
        if (row.nature_of_employment == 'skilled') {
          total_skilled_far = row.count_nature;
          total_skilled_far_percentage = parseFloat(total_skilled_far / total_skilled_inside * 100).toFixed(2);
        }

        if (row.nature_of_employment == 'unskilled') {
          total_unskilled_far = row.count_nature;
          total_unskilled_far_percentage = parseFloat(total_unskilled_far / total_unskilled_inside * 100).toFixed(2);
        }

      });
    }

    let number =  parseFloat(data.data.project_cost).toFixed(2)



    let header = '<div class="header">\
                        <h3>WORKERS HIRED IN INFRASTRACTURE PROJECTS (WHIP) MONITORING </h3>\
                        <h5>Legal Basis : City Ordinance No. 868-2020 and Republic Act No. 6685</h5>\
                    </div>';

    let table = '<table class="table table-hover table-striped "  style="width: 100%;" >\
              <tr>\
                <td style="width: 23%;">Project Title</td>\
                <td ><span class="tb">' + data.data.project_title + '</span></td>\
            </tr>\
             <tr>\
                <td>Contractor</td>\
                <td ><span class="tb">' + data.data.contractor_name + '</span></td>\
            </tr>\
             <tr>\
                <td>Project Location</td>\
                <td ><span >' + data.data.barangay + '</span></td>\
            </tr>\
             <tr>\
                <td>Project Nature</td>\
                <td ><span >' + data.data.project_nature + '</span></td>\
            </tr>\
             <tr>\
                <td>Project Cost</td>\
                <td ><span >&#8369; ' + number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") + '</span></td>\
            </tr>\
              <tr>\
                <td>Date Started</td>\
                <td ><span >' + data.data.date_started + '</span></td>\
            </tr>\
              <tr>\
                <td>Date of Monitoring</td>\
                <td ><span >' + data.data.date_of_monitoring + '</span></td>\
            </tr>\
              <tr>\
                <td>Specific Activity</td>\
                <td ><span >' + data.data.specific_activity + '</span></td>\
            </tr>\
        </table>';

    let header2 = '<div class="header" style="margin-top: 20px;">\
                        <h3>RESULT / FINDINGS FROM THE MONITORING</h3>\
                    </div>';

    let header3 = '<div class="heade3" style="margin-top: 20px;">\
                        <h3>A. MANDATORY REQUIREMENT OF 30% IN HIRING SKILLED WORKERS</h3>\
                    </div>';

    let table2 = '<table class="table table-hover table-striped table-information "  >\
              <tr>\
                <th>DESCRIPTION</th>\
                <th>SKILLED</th>\
                <th>%-Age</th>\
                <th>IMPRESSION</th>\
            </tr>\
             <tr>\
                <th>Actual No. of Hired Workers</th>\
                <th>' + data.s_u.skilled + '</th>\
                <th>'+ total_skilled_percentage+'%</th>\
                <th rowspan="3" class="bg_color_skilled" >'+compliant_text_within_city_skilled+'</th>\
            </tr>\
             <tr>\
                <td>No. of Workers Hired Outside Oroquieta</td>\
                <td>' + total_skilled_outside + '</td>\
                <td>' + total_skilled_outside_percentage + '%</td>\
            </tr>\
              <tr>\
                <td class="bg_color_skilled">No. of Workers Hired Within Oroquieta</td>\
                <td class="bg_color_skilled">' + total_skilled_inside + '</td>\
                <td class="bg_color_skilled">' + total_skilled_inside_percentage + '%</td>\
            </tr>\
             <tr>\
                <td class="within_project_skilled_unskilled">No. of Workers Within Project</td>\
                <td class="within_project_skilled_unskilled">' + total_skilled_within + '</td>\
                <td class="within_project_skilled_unskilled">' + total_skilled_within_percentage + '%</td>\
                <td rowspan="3" class="within_project_skilled_unskilled">'+compliant_text_within_project_skilled+'</td>\
            </tr>\
              <tr>\
                <td>No. of Workers Hired From Nearby Brgy.</td>\
                <td>'+total_skilled_near+'</td>\
                <td>'+total_skilled_near_percentage+'%</td>\
            </tr>\
             <tr>\
                <td>No. of Workers Hired From Far Brgys.</td>\
                <td>'+total_skilled_far+'</td>\
                <td>'+total_skilled_far_percentage+'%</td>\
            </tr>\
        </table>';

    con += '<!DOCTYPE html>\
                       <html>\
                          <head>\
                             <title>Print</title>\
                             <link href="{{asset("lls_assets/css/whip_report3.css")}}" rel="stylesheet">\
                          </head>\
                          <body>';
    let header4 = '<div class="heade3" style="margin-top: 20px;">\
                        <h3>B. MANDATORY REQUIREMENT OF 50% IN HIRING UNSKILLED WORKERS</h3>\
                    </div>';
    let table3 = '<table class="table table-hover table-striped table-information "  >\
              <tr>\
                <th>DESCRIPTION</th>\
                <th>SKILLED</th>\
                <th>%-Age</th>\
                <th>IMPRESSION</th>\
            </tr>\
             <tr>\
                <th>Actual No. of Hired Workers</th>\
                <th>' + data.s_u.unskilled + '</th>\
                <th>'+ total_unskilled_percentage+'%</th>\
                <th rowspan="3" class="bg_color_unskilled">'+compliant_text_within_city_unskilled+'</th>\
            </tr>\
             <tr>\
                <td>No. of Workers Hired Outside Oroquieta</td>\
                <td>' + total_unskilled_outside + '</td>\
                <td>' + total_unskilled_outside_percentage + '%</td>\
            </tr>\
              <tr>\
                <td class="bg_color_unskilled">No. of Workers Hired Within Oroquieta</td>\
                <td class="bg_color_unskilled">' + total_unskilled_inside + '</td>\
                <td class="bg_color_unskilled">' + total_unskilled_inside_percentage + '%</td>\
            </tr>\
             <tr>\
                <td class="within_project_skilled_unskilled">No. of Workers Within Project</td>\
                <td class="within_project_skilled_unskilled">' + total_unskilled_within + '</td>\
                <td class="within_project_skilled_unskilled">' + total_unskilled_within_percentage + '%</td>\
                <td rowspan="3" class="within_project_skilled_unskilled">'+compliant_text_within_project_unskilled+'</td>\
            </tr>\
              <tr>\
                <td>No. of Workers Hired From Nearby Brgy.</td>\
                <td>'+total_unskilled_near+'</td>\
                <td>'+total_unskilled_near_percentage+'%</td>\
            </tr>\
             <tr>\
                <td>No. of Workers Hired From Far Brgys.</td>\
                <td>'+total_unskilled_far+'</td>\
                <td>'+total_unskilled_far_percentage+'%</td>\
            </tr>\
        </table>';
    let bottom = '<div class="impression"><span>OVER-ALL IMPRESSION</span><span>___________________________________________</span></div>';
    let bottom2 = '<div class="impression"><span>REMARKS/RECOMMENDATION</span><span>__________________________________</span><br><span>___________________________________________________________________</span></div>';
    let bottom3 = '<div class="bottom1">\
                      <p  style="margin-right:300px;">Prepared by:</p> \
                      <p >Noted by:</p></div>';
    let bottom4 = '<div class="bottom2">\
                    <div class="first">\
                      <p class="name" style="text-align:center;font-weight: 700;">' + data.name + '</p> \
                      <p>Administrative Asst. WHIP Focal Person</p>\
                    </div>\
                    <div class="second">\
                      <p class="name" style="text-align:center;font-weight: 700;">MARK ANTHONY D. ARTIGAS</p> \
                      <p style="margin-left:50px;">PESO Manager</p>\
                    </div>\
                  </div>';
    con += '<div class="container">';
    con += header;
    con += table;
    con += header2;
    con += header3;
    con += table2;
    con += header4;
    con += table3;
    con += bottom;
    con += bottom2;
    con += bottom3;
    con += bottom4;
    con += '  </div></body></html>';
    newWin.document.write(con);
    setTimeout(() => {
      newWin.print();
    }, 1000);
  };
</script>