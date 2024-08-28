
<!-- Modal -->
<div class="modal fade" id="print_slip_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog  modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-titl e" id="staticBackdropLabel"></h5>
                <button type="button" class="btn btn-primary" onclick="print_slip()"><i class="fas fa-print"></i> Print</button>
                <!-- <button type="button btn btn-primary" onclick="export_to_pdf()">Export to PDF</button> -->
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="slip">
                <style>
                    @import url('https://fonts.googleapis.com/css2?family=M+PLUS+Rounded+1c&family=Protest+Strike&family=Varela+Round&display=swap');
                    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@100..900&family=M+PLUS+Rounded+1c&family=Protest+Strike&family=Varela+Round&display=swap');

                    .top-header {
                        /* height: 120px; */
                        display: flex;
                        flex-direction: row;
                        flex-wrap: wrap;
                        justify-content: center;

                    }

                    /* Left */
                    .left {

                        display: flex;
                        justify-content: center;
                        align-items: center;


                    }

                    .left-logo {

                        /* margin-left: 12px; */
                        margin-bottom: 30px;
                    }

                    img.top-logo {
                        height: 65px;
                        width: 65px;

                    }

                    /* Middle */
                    .middle {

                        /*	flex:1;*/
                        display: flex;
                        flex-direction: column;
                        justify-content: center;
                        align-items: center;
                        /* width: 320px; */
                        line-height: 9px;
                        /* margin-top: 10px; */

                    }

                    .office-city-mayor {
                        text-transform: uppercase;
                        font-weight: bold;
                    }

                    .oro {
                        font-weight: bold;
                    }



                    .middle span {
                        font-family: "Inter", sans-serif;
                        color: #000;
                        font-size: 15px;
                    }


                    p.capital {
                        color: maroon;
                        font-family: "Inter", sans-serif;
                        font-size: 15px;
                    }


                    /* Right */
                    .right {

                        width: 100px;
                        display: flex;
                        justify-content: center;
                        align-items: center;

                    }

                    .bagong-image-card {
                        display: flex;
                        justify-content: center;
                        align-items: center;
                        margin-bottom: 36px;
                        margin-right: -60px;
                    }

                    .bagong-image-card img {

                        margin-left: 10px;
                    }

                    .below-header {
                        font-family: "Inter", sans-serif;
                        text-align: center;
                        font-weight: bold;
                        font-size: 20px;
                        color: #000;
                        margin-bottom: 12px;
                        /*	display: flex;
	align-items: center;
	justify-content: center;*/

                    }
                </style>
                <div id="header">
                    <div class="top-header">
                  
                        <div class="left">
                            <div class="left-logo">
                                <img class="top-logo " src="{{asset('assets/img/oroquieta_logo-300x300.png')}}">
                                <img class="top-logo right-l" src="{{asset('assets/img/peso_logo.png')}}">
                            </div>

                        </div>
                        <div class="middle">
                            <span>Republic of the Philippines</span><br>
                            <span class="office-city-mayor">Office of the City Mayor</span><br>
                            <span class="oro">Oroquieta City</span><br>
                            <span class="oro capital">The Capital of Misamis Occidental</span>
                        </div>
                        <div class="right">
                            <div class="bagong-image-card">
                                <img class="top-logo" src="{{asset('assets/img/Bagong_Pilipinas_logo.png')}}">
                                <img class="top-logo" src="{{asset('assets/img/asenso_logo.png')}}">
                            </div>

                        </div>
                    </div>
                    <div class="below-header">
                        <h21>Cooperative & Public Employment Service Division</h2>
                    </div>
                </div>

                <div class="table">

                    <table cellpadding="3" cellspacing="2" style="width: 100%; border: 1px solid #000;">
                        <tr nobr="true">
                            <th colspan="4" style="text-align:center;font-size: 20px;font-family: 'Times New Roman', Times, serif; font-weight: bold; border: 1px solid #000; text-transform: uppercase;">Routing Slip</th>
                        </tr>

                      
                        <tr>
                            <td colspan="3" height="40" style="border: 1px solid #000;">

                                <label style="font-size:13px;font-weight:bold;">Document Name : </label> <span style="font-size:13px;" class="document_name"></span><br>
                                <label style="font-size:13px;font-weight:bold;">Document No : </label> <span style="font-size:13px;" class="print_tracking_number"></span><br>
                                <label style="font-size:13px;font-weight:bold;">Document Type : </label> <span style="font-size:13px;" class="document_type"></span><br>
                                <label style="font-size:13px;font-weight:bold;">Date Received : </label> <span style="font-size:13px;" class="created"></span><br>

                            </td>

                            <td colspan="1" height="40" style="border: 1px solid #000;">

                                <div style="margin-bottom: 50px;">
                                    <label style="font-size:13px;font-weight:bold;">Encoded By : </label> <span style="font-size:13px;" class="encoded_by"></span><br>
                                    <label style="font-size:13px;font-weight:bold;">Type : </label> <span style="font-size:13px;" class="type"></span></br>
                                    <label style="font-size:13px;font-weight:bold;">Origin : </label> <span style="font-size:13px;" class="origin"></span>
                                </div>
                            </td>

                        </tr>


                        <tr>

                            <td colspan="4" style="border: 1px solid #000;">

                                <label style="font-size:13px; font-weight:bold;">Brief Description</label> : <span style="font-size:13px;" class="description">asdsadsa</span>

                            </td>

                        </tr>

                        <tr>

                            <td colspan="4" height="145" style=" border: 1px solid #000;">
                                <h5 style="margin-bottom: 120px;text-transform: uppercase;font-weight:bold;">Action Taken :</h5>

                            </td>

                        </tr>

                    </table>
                </div>
                
          

            </div>
        </div>
    </div>
</div>