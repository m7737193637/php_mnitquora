<?php
  include 'database.php';

  session_start();
  if (!isset($_SESSION['username']) || empty($_SESSION['username'])) 
    header("Location: login1.php");
    
  if(!empty($_GET))
  {
    $qid=$_GET["qid"];
  }

  if(!empty($_POST))
  {
    $qconts=$_POST["qcont"];
    $qcont=str_replace("'", "''", "$qconts");
    if($_POST["askcat"]=="Other")
    $category=$_POST["othcat"];
    else
      $category=$_POST["askcat"];
    $userid=$_POST["userid"];
    $sql= "INSERT INTO questions (qcont, category, userid) VALUES (' $qcont ', '$category' , '$userid' )";
    $qstat =mysqli_query($connection, $sql);
    if(!$qstat)
    {
            die(" nhi chali" . mysqli_error($connection));

    }
    else
    {
      header("Location: main.php");
      exit();
    }

  }

?>