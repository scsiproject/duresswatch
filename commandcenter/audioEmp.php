<?php
include 'dbconnect.php';

$output = '';
echo '<div id="EventLoadingMessageAudio"> </div>';

if(isset($_POST["waidn"]))
    {
       $query = "SELECT * FROM aud WHERE wa_idn  = '".$_POST["waidn"]."' ORDER BY ev_tim DESC ";
    }
$result = mysqli_query($conn, $query);


if(mysqli_num_rows($result) > 0)
    {

    $output .= '<table id ="audioTable" class="table table-striped t">';
    $output .= '<tbody>';
     while($row = mysqli_fetch_array($result))
         {

            $output .= '<tr id ="audioTableRowItem">';
            $output .= '<td id="audioTableColumnItem" style="padding-left: 10px;"><a href="http://161.43.114.22:8080/audio/'.$row["au_wav"].'" target="_blank">'.$row["au_wav"].'</a></td>';
            $output .= '</tr>';

         }


}else{

      $output .= '<tr>';
      $output .= '<td>No Audio Available</td>';
      $output .= '</tr>';

}

$output .= '</tbody>';
$output .= '</table>';
echo $output;

?>