<?php

include "dbconnect.php";

$waidn = $_POST['waidn'];
$evidn = $_POST["evidn"];
$actionID = $_POST["actionType"];

$query = "SELECT wa_idn, MAX(au_wav) as au FROM aud WHERE wa_idn = '".$waidn."' ORDER BY wa_idn ASC LIMIT 1";
$res = mysqli_query($conn, $query);

  while($row = mysqli_fetch_array($res)){
    $o = "http://161.43.114.22:8080/audio/" .$row["au"]. "";
  }
echo $o;

$actionID ='Listen To Audio';

$query2  = "UPDATE ev, evlog
                  SET ev.cc_ack = '".$actionID."',
                      evlog.cc_ack = '".$actionID."'
                   WHERE ev.ev_idn = evlog.ev_idn
                   AND ev.wa_idn = '".$waidn."'
                   AND ev.ev_idn =  '".$evidn."'";

 $result = mysqli_query($conn, $query2);



 ?>
