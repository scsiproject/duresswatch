<?php

include "dbconnect.php";

$watyp = $_POST["list_id"];
$waidn = $_POST["waidn"];

$query = "UPDATE ev SET wa_typ = '".$watyp."' WHERE wa_idn = '".$waidn."' AND wa_typ != 'A' ";

$result = mysqli_query($conn, $query);

echo $waidn;

?>

