<?php

//retrieve latitude and longitude from device and event table

require_once 'dbconnect.php';
$query='';

if(isset($_POST['waidn'])){

  $query = $conn->query("SELECT DISTINCT wa_lat, wa_lon FROM ev where wa_idn = '" .$_POST['waidn']. "'");

  if($query){
    while($row = $query->fetch_assoc()){
      echo $row['wa_lat'] ."/". $row['wa_lon'];
    }
  }
}
print_r($query);
?>