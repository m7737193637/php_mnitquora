<?php
	include 'database.php';
	if(!empty($_POST))
	{
		$usrname=$_POST["username"];
		$psw=$_POST["password"];
		$email=$_POST["email"];
		$sql= "INSERT INTO accounts (username, password, email) VALUES ('$usrname', '$psw', '$email' )";
		$qstat =mysqli_query($connection, $sql);
		if(!$qstat)
		{
						die(" nhi chali" . mysqli_error($connection));

		}
		else
		{
			session_start();	
			$_SESSION['username'] = $usrname;
			header("Location: welcome.php");
			exit();
		}
	}
?>