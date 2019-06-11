<?php

require('dbconnect.php');

  $query = $conn->query("SELECT COUNT(*) as count FROM ev WHERE wa_typ <> 'X' ");

  if($query){
    while($row = $query->fetch_assoc()){
      echo $row['count'];
    }
  }

 ?>
