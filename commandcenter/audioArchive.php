<?php include 'dbconnect.php'; ?>
<?php header('Access-Control-Allow-Origin: *'); ?>
<?php
     // session_start();
     // if(!isset($_SESSION["username"]))
     // {
     //   header("location: /duresswatch/");
     // }
     // else{
     //   if($_SESSION["privlev"] == "Command_center"){
     //     header("location: commandCenterLogin.php");
     //   }
     // }
     ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Command Center</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
   <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
  <script src="../libs/sweetalert/sweetalert2.all.min.js"></script>

 <!-- additional plugin for date picker-->
  <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
  <link rel="stylesheet" href="http://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">

  <!-- Font Awesome JS -->
      <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
      <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>

      <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

  <!-- Our Custom CSS-->
      <link rel="stylesheet" href="../css/commandCenter.css">

</head>
<body>
<div class="container">
    <nav class="navbar navbar-expand-lg  navbar-dark" >
         <a class="navbar-brand" data-toggle="tooltip" title="Back To Home Page" href="commandCenterLogin.php">
                      <?php
                           $sql="SELECT * FROM list_of_images WHERE id = 9";
                           $result=mysqli_query($conn,$sql);
                           while($row=mysqli_fetch_array($result))
                           {
                              echo '<img src="data:image/png;base64,'.$row['image'].' "class="companyImageLogo"/>';

                           }
                      ?>
                   </a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="collapsibleNavbar">
            <ul class="navbar-nav">
              <li class="nav-item">
                <a class="nav-link" data-toggle="tooltip" title="Reports"  href="report.php" ><i class="material-icons md-50 assign">assignment</i></a>
              </li>
              <li class="nav-item">
                <a class="nav-link" data-toggle="tooltip" title="Audio History" href=#"><i class="material-icons md-50 music">library_music</i></a>
              </li>
            </ul>
            <ul class="navbar-nav ml-auto">
              <!--<li class="nav-item">
                <div class="dropdown selectLocation">
                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                      Select Location
                    </button>
                    <div class="dropdown-menu">
                      <a class="dropdown-item" href="#">Link 1</a>
                      <a class="dropdown-item" href="#">Link 2</a>
                      <a class="dropdown-item" href="#">Link 3</a>
                    </div>
                  </div>
              </li>-->
              <li class="nav-item">
                <a class="nav-link" data-toggle="tooltip" title="Exit Command Center" href="../logout.php"><i class="material-icons md-50 orangeExit ">exit_to_app</i></a>
              </li>
            </ul>
          </div>
    </nav>


    <div class="row card" style = "margin-left:0px; margin-right:0px; margin-top:10px; margin-bottom:5px;padding:20px; text-align:center; background: #131633;">
        <div class="empAudioHeader">
               <h4 class="modal-title" style="color:white;">Employee Audio History</h4>
        </div>
    </div>
    <div class="row" style="text-align:center">
            <div class="rowSearch">
                <div class="searchBox"><input type="text" name="employeAudioSearch" id="queryAudio" class="form-control mr-sm-5"
                                  autocomplete="off" placeholder="Search Employee"/>
                </div>
                <div class="searchBtn"><button class="btn btn-primary" type="submit" id="searchAudio">SEARCH</button></div>
            </div>
    </div>

    <div class="row" style="padding-top: 10px;">
            <div class="col-xs-12 col-md-12 col-lg-7" >
                <div class="table-responsive audioEventBox">
                    <div>
                        <table class="table" style="width=100%" >
                            <tr>
                                <th colspan="6" style="text-align:center; background-color:#405189">Employee</th>
                            </tr>
                        </table>
                    </div>
                    <div id="tableAudioStaff" >
                        <div id="EventLoadingMessageAudio"></div>  <!-- div id for loading image -->
                     </div>
                </div>
            </div>
            <div class="col-xs-12 col-md-12 col-lg-5">
                <div class="audioBox">
                    <div style="text-align:center; color:white; padding-top: 8px;  background-color:#405189; height: 48px"><strong>Audio Files</strong></div>
                    <div class="table" id="listOfEmployeeAudioHistory">

                         <div id="listOfAudioHistory">  </div>

                    </div>
                </div>
            </div>
    </div>

    <div class="footer"> © 2019 Copyright: SCSI</div>
</div>

</body>
</html>

 <script src="../jquery/itemSelect.js"></script>
