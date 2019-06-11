<?php
include "dbconnect.php";

$record_per_page = 5; // number of records to display
$page = '';
$output = '';

if(isset($_POST["query"]))
 {
      $page = $_POST["query"];
 }
 else
 {
      $page = 1;
 }

$start_from = ($page - 1) * $record_per_page;
$query ="SELECT e.fi_nam, e.la_nam, e.lo_idn, e.ev_tim , e.wa_typ, e.wa_ack, e.cc_ack, i.image FROM evlog as e
         INNER JOIN list_of_images as i ON i.image_name = e.wa_typ
                 WHERE e.wa_typ = 'G'
                       OR e.wa_typ = 'O'
                 	   OR e.wa_typ = 'R'
                       OR e.wa_typ = 'A'
                 ORDER BY ev_tim DESC LIMIT $start_from, $record_per_page";

$result = mysqli_query($conn, $query);
$output .= '<table id ="staffTableMain" class="table table-striped table-dark table-hover">';
    while($row=mysqli_fetch_array($result)){

           $output .= '<tr id ="StaffTableRowItem">';
               $output .= '<td id="StaffTableColumnItem" style="width: 88px;">'.$row["fi_nam"].'</td>';
               $output .= '<td id="StaffTableColumnItem" style="width: 90px;">'.$row["la_nam"].'</td>';
               $output .= '<td id="StaffTableColumnItem" style="width: 80px;" class="locid">'.$row["lo_idn"].'</td>';
               $output .= '<td id="StaffTableColumnItem" style="width: 110px;" ><img src="data:image/png;base64,'.$row['image'].' "class="alertLogo"/></td>';
               $output .= '<td id="StaffTableColumnItem" style="width: 110px;">'.$row["ev_tim"].'</td>';
               $output .= '<td id="StaffTableColumnItem" style="width: 110px;">'.$row["wa_ack"].'</td>';
               $output .= '<td id="StaffTableColumnItem" style="width: 110px;">'.$row["cc_ack"].'</td>';
           $output .= '</tr>';
    }
$output .= '</table><div align="center">';
$page_query = "SELECT e.fi_nam, e.la_nam, e.lo_idn, e.ev_tim , e.wa_typ, e.wa_ack, e.cc_ack, i.image FROM evlog as e
                        INNER JOIN list_of_images as i ON i.image_name = e.wa_typ
                                WHERE e.wa_typ = 'G'
                                      OR e.wa_typ = 'O'
                                	  OR e.wa_typ = 'R'
                                      OR e.wa_typ = 'A'
                                ORDER BY ev_tim DESC ";
    $page_result = mysqli_query($conn, $page_query);
    $total_records = mysqli_num_rows($page_result);
    $total_pages = ceil($total_records/$record_per_page);
    for($i=1; $i<=$total_pages; $i++)
    {
         $output .= "<span class='pagination_link' style='cursor:pointer; border:1px solid #ccc;' id='".$i."'>".$i."</span>";
    }
    $output .= '</div>';

    echo $output;

?>