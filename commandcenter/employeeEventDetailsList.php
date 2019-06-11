<?php  include 'dbconnect.php';

$item_per_page = 7; // This is the number of results we want displayed per page

if(isset($_POST["page"])){
	$page_number = filter_var($_POST["page"], FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH); //filter number
	if(!is_numeric($page_number)){die('Invalid page number!');} //incase of invalid page number
}else{
	$page_number = 1; //if there's no page number, set it to 1
}

//get total number of records from database
$sql = "SELECT COUNT(wa_idn), wa_typ FROM evlog WHERE wa_typ = 'G' OR wa_typ = 'A' OR wa_typ = 'R' OR wa_typ = 'O'";
$query = mysqli_query($conn, $sql);
$row = mysqli_fetch_row($query);
$get_total_rows = $row[0]; //hold total records in variable
//break records into pages
$total_pages = ceil($get_total_rows/$item_per_page);

//position of records
$page_position = (($page_number-1) * $item_per_page);

$sql="SELECT e.wa_idn, e.fi_nam, e.la_nam, e.lo_idn, e.ev_tim , e.wa_typ, e.wa_ack, e.cc_ack, i.image FROM evlog as e
                  INNER JOIN list_of_images as i ON i.image_name = e.wa_typ
                          WHERE e.wa_typ = 'G'
                                OR e.wa_typ = 'O'
                          	   OR e.wa_typ = 'R'
                                OR e.wa_typ = 'A'
                          ORDER BY ev_tim DESC LIMIT $page_position, $item_per_page";

 $query = mysqli_query($conn, $sql);
 // Establish the $paginationCtrls variable

 echo '<table id ="staffTableMain" class="table table-striped table-dark table-hover">';
 echo '<thead>
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
 echo'<tbody>';
 while($row = mysqli_fetch_array($query, MYSQLI_ASSOC)){
      echo '<tr id ="StaffTableRowItem">';
                    echo '<td id="StaffTableColumnItem" style="width: 88px;">'.$row["fi_nam"].'</td>';
                    echo '<td id="StaffTableColumnItem" style="width: 90px;">'.$row["la_nam"].'</td>';
                    echo '<td id="StaffTableColumnItem" style="width: 80px;">'.$row["lo_idn"].'</td>';
                    echo '<td id="StaffTableColumnItem" style="width: 80px;" ><img src="data:image/png;base64,'.$row['image'].' "class="alertLogo"/></td>';
                    echo '<td id="StaffTableColumnItem" style="width: 110px;">'.$row["ev_tim"].'</td>';
                    echo '<td id="StaffTableColumnItem" style="width: 110px;">'.$row["wa_ack"].'</td>';
                    echo '<td id="StaffTableColumnItem" style="width: 110px;">'.$row["cc_ack"].'</td>';
                    echo '<td id="StaffTableColumnItem" style="width: 110px; display:none;">'.$row["wa_idn"].'</td>';
      echo '</tr>';

  }

echo '</tbody>';
echo '</table>';
echo '<div class="paginationcenter">';
echo  paginate_function($item_per_page, $page_number, $get_total_rows[0], $total_pages);
echo '</div>';

################ pagination function #########################################
function paginate_function($item_per_page, $current_page, $total_records, $total_pages)
{
    $pagination = '';
    if($total_pages > 0 && $total_pages != 1 && $current_page <= $total_pages){ //verify total pages and current page number
        $pagination .= '<ul class="pagination">';

        $right_links    = $current_page + 3;
        $previous       = $current_page - 1; //previous link
        $next           = $current_page + 1; //next link
        $first_link     = true; //boolean var to decide our first link

        if($current_page > 1){
			$previous_link = ($previous==0)? 1: $previous;
            $pagination .= '<li class="first"> <button class="buttonStyle"><a href="#" data-page="1" title="First" style="color:white">&laquo;</a></button></li>'; //first link
            $pagination .= '<li><button class="buttonStyle"><a href="#" data-page="'.$previous_link.'" title="Previous" style="color:white">PREVIOUS</a></button></li>'; //previous link
                for($i = ($current_page-2); $i < $current_page; $i++){ //Create left-hand side links
                    if($i > 0){
                        $pagination .= '<li><button class="buttonStyle"><a href="#" data-page="'.$i.'" title="Page'.$i.'" style="color:white">'.$i.'</a></button></li>';
                    }
                }
            $first_link = false; //set first link to false
        }

        if($first_link){ //if current active page is first link
            $pagination .= '<li class="first active"><button>'.$current_page.'</button></li>';
        }elseif($current_page == $total_pages){ //if it's the last active link
            $pagination .= '<li class="last active"><button>'.$current_page.'</button></li>';
        }else{ //regular current link
            $pagination .= '<li class="active"><button>'.$current_page.'</button></li>';
        }

        for($i = $current_page+1; $i < $right_links ; $i++){ //create right-hand side links
            if($i<=$total_pages){
                $pagination .= '<li><button class="buttonStyle"><a href="#" data-page="'.$i.'" title="Page '.$i.'" style="color:white">'.$i.'</a></button></li>';
            }
        }
        if($current_page < $total_pages){
				$next_link = ($i > $total_pages) ? $total_pages : $i;
                $pagination .= '<li><button class="buttonStyle"><a href="#" data-page="'.$next_link.'" title="Next" style="color:white">NEXT</a></button></li>'; //next link
                $pagination .= '<li class="last"><button class="buttonStyle"><a href="#" data-page="'.$total_pages.'" title="Last" style="color:white">&raquo;</a></button></li>'; //last link
        }

        $pagination .= '</ul>';
    }
    return $pagination; //return pagination links
}


?>