<?php
     define('DB_SERVER', 'localhost');
     define('DB_USERNAME', 'root');
     define('DB_PASSWORD', '');
     define('DB_DATABASE', 'chubb');
     $conn = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);
     if (mysqli_connect_errno()) {
        die("Connect failed: %s\n" + mysqli_connect_error());
        exit();
     }

?>
