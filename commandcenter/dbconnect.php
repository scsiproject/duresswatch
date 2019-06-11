<?php

define('DB_SERVER', '161.43.114.22');
define('DB_USERNAME', 'SCSI');
define('DB_PASSWORD', 'Au5tral1A');
define('DB_DATABASE', '000001');
$conn = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);
     if (mysqli_connect_errno()) {
        die("Connect failed: %s\n" + mysqli_connect_error());
        exit();
     }

 ?>
