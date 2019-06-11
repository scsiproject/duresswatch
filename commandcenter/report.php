<?php  include 'dbconnect.php';

 $sql = "SELECT COUNT(wa_idn), wa_typ FROM evlog WHERE wa_typ = 'G' OR wa_typ = 'A' OR wa_typ = 'R' OR wa_typ = 'O'";
 $query = mysqli_query($conn, $sql);
 $row = mysqli_fetch_row($query);
 // Here we have the total row count
 $rows = $row[0];
 // This is the number of results we want displayed per page
 $page_rows = 6;
 // This tells us the page number of our last page
 $last = ceil($rows/$page_rows);
 // This makes sure $last cannot be less than 1
 if($last < 1){
 	$last = 1;
 }
 // Establish the $pagenum variable
 $pagenum = 1;
 // Get pagenum from URL vars if it is present, else it is = 1
 if(isset($_GET['pn'])){
 	$pagenum = preg_replace('#[^0-9]#', '', $_GET['pn']);
 }
 // This makes sure the page number isn't below 1, or more than our $last page
 if ($pagenum < 1) {
     $pagenum = 1;
 } else if ($pagenum > $last) {
     $pagenum = $last;
 }
 // This sets the range of rows to query for the chosen $pagenum
 $limit = 'LIMIT ' .($pagenum - 1) * $page_rows .',' .$page_rows;
 // This is your query again, it is for grabbing just one page worth of rows by applying $limit

 $sql="SELECT e.wa_idn, e.fi_nam, e.la_nam, e.lo_idn, e.ev_tim , e.wa_typ, e.wa_ack, e.cc_ack, i.image FROM evlog as e
                  INNER JOIN list_of_images as i ON i.image_name = e.wa_typ
                          WHERE e.wa_typ = 'G'
                                OR e.wa_typ = 'O'
                          	   OR e.wa_typ = 'R'
                                OR e.wa_typ = 'A'
                          ORDER BY ev_tim DESC $limit";

 //$sql = "SELECT wa_idn, fi_nam, la_nam, ev_tim FROM evlog ORDER BY ev_tim DESC $limit";

 $query = mysqli_query($conn, $sql);
 // Establish the $paginationCtrls variable
 $paginationCtrls = '';
 // If there is more than 1 page worth of results
 if($last != 1){
 	/* First we check if we are on page one. If we are then we don't need a link to
 	   the previous page or the first page so we do nothing. If we aren't then we
 	   generate links to the first page, and to the previous page. */
 	if ($pagenum > 1) {
         $previous = $pagenum - 1;
 		$paginationCtrls .= '<button class="buttonStyle"><a href="'.$_SERVER['PHP_SELF'].'?pn='.$previous.'" style="color:white">Previous</a></button> &nbsp; ';
 		// Render clickable number links that should appear on the left of the target page number
 		for($i = $pagenum-2; $i < $pagenum; $i++){
 			if($i > 0){
 		        $paginationCtrls .= '<button class="buttonStyle"><a href="'.$_SERVER['PHP_SELF'].'?pn='.$i.'" style="color:white">'.$i.'</a></button> ';
 			}
 	    }
     }
 	// Render the target page number, but without it being a link
 	$paginationCtrls .= '<button >'.$pagenum.' </button> ';
 	// Render clickable number links that should appear on the right of the target page number
 	for($i = $pagenum+1; $i <= $last; $i++){
 		$paginationCtrls .= '<button class="buttonStyle"><a href="'.$_SERVER['PHP_SELF'].'?pn='.$i.'" style="color:white">'.$i.'</a></button> ';
 		if($i >= $pagenum+2){
 			break;
 		}
 	}
 	// This does the same as above, only checking if we are on the last page, and then generating the "Next"
     if ($pagenum != $last) {
         $next = $pagenum + 1;
         $paginationCtrls .= '  &nbsp; <button class="buttonStyle"><a href="'.$_SERVER['PHP_SELF'].'?pn='.$next.'" style="color:white">Next</a></button> ';
     }
 }
 $output = '';
 $output .= '<table id ="staffTableMain" class="table table-striped table-dark table-hover">';
 $output.='<thead>
                <tr>
                  <th id="reportTH">Firstname</th>
                  <th id="reportTH">Lastname</th>
                  <th id="reportTH">Branch</th>
                  <th id="reportTH">Alert</th>
                  <th id="reportTH">Date and Time</th>
                  <th id="reportTH">Acknowledge</th>
                  <th id="reportTH">Response Taken</th>
                </tr>
            </thead>';
 $output.='<tbody>';
 while($row = mysqli_fetch_array($query, MYSQLI_ASSOC)){
      $output .= '<tr id ="StaffTableRowItem">';
                    $output .= '<td id="StaffTableColumnItem" style="width: 88px;">'.$row["fi_nam"].'</td>';
                    $output .= '<td id="StaffTableColumnItem" style="width: 90px;">'.$row["la_nam"].'</td>';
                    $output .= '<td id="StaffTableColumnItem" style="width: 80px;">'.$row["lo_idn"].'</td>';
                    $output .= '<td id="StaffTableColumnItem" style="width: 80px;" ><img src="data:image/png;base64,'.$row['image'].' "class="alertLogo"/></td>';
                    $output .= '<td id="StaffTableColumnItem" style="width: 110px;">'.$row["ev_tim"].'</td>';
                    $output .= '<td id="StaffTableColumnItem" style="width: 110px;">'.$row["wa_ack"].'</td>';
                    $output .= '<td id="StaffTableColumnItem" style="width: 110px;">'.$row["cc_ack"].'</td>';
                    $output .= '<td id="StaffTableColumnItem" style="width: 110px; display:none;">'.$row["wa_idn"].'</td>';
      $output .= '</tr>';

  }

$output.='</tbody>';
$output .='</table>';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Report</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
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
              <a class="navbar-brand" href="commandCenterLogin.php" data-toggle="tooltip" title="Home Page">
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
                    <a class="nav-link" data-toggle="tooltip" title="Reports"  href="#" ><i class="material-icons md-50 assign">assignment</i></a>
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


    <div class="row" style = "padding-top:20px">
        <div class="form-group col-md-3" >
              <select id="branch" class="form-control  reportSelected" style = "width:100%">
                <option value="" disabled selected>Select Branch</option>
                 <?php include 'ret_branch.php'; echo $branch; ?>
              </select>
        </div>
        <div class="form-group col-md-3" >
                  <select id="employeeList" class="form-control reportSelected"  style="width:100%; ";>
                    <option value="" disabled selected>Select Employee</option>
                  </select>
        </div>
        <div class="col-md-2">
                <input type="text" name="from_date" id="from_date" class="form-control reportSelected" placeholder="From Date"  style="margin-bottom:15px; z-index:4"/>
        </div>
        <div class="col-md-2">
            <input type="text" name="to_date" id="to_date" class="form-control reportSelected" placeholder="To Date" style="margin-bottom:10px"/>
        </div>
        <div class="col-md-2">
            <input type="button" name="filter" id="filter" value="Filter" class="btn btn-info" />
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


                   <div id="reportUpdates" style="color=white; ">
                        <div id="EventLoadingMessageMain"></div>
                   </div>
                </div>
             </div>
        </div>

    <div class="footer"> © 2019 Copyright: SCSI</div>
</div>

</body>
</html>

 <script src="../jquery/itemSelect.js"></script>