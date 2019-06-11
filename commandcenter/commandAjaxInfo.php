<?php
include "dbconnect.php";

$output = '';
$query ="SELECT e.ev_idn, e.fi_nam, e.la_nam, e.st_idn, e.lo_idn, e.wa_typ, e.ev_tim, e.ev_cnt, e.wa_ack, e.wa_idn, i.image FROM ev as e
         INNER JOIN list_of_images as i ON i.image_name = e.wa_typ
         WHERE e.wa_typ = 'G'
               OR e.wa_typ = 'O'
         	   OR e.wa_typ = 'R'
               AND wa_typ != 'A'
         ORDER BY wa_typ DESC, ev_tim DESC";
$result = mysqli_query($conn, $query);
$output .= '<table id ="staffTableMain" class="table table-striped table-dark table-hover">';
$output .='<thead>
                <tr>
                    <th id="eventTH" >Firstname</th>
                    <th id="eventTH">Lastname</th>
                    <th id="eventTH">Time</th>
                    <th id="eventTH">Location</th>
                    <th id="eventTH">Status</th>
                    <th id="eventTH">Duration</th>
                </tr>
          </thead>';
$output .= '<tbody>';
while($row=mysqli_fetch_array($result)){
      $output .= '<tr id ="StaffTableRowItem">';
      $output .= '<td id="StaffTableColumnItem" style="width: 15%;">'.$row["fi_nam"].'</td>';
      $output .= '<td id="StaffTableColumnItem" style="width: 19%;">'.$row["la_nam"].'</td>';
      $output .= '<td id="StaffTableColumnItem" style="width: 3%; class="ev_t">'.$row["ev_tim"].'</td>';
      $output .= '<td id="StaffTableColumnItem" style="width: 15%;" class="locid">'.$row["lo_idn"].'</td>';
      $output .= '<td id="StaffTableColumnItem" style="width: 15%;" ><img src="data:image/png;base64,'.$row['image'].' "class="alertLogo"/></td>';
      $output .= '<td id="StaffTableColumnItem" style="width: 5%;">'.$row["ev_cnt"].'</td>';
      $output .= '<td id="StaffTableColumnItem" style="display:none;" class="waidn">'.$row["wa_idn"].'</td>';
      $output.= '<td id="StaffTableColumnItem" class="evidn" style="display:none;">'.$row["ev_idn"].'</td>';
      $output .= '</tr>';




  }
$output .= '</tbody>';
$output .= '</table>';
echo $output;

?>