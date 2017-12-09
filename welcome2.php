<?php
	include 'database.php';
	if(!empty($_POST))
	{
		$usrname=$_POST["username"];
		$psw=$_POST["password"];
		$email=$_POST["email"];
		$hash = md5( rand(0,1000) );
		$sql= "INSERT INTO accounts (username, password, email, hash) VALUES ('$usrname', '$psw', '$email', '$hash' )";

		$qstat =mysqli_query($connection, $sql);
		if(!$qstat)
		{
						die(" nhi chali" . mysqli_error($connection));

		}
		else
		{
			session_start();	
			$_SESSION['username'] = $usrname;	

/*
			$to      = $email; // Send email to our user
			$subject = 'Signup | Verification'; // Give the email a subject 
			$message = '
			Username: '.$usrname.'
			Password: '.$psw.'
			http://www.mnitquora.com/verify.php?email='.$email.'&hash='.$hash.' 
			'; // Our message above including the link
                     
			$headers = 'From:pulkitgarg419@gmail.com' . "\r\n"; // Set from headers
			$retval = mail ($to,$subject,$message,$headers);
         
        	
*/

			header("Location: main.php");
			exit();
		}
	}
?>