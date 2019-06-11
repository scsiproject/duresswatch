<?php
include 'dbconnect.php';


$output = '';
if(isset($_POST["query"])){

    $search = $_POST["query"];
    $search = str_replace(' ','',$search);
    $query = "
        SELECT DISTINCT fi_nam, la_nam, wa_idn FROM aud WHERE UPPER(CONCAT(fi_nam,' ',la_nam)) LIKE UPPER('%".$search."%') ORDER BY fi_nam,la_nam ASC
    ";

    $result = mysqli_query($conn, $query);
    if(mysqli_num_rows($result) > 0){


        $output .= '<table id ="audioStaffTableMain" class="table table-striped table-hover">';
        $output .= '<thead>
                        <tr>
                            <th id="audioTH">Watch ID</th>
                            <th id="audioTH" >Firstname</th>
                            <th id="audioTH">Lastname</th>

                        </tr>
                    </thead>';
        $output .= '<tbody>';
        while($row = mysqli_fetch_array($result))
            {

                $output .= '<tr id ="audioStaffTableRowItem">';
                $output .= '<td id="audioStaffTableWatchId" class="waidn">'.$row["wa_idn"].'</td>';
                $output .= '<td id="audioStaffTableFirstname">'.$row["fi_nam"].'</td>';
                $output .= '<td id="audioStaffTableSurname">'.$row["la_nam"].'</td>';

                $output .= '</tr>';

            }



    }else{
         $output .= '<tr>';
         $output .= '<td>No Data Found</td>';
         $output .= '<tr>';
    }

    $output .= '</tbody>';
    $output .= '</table>';

    //console.log($_POST["query"]);
    echo $output;
}


?>