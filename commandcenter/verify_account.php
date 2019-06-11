<?php
session_start();
include "dbconnect.php";
	$msg = "";

	if (isset($_POST['username']) && isset($_POST["password"]) && isset($_POST["privlev"])) {


		$username = $conn->real_escape_string($_POST['username']);
		$password = $conn->real_escape_string($_POST['password']);
		$privlev = $_POST['privlev'];

		$sql = "SELECT login_user, login_password, level, user_role FROM access_login WHERE login_user = '".$username."' AND level = '".$privlev."'";
		$result = mysqli_query($conn, $sql);
		$num_rows = mysqli_num_rows($result);
		if ($num_rows > 0) {
				$data = mysqli_fetch_array($result);
		    if (password_verify($password, $data['login_password'])) {
						$_SESSION["privlev"] = $data["level"];
						$_SESSION["username"] = $data["login_user"];
						$_SESSION["user_role"] = $data["user_role"];
						echo $data["login_user"];
						echo $data["level"];
						echo $data["user_role"];
            }
          }


        }
          // else
          // $msg = "No such username exists.";

?>
