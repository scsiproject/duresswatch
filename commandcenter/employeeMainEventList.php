<?php

include_once('dbconnect.php');

if(isset($_POST['waidn'])){
    $output='';
    $query = " select tb1.ev_idn, tb1.st_idn, tb1.lo_idn,tb1.wa_grp, tb1.wa_typ, tb1.ev_tim, tb1.wa_ack, tb2.image_name, tb2.image from
     (Select ev_idn, st_idn, lo_idn, wa_grp, ev_tim, wa_ack, wa_idn, wa_typ, case when wa_typ = 'R' then 'redalert' when wa_typ = 'G' then 'greenalert'
      when wa_typ = 'O' then 'orangealert' when wa_typ = 'A' then 'acknowledge' end as coloralert from ev)
      as tb1 join (select * from list_of_images) as tb2 on (tb1.coloralert = tb2.image_name)
      where wa_idn = '".$_POST['waidn']."'";

    $result = mysqli_query($conn, $query);
    $output .= '<table id ="employeeEventDetailsTable" class="table table-striped table-dark table-hover">';
    $output.='<thead>
                   <tr>
                        <th id="eventTH">Branch</th>
                        <th id="eventTH">Group</th>
                        <th id="eventTH">Alert</th>
                        <th id="eventTH">Date and Time</th>
                        <th id="eventTH">Acknowledge</th>
                        <th id="eventTH">Action</th>
                   </tr>
            </thead>';
    $output.='<tbody>';
    if(mysqli_num_rows($result) > 0){

        while($row = mysqli_fetch_array($result)){

            if(!empty($row["wa_ack"])){

                $query2 = "SELECT ev.ev_idn, ev.lo_idn, ev.wa_typ, ev.wa_grp, dpa.fi_nam, dpa.la_nam FROM ev
                    INNER JOIN dpa ON ev.lo_idn = dpa.lo_idn
                    WHERE dpa.wa_idn = '".$row["wa_ack"]."'";

                $result2 = mysqli_query($conn, $query2);
                if(mysqli_num_rows($result2) > 0){
                    while($row2 = mysqli_fetch_array($result2)){
                        $name = $row2["fi_nam"] ." ". $row2["la_nam"];
                    }
                }
            }else{

                $name = "";
            }

            if($row["wa_typ"] =='A'){
                $output.='<tr id ="employeeEventDetailsRow">';
                    $output.='<td id="employeeEventDetailsCol">'.$row["lo_idn"].'</td>';
                    $output.='<td id="employeeEventDetailsCol">'.$row["wa_grp"].'</td>';
                    $output.='<td id="employeeEventDetailsCol">
                                <div class="dropdown">
                                <img src="data:image/png;base64,'.$row['image'].'" id="eventAlertLogo" />
                                </div>
                             </td>';
                    $output.='<td id="employeeEventDetailsCol">'.$row["ev_tim"].'</td>';
                    $output.='<td id="employeeEventDetailsCol">'.$name.'</td>';
                    $output.='<td id="employeeEventDetailsCol"> </td>';
                $output.='</tr>';
            }else{
                $output.='<tr id ="employeeEventDetailsRow">';
                    $output.='<td id="employeeEventDetailsCol">'.$row["lo_idn"].'</td>';
                    $output.='<td id="employeeEventDetailsCol">'.$row["wa_grp"].'</td>';
                    $output.='<td id="employeeEventDetailsCol">
                                <div class="dropdown"  data-toggle="tooltip" title="Change Alert">
                                <img src="data:image/png;base64,'.$row['image'].'" class="dropdown-toggle" id="eventAlertLogo" data-toggle="dropdown"/>
                                        <ul class="dropdown-menu alertDropdown">
                                             <li class = "list" id="G">Green</li>
                                             <li class = "list" id="O">Orange</li>
                                             <li class = "list" id="R">Red</li>
                                        </ul>
                                </div>
                             </td>';
                    $output.='<td id="employeeEventDetailsCol">'.$row["ev_tim"].'</td>';
                    $output.='<td id="employeeEventDetailsCol">'.$name.'</td>';
                    $output.='<td id="employeeEventDetailsCol">
                                <select id="selectAction" name="type">
                                  <option selected disabled>Select Action </option>
                                  <option value="listenAudio">Listen To Audio</option>
                                  <option value="makeCall">Make A Call</option>
                                  <option value="otherAction">Others, please specify</option>
                                </select>
                                <div id="inputAction">
                                    <textarea id="inputActionField" rows=3 cols=30">Type your comments here and press Enter to submit</textarea>
                                </div>
                              </td>';
                $output.='</tr>';

            }

        } //end of while
    $output.='</tbody>';
    $output.='</table>';
  } // end of if(rows)

echo $output;
}


?>