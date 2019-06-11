<?php include "dbconnect.php" ?>
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
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
  <script src="../libs/sweetalert/sweetalert2.all.min.js"></script>


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
          <a class="navbar-brand" href="#">
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
                <a class="nav-link" data-toggle="tooltip" title="Audio History" href="audioArchive.php"><i class="material-icons md-50 music">library_music</i></a>
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


    <div class="row" style="padding-top: 10px;">
        <div class="col-xs-12 col-md-12 col-lg-7" >
            <div class="table-responsive eventBox">
                <div>
                    <table class="table" style="width=100%" >
                        <tr>
                            <th colspan="6" style="text-align:center; background-color:#405189">Events</th>
                        </tr>
                    </table>
                </div>

                <div id="eventUpdates">
                    <div id="EventLoadingMessageMain"></div>
                 </div>

            </div>
        </div>
        <div class="col-xs-12 col-md-12 col-lg-5">
            <div class="mapBox">
                <ul class="nav nav-tabs nav-tabs-map">
                    <li class="nav-item" >
                      <a class="nav-link active nav-link-map" data-toggle="tab" href="#Map">Map</a>
                    </li>
                    <li class="nav-item tracksTab">
                      <a class="nav-link nav-link-map" data-toggle="tab" href="#Tracks">Tracks</a>
                    </li>
                  </ul>
                <div class="tab-content">
                    <div id="Map" class="containerMap tab-pane active"><br>
                       <div id="googleMap" style="width:100%; height:434px; margin-top:-20px"></div>
                    </div>
                    <div id="Tracks" class="containerMap tab-pane fade" style="width:100%; height:438px; color:white;"><br>
                      <div id="trackMaps" style="width:100%; height:434px; margin-top:-20px"></div>
                    </div>
                </div>
                <!--
                <div style="text-align:center; color:white; padding-top: 8px;  background-color:#405189; height: 48px"><strong>Map</strong></div>
                <div id="googleMap" style="width:100%; height:372px; margin-top:10px"></div>
                -->
            </div>
        </div>
    </div>
    <div class="row employeeEvent" style="padding-top: 10px;">
        <div class="col-xs-12 col-md-12 col-lg-12">
            <div class="table-responsive employeeBox">
                <table width="100%" class="table table-striped table-hover">
                   <tr>
                      <th colspan="8" style="text-align:center; background-color:#405189">Employee Event Details</th>
                   </tr>
                </table>
                <div id="employeeMainEventDetails"></div>
            </div>
        </div>
    </div>

    <div class="footer"> © 2019 Copyright: SCSI</div>

</div>
<script>
    function myMap() {
    // var mapProp= {
    //   center:new google.maps.LatLng(-25.734968,134.489563),
    //   zoom:3,
    // };
    // var map = new google.maps.Map(document.getElementById("googleMap"),mapProp);
    // }

    map = new google.maps.Map(document.getElementById('googleMap'), {
          center: {lat: -34.397, lng: 150.644},
          zoom: 3
        });
        infoWindow = new google.maps.InfoWindow;

        // Try HTML5 geolocation.
        if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(function(position) {
            var pos = {
              lat: position.coords.latitude,
              lng: position.coords.longitude
            };

            infoWindow.setPosition(pos);
            infoWindow.setContent('You are here!');
            infoWindow.open(map);
            map.setCenter(pos);
          }, function() {
          //  handleLocationError(true, infoWindow, map.getCenter());
          });
        } else {
          // Browser doesn't support Geolocation
          handleLocationError(false, infoWindow, map.getCenter());
        }
      }

      function handleLocationError(browserHasGeolocation, infoWindow, pos) {
        infoWindow.setPosition(pos);
        infoWindow.setContent(browserHasGeolocation ?
                              'Error: The Geolocation service failed.' :
                              'Error: Your browser doesn\'t support geolocation.');
        infoWindow.open(map);
      }
</script>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDfVQMqJllW2hYaUinxrVKnwB2fBOXedL0&callback=myMap"></script>


</body>
</html>

 <script src="../jquery/itemSelect.js"></script>
