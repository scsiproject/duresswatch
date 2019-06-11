<?php

include "dbconnect.php";

$actionID = $_POST["actionType"];
$waidn = $_POST["waidn"];
$evidn = $_POST["evidn"];


$actionID ='Made A Call';

$query = "UPDATE ev, evlog
        SET ev.cc_ack = '".$actionID."',
            evlog.cc_ack = '".$actionID."'
         WHERE ev.ev_idn = evlog.ev_idn
         AND ev.wa_idn = '".$waidn."'
         AND ev.ev_idn =  '".$evidn."'";


$result = mysqli_query($conn, $query);

//echo $waidn;
//echo $evidn;
//print_r($_POST);
?>
