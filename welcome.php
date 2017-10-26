<?php
  /*include 'database.php';
  $msgs=array("", "Wrong Password", "Username doesn't exist");
   
    
  if(!empty($_POST))
  {
    $usrname=$_POST["email"];
    $psw=$_POST["password"];
    $sql="SELECT password FROM data WHERE data.name = '$usrname' ";
    $qstat = mysqli_query($connection, $sql);
    if(!$qstat)
    {
      die(" nhi chali" . mysqli_error($connection));
    }
    else
    {
      if(mysqli_num_rows($qstat)>0)
      {
        $pass=mysqli_fetch_assoc($qstat);
        if($pass['password']==$psw)
          {
            echo "Aaiye";
            exit();
          }
        else
          echo "wrong password";
      }
      else
        echo "ja ja user name to  pta nhi hai or aa jate hain khan khan se";
   
    }

  }*/
  session_start();
  if (!isset($_SESSION['username']) || empty($_SESSION['username'])) header("Location: login1.php");
  ?>

<html>
<head>
<style>
		a:link, a:visited {
    background-color: #f44336;
    color: white;
    padding: 14px 25px;
    text-align: center; 
    text-decoration: none;
    display: inline-block;
}

a:hover, a:active {
    background-color: red;
}

</style>
</head>

<body>
<header class="container-fluid text-center" style="background-color: #d9534f;">
  <h1 style="text-align: center;">Welcome <?php echo $_SESSION["username"]; ?></h1>
<!--   <p>Resize this responsive page to see the effect!</p> 
 --></header>

<center>
 <a href="http://localhost:8080/new/logout1.php">logout</a>
</center>


</body>
</html>