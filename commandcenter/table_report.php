<?php
include 'dbconnect.php';



if(isset($_POST["reportSelected"])){

    $output ='';

    if($_POST["reportSelected"] == "branch"){
        $query = "SELECT wa_idn, concat(fi_nam,' ', la_nam) as fullname, lo_idn FROM evlog WHERE lo_idn = '".$_POST["query"]."' GROUP BY wa_idn ";
        $result = mysqli_query($conn, $query);
        $output = '<option value="">Select Employee</option>';
              while($row = mysqli_fetch_array($result)){


                    $output .= '<option value="'.$row["wa_idn"].'">'.$row["fullname"].'</option>';
              }

    }


     echo $output;
}
?>
