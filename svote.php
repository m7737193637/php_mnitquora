<?php
  include 'database.php';

  session_start();
  if (!isset($_SESSION['username']) || empty($_SESSION['username'])) 
    header("Location: login1.php");
     
  if(!empty($_GET))
  {
    $sid=$_GET["sid"];
    $optid=$_GET["optid"];
  }

  $userid=$_SESSION["userid"];

  $check = "SELECT sid from options where optid = '$optid'";
  $checkstat = mysqli_query($connection, $check);
  if(!$checkstat)
  {
    die(" nhi chali" . mysqli_error($connection));
  }
  if(mysqli_num_rows($checkstat)>0)
  {
    $actsid=mysqli_fetch_assoc($checkstat)["sid"];
    if($actsid!=$sid)
       {
        header("Location: surveys.php");
      exit();
       }
  }

$myvotesql = "SELECT vote from svotes where sid = '$sid' and userid = '$userid'";
  $checkstat = mysqli_query($connection, $myvotesql);
  if(!$checkstat)
  {
    die(" nhi chali" . mysqli_error($connection));
  }
  if(mysqli_num_rows($checkstat)>0)
    $myvote=mysqli_fetch_assoc($checkstat)["vote"];
  else
    $myvote=0;



 // $sql2="";
    if($myvote==0)
      {$sql= "INSERT INTO svotes (sid, userid, vote) VALUES (' $sid ', '$userid' , '$optid' )";
   //     $sql2="UPDATE surveys set votes = votes +1 where sid= '$sid'";
      }
    else if($myvote!=$optid)
      $sql= "UPDATE svotes set vote = '$optid' where sid = ' $sid ' and userid = ' $userid ' ";
    else 
      {$sql = "DELETE from svotes where sid = ' $sid ' and userid = ' $userid ' ";
     // $sql2="UPDATE surveys set votes = votes -1 where sid= '$sid'";
  }

   /* if($sql2!=""){
    $qstat2=mysqli_query($connection, $sql2);
    if(!$qstat2)
    {
            die(" nhi chali" . mysqli_error($connection));

    }}
*/
    $qstat =mysqli_query($connection, $sql);
    if(!$qstat)
    {
            die(" nhi chali" . mysqli_error($connection));

    }
    else
    {
      header("Location: surveys.php");
      exit();
    }


?>