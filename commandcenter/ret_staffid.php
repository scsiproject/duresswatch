<?php

//(ret_staffid.php) retrieving staff_id from "ev" table

require('dbconnect.php');

if(isset($_POST['stidn'])){

  $query = $conn->query("SELECT st_idn FROM ev WHERE st_idn = " .$_POST['stidn']);

  if($query){
    while($row = $query->fetch_assoc()){
      echo $row['st_idn'];
    }
  }
}

 ?>
