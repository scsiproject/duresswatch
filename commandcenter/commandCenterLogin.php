<?php include 'dbconnect.php'; ?>
<?php
     session_start();
     if(!isset($_SESSION["username"]))
     {
       header("location: /chubb/");
     }
     else{
       if($_SESSION["privlev"] == "Administrator"){
         header("location: /chubb/chubb_php/admin.php");
       }
     }
     ?>
<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=0.50, maximum-scale=1, minimum-scale=0">
    <title>ANZ - Command Center Panel</title>
    <link href="../css/commandCenter.css" rel="stylesheet" type="text/css" >
    <script src="../libs/jquery/jquery-3.3.1.min.js"></script>
    <script src="../libs/bootstrap/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="../libs/bootstrap/css/bootstrap.min.css">
    <script src="../libs/bootstrap/js/popper.min.js"></script>


    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">

    <link href="../libs/font-awesome/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../css/styles.css" />


    <script src="https://cdnjs.cloudflare.com/ajax/libs/bluebird/3.3.5/bluebird.min.js"></script>
    <script src="../libs/sweetalert/sweetalert2.all.min.js"></script>

    <style>
      #staffLoc {
        height: 431px;
        width: 100%;
      }
      #map {
          width:100%;
          height:100%;
          border: 1px solid #000;
      }

      #audioDiv {
          width:100%;
          height:417px;
          overflow-y: auto;
          border: 1px solid #000;
      }
    </style>

</head>

<body>

   <div id="header-Line">
                   <div> <button type="button" id="logout_button" class="btn btn-danger btn-sm"  onClick="location.href='logout.php'"> Log Out</button> </div>
   </div>
   <div class="commandCenterContainer">
       <div class="row">
            <div class="commandColumnLeft" >
               <div class = "commandCompanyLogo">
                    <?php
                          $sql="SELECT * FROM list_of_images WHERE id=2";
                          $result=mysqli_query($conn,$sql);
                          while($row=mysqli_fetch_array($result))
                          {
                             echo '<img src="data:image/png;base64,'.base64_encode($row['image']).' " class="companyImageLogo" width="219"/>';

                          }

                    ?>
               </div>
               <div class="input-group mb-3">
                  <div class="input-group-prepend">
                      <SELECT id = "country"  class ="custom-select commandAction" >
                           <option value="">Select Country</option>
                           <?php include 'countryList.php';
                           echo $country; ?>
                      </select>
                  </div>
               </div>
               <div class="input-group mb-3">
                    <div class="input-group-prepend">
                       <SELECT id = "company"  class ="custom-select commandAction">
                           <option value="">Select Company</option>
                       </SELECT>
                    </div>
               </div>
               <div class="input-group mb-3">
                    <div class="input-group-prepend">
                       <SELECT id = "bsb_id" class ="custom-select commandAction" onmousedown="if(this.options.length>5){this.size=5;}"
                         onchange="this.blur()"  onblur="this.size=1;" >
                           <option size="5" value="">Select BSB ID</option>
                       </SELECT>
                   </div>
               </div>
                 <!-- audio history employee -->
               <div>
                    <button type="button" class="btn btn-success" id="audioArchive" data-toggle="modal" data-target="#audioRecordHistory">Employee Audio Archive</button>
                </div>
            </div>

            <div class="commandColumnRight" >
                <div>
                    <table class = "table_header_branch">
                        <tr >
                            <td id="emp_info">Firstname</td>
                        </tr>
                        <tr>
                            <td><input class="card text-white bg-primary mb-3 inputbox" type="text" id="staff_fname" readonly="readonly"/></td>
                        </tr>
                        <tr>
                            <td id="emp_info">Surname</td>
                        </tr>
                        <tr>
                            <td><input class="card text-white bg-primary mb-3 inputbox" type="text" id="staff_surname" readonly="readonly"/></td>
                        </tr>
                        <tr>
                            <td id="emp_info">Contact Center #</td>
                        </tr>
                        <tr>
                            <td><input class="card text-white bg-primary mb-3 inputbox" type="text" id="staff_contact" readonly="readonly"/></td>
                        </tr>
                        <tr>
                            <td><div id = "staffAlertLevel">
                              <button type="button" id="moreInfoBtn" class="btn btn-success btn-md subbers" data-toggle="modal" data-target="#moreInfo">More Information</td>
                        </tr>

                        <tr>
                            <td colspan="3"><input type="text" name="in_staffid" readonly></td>
                        </tr>
                    </table>
                </div>
            </div>

       </div>

       <div id = "blueLineSeparation"></div>
       <div class="row" id="rowDuress">
            <div id = "duressTitle">
                Duress Event
            </div>
            <div id = "duressSearchEvent">
                <input type="text" name="employee_search" id="queryEvent" class="form-control mr-sm-2"
                      autocomplete="off" placeholder="Search Duress Event"/>
                <i class="fa fa-search"></i>
            </div>
            <div class="staffListWithAlert" >

                <div>
                    <table class = "table_staff_header">
                        <tr>
                            <td style="padding-left: 10px; width: 80px;">Staff ID </td>
                            <td style="width: 88px;">Firstname</td>
                            <td style="width: 90px;">Surname</td>
                            <td style="width: 95px;">Alert</td>
                            <td style="width: 90px;">Time</td>
                            <td style="width: 113px;">Date</td>
                            <td style="width: 125px;">Acknowledge</td>
                        </tr>
                    </table>
                </div>
                <div id="table-responsive">
                </div>
            </div>


       </div>

   </div>

