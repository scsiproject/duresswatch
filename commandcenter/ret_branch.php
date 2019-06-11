<?php

$branch = '';
$query = "SELECT DISTINCT lo_idn FROM evlog";
$result = mysqli_query($conn, $query);
while($row = mysqli_fetch_array($result))
{
 $branch .= '<option value="'.$row["lo_idn"].'">'.$row["lo_idn"].'</option>';
}

?>
