<?php
	include 'database.php';
	if(!empty($_POST))
	{
		$usrname=$_POST["username"];
		$psw=$_POST["password"];
		$email=$_POST["email2"];
		$check="select email from accounts where email= '$email' limit 1";
		$qstatus=mysqli_query($connection, $check);
		if(mysqli_num_rows($qstatus)>0)
		{	header("Location: login1.php?err=1");	
		    exit();
		}
		$hash = md5( rand(0,1000) );
		$usrname= $usrname . substr($email,7,4);
		$sql= "INSERT INTO accounts (username, password, email, hash) VALUES ('$usrname', '$psw', '$email', '$hash' )";
		$qstat =mysqli_query($connection, $sql);
		if(!$qstat)
		{
						die(" nhi chali" . mysqli_error($connection));
		}
		else
		{
            
			$to      = $email; // Send email to our user
$subject = 'Signup | Verification'; // Give the email a subject 
$message = '
 
Thanks for signing up!
Your account has been created, you can login with the following credentials after you have activated your account by pressing the url below.
 
------------------------
Username: '.$usrname.'
Password: '.$psw.'
------------------------
 
Please click this link to activate your account:
https://mnitquora.000webhostapp.com/verify.php?email='.$email.'&hash='.$hash.'
 
'; // Our message above including the link
                     
$headers = 'From:pulkitgarg419@gmail.com' . "\r\n"; // Set from headers
$retval=mail($to, $subject, $message, $headers); // Send our email
//echo $retval ;
		}
	}
  header( "refresh:6; url=login1.php" ); 
?>

<html>
<head>
   <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="mystyle.css">
  <script type="text/javascript" src="functions.js"></script>
  <title>MnitQuora</title>
  </head>
  <body>
<header class="container-fluid text-center" style="background-color: #002147;color: #ffffff">
  <ul style="list-style: none;" >
    <li><h1>Mnit Quora</h1></li>
</li>
</ul>

</header>
<br>
<br>
<br>
<br>

<center><h3>Your Account has been created. To activate please go check your mail. Thanks. </h3></center>
<br>
<br>
<br>
<br>
<center>

<p id="demo" style="font-size: 30px; ">	
</p>
</center>

<script >

var p=5;
var myVar = setInterval(time, 1000 );
	
function time() {
document.getElementById("demo").innerHTML = "Redirecting in " + p-- + " seconds..";

}


</script>

<footer class="container-fluid text-center">
  <h4><font color="#ffffff    ">This Website is developed by <font style="font-weight: bold">Manish Bhagwani</font> and <font style="font-weight: bold">Pulkit Garg</font></font></h4>  
</footer>
</body>
</html>

