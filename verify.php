<?php
  include 'database.php';
    if(!empty($_GET))
  {
    if(isset($_GET["email"]))
      $email=$_GET["email"];
    if(isset($_GET["hash"]))
      $hash=$_GET["hash"];
  }
  $activa= "SELECT username, userid, email, hash from accounts where email='$email' limit 1";
  $qstatus=mysqli_query($connection, $activa);
 if(!$qstatus)
      die(" nhi chali" . mysqli_error($connection));
else
 if(mysqli_num_rows($qstatus)>0)
 { 
  $data=mysqli_fetch_assoc($qstatus);
  if($data["hash"]==$hash)
  {
    $success="update accounts set active = 1 where email= '$email' "; 
    $qstatus=mysqli_query($connection, $success);
     session_start();
            $_SESSION['username'] = $data["username"];
            $_SESSION['userid']=$data['userid'];
           
    header("Location: main.php");
    exit();
  }
  else
  {
    $msg="Invalid hash . Please use the link given in the verification mail only. ";
  }

 }
 else
 {
    $msg="Sorry. Account has not been created from this Email.";
 }

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

<h3><?php echo $msg ?></h3>
<br>
<br>
<br>
<br>

<footer class="container-fluid text-center">
  <h4><font color="#ffffff    ">This Website is developed by <font style="font-weight: bold">Manish Bhagwani</font> and <font style="font-weight: bold">Pulkit Garg</font></font></h4>  
</footer>
</body>
</html>

