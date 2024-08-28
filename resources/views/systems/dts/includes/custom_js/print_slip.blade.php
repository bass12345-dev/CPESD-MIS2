<script>
    $('a#print_slips').on('click', function () {
     
     var rows_selected = table.column(0).checkboxes.selected();
     let arr = [];
        $.each(rows_selected, function(index, rowId){
           const myArray = rowId.split(",");
           arr.push(myArray);
        });

    
     if (rows_selected.length == 0) {
        toast_message_error('Please Select at least one')
     } else {

        var newWin = open('', 'windowName', 'height=1000,width=1000');
        let con = '';
        

        let oroquieta_logo = "{{asset('assets/img/dts/oroquieta_logo-300x300.png')}}";
        let peso_logo = "{{asset('assets/img/dts/peso_logo.png')}}";
        let asenso_logo = "{{asset('assets/img/dts/Bagong_Pilipinas_logo.png')}}";
        let bagong_pilipinas = "{{asset('assets/img/dts/asenso_logo.png')}}";


        
        con += '<!DOCTYPE html>\
                       <html>\
                          <head>\
                             <title>Print</title>\
                             <link href="{{asset("dts/css/print.css")}}" rel="stylesheet">\
                          </head>\
                          <body>';
        

                    let header = '<div id="header">\
                       <div class="top-header">\
                          <div class="left">\
                             <div class="left-logo">\
                                <img class="top-logo " src="'+ oroquieta_logo + '">\
                                <img class="top-logo right-l" src="'+ asenso_logo + '">\
                             </div>\
                          </div>\
                          <div class="middle">\
                             <span>Republic of the Philippines</span><br>\
                             <span class="office-city-mayor">Office of the City Mayor</span><br>\
                             <span class="oro">Oroquieta City</span><br>\
                             <span class="oro capital">The Capital of Misamis Occidental</span>\
                          </div>\
                          <div class="right">\
                             <div class="bagong-image-card">\
                                <img class="top-logo" src="'+ bagong_pilipinas + '">\
                                <img class="top-logo" src="'+ asenso_logo + '">\
                             </div>\
                          </div>\
                       </div>\
                       <div class="below-header">\
                          <h21>\
                          Cooperative & Public Employment Service Division</h2>\
                       </div>\
                    </div>';
        $.each(arr, function(index, row){
              con += header;

              con += '<div class="table">\
                          <table cellpadding = "3" cellspacing = "2">\
                          <tr>\
                             <th colspan="4" >Routing Slip</th>\
                          </tr>\
                          <tr>\
                             <td colspan="3">\
                                <div style="margin-bottom: 0">\
                                   <label>Document Name : </label> <span>'+row[0]+'</span><br>\
                                   <label>Document No : </label> <span>'+row[1]+'</span><br>\
                                   <label>Document Type : </label> <span>'+row[2]+'</span><br>\
                                   <label>Date Received : </label> <span>'+row[3]+'</span><br>\
                                </div>\
                             </td>\
                             <td colspan="1">\
                                <div style="margin-bottom: 40px;">\
                                   <label >Encoded By : </label> <span>'+row[4]+'</span><br>\
                                   <label >Type : </label> <span>'+row[5]+'</span><br>\
                                   <label >Origin : </label> <span>'+row[6]+'</span><br>\
                                </div>\
                             </td>\
                          </tr>\
                          <tr>\
                             <td colspan="4">\
                                <label >Brief Description</label> : <span>'+row[7]+'</span>\
                             </td>\
                          </tr>\
                          <tr>\
                             <td colspan="4">\
                                <div style="margin-bottom: 120px;">\
                                      <span class="action_taken">Action Taken :</span>\
                                </div>\
                             </td>\
                          </tr>\
                       </table>\
                    </div>\
                    <br>\
                    <hr>\
                    <br>';
        });
     
        con += '   </body></html>';
        
        newWin.document.write(con);
        setTimeout(() => {
           newWin.print();
        }, 1000);
     }
  });
</script>