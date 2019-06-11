<?php
include "dbconnect.php";

$output = '';

 //$br = strval($_POST['br']);
 //$empl = $_POST['empl'];
 //$fd = $_POST['fd'];
 //$td = $_POST['td'];

//if(isset($_POST["q"])){
//  $page = $_POST["q"];
//}
//else {
//  $page = 1;
//}

//$st_fr = ($page - 1) * $record_per_page;

$output .= '<table id ="employeeEventDetailsTable" class="table table-striped table-dark table-hover">';
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

$query = "SELECT e.wa_idn, e.fi_nam, e.la_nam, e.lo_idn, i.image, e.ev_tim , e.wa_typ, e.wa_ack, e.cc_ack FROM evlog e
         INNER JOIN list_of_images i ON i.image_name = e.wa_typ
                 WHERE e.wa_idn = '".$_POST["empl"]."' AND e.lo_idn = '".$_POST["br"]."'
                 AND e.ev_tim BETWEEN '".$_POST["from_date"]."' AND '".$_POST["to_date"]."'
                 ORDER BY e.ev_tim DESC";

 // $query = "SELECT * FROM evlog WHERE wa_idn = '".$_POST["empl"]."' AND lo_idn = '".$_POST["br"]."' AND ev_tim BETWEEN '".$_POST["from_date"]."' AND '".$_POST["to_date"]."'";

$result = mysqli_query($conn, $query) or die(mysqli_error($conn));
    while($row = mysqli_fetch_array($result)){

           $output .= '<tr id ="StaffTableRowItem">';
               $output .= '<td id="StaffTableColumnItem" style="width: 88px;">'.$row["fi_nam"].'</td>';
               $output .= '<td id="StaffTableColumnItem" style="width: 90px;">'.$row["la_nam"].'</td>';
               $output .= '<td id="StaffTableColumnItem" style="width: 80px;">'.$row["lo_idn"].'</td>';
               $output .= '<td id="StaffTableColumnItem" style="width: 110px;" ><img src="data:image/png;base64,'.$row['image'].' "class="alertLogo"/></td>';
               $output .= '<td id="StaffTableColumnItem" style="width: 110px;">'.$row["ev_tim"].'</td>';
               $output .= '<td id="StaffTableColumnItem" style="width: 110px;">'.$row["wa_ack"].'</td>';
               $output .= '<td id="StaffTableColumnItem" style="width: 110px;">'.$row["cc_ack"].'</td>';
           $output .= '</tr>';
    }

$output.='</tbody>';
$output .= '</table>';
echo $output;

?>
