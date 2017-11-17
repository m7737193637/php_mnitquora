<?php
  include 'database.php';

  session_start();
  if (!isset($_SESSION['username']) || empty($_SESSION['username'])) 
    header("Location: login1.php");
     
  if(!empty($_GET))
  {
    $aid=$_GET["aid"];
    $type=$_GET["type"];
    $qid=$_GET["qid"];
    $vid=$_GET["vid"];
  }

  $userid=$_SESSION["userid"];
      $sql= "DELETE FROM  votes where voteid= '$vid'";
      if($type==1)
      	$vtype="up";
      else
      	$vtype="down";
      $sql2="update answers set " . $vtype . " = " . $vtype . " -1 where aid= '$aid'";
      $qstat2=mysqli_query($connection, $sql2);
    $qstat =mysqli_query($connection, $sql);
    if(!$qstat)
    {
            die(" nhi chali" . mysqli_error($connection));

    }
    else
    {
      header("Location: qview.php?qid=" . $qid);
      exit();
    }


?>