</div>

</body>
</html>

<!-- Modal for Employee Audio History -->
<div class="modal fade" id="audioRecordHistory" >
    <div class="modal-dialog modal-lg" >
        <div class="modal-content">
            <div class="close"><button type="button" class="close" data-dismiss="modal">&times;</button></div>
            <div class="modal-header empAudioHeader">
                <h4 class="modal-title empHeader">Employee Audio History</h4>
            </div>

            <!-- Modal Body-->
            <div class="modal-body">
                <div class="searchRow">
                    <div><input type="text" name="employeAudioSearch" id="queryAudio" class="form-control mr-sm-2"
                                      autocomplete="off" placeholder="Search Employee"/>
                    </div>
                    <div><button class="btn btn-primary" type="submit" id="searchAudio">SEARCH</button></div>
                </div>

                <div class="tableEmpAudioContainer">
                    <div id="leftAudioTable">
                       <table>
                            <th id="paddingBottomAudio">Employee</th>
                                <tr id = "audioTitleColumn">
                                    <td id="colAudioID" >Staff ID</td>
                                    <td id="colAudioFname">Firstname</td>
                                    <td id="colAudioLname">Lastname</td>
                                </tr>
                            </table>
                        <div id="tableAudioStaff"><center>
                            <?php
                                $query = $conn->query("SELECT * FROM list_of_images WHERE id = 5");
                                if($query){
                                  while($row = $query->fetch_assoc()){
                                    echo "<img src=data:image;base64," .base64_encode($row['image']). " class='img-square' height=200 width=200 style='margin-top: 25%;'/>";
                                  }
                                }
                            ?></center></div>
                    </div>
                    <div id="listOfEmployeeAudioHistory">
                        <table>
                            <th id="paddingBottomAudio">Audio</th>
                            <tr id = "audioTitleColumn">
                                <td id="colAudioFile" >Audio Files </td>
                            </tr>
                         </table>
                         <div id="listOfAudioHistory"> </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>


<!-- The Modal -->
  <div class="modal fade" id="moreInfo" style="z-index: 1400;">
    <div class="modal-dialog modal-lg" style="margin-top: 112px; width: 674px;">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title" id="moreInfoTitle">More Information</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <!-- Modal body -->
        <div class="modal-body">

          <div class="row">
            <div class="col">
              <div class="form-group">
          <input type="text" id="staffId" class="form-control" hidden readonly />
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col">
            <div class="form-group">
          <label for="staffName">Name</label></br>
          <center><span id="staffName" style="font-size: 25px; font-weight: bold; text-align: center;"></span></center>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col">
            <div class="form-group">
              <center><div id="staffLoc">
                  <div id="map"></div>
                  <div id="audioDiv"></div>
              </div></center>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col" style="margin-top: 30px;">
            <div class="form-group">
              <div id="controlButtons">
                <button type="button" class="btn btn-primary btn-sm ctrls" id="showMap" style="margin-left: 15px;">Location</button>
                <button type="button" class="btn btn-primary btn-sm ctrls" id="audioH">Audio History</button>
                <button type="button" class="btn btn-primary btn-sm ctrls" id="callBtn">Call Contact Center</button>
                <button type="button" class="btn btn-primary btn-sm ctrls" id="resetAlert" >Reset</button>
              </div>
            </div>
          </div>
        </div>
        </div>
      </div>
    </div>
  </div>


  <script src="../jquery/itemSelect.js"></script>
  <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDfVQMqJllW2hYaUinxrVKnwB2fBOXedL0"></script>
