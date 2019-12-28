<?php
  include 'database.php';

  session_start();
  if (!isset($_SESSION['username']) || empty($_SESSION['username'])) 
    header("Location: login1.php");
   
  if(!empty($_POST))
  {
    $sconts=$_POST["scont"];
    $scont=str_replace("'", "''", "$sconts");
    
    $userid=$_POST["userid"];
    $sql= "INSERT INTO surveys (scont, userid) VALUES (' $scont ', '$userid' )";
    $qstat =mysqli_query($connection, $sql);
    if(!$qstat)
    {
            die(" nhi chali" . mysqli_error($connection));

    }
    
    $sid = mysqli_insert_id($connection);

    $opt1 = $_POST["option1"];
    $opt1query = "INSERT INTO options (optcont,sid) VALUES (' $opt1 ', ' $sid ')";
    $qstat = mysqli_query($connection,$opt1query);
    if(!$qstat)
    {
        die(" nhi chali" . mysqli_error($connection));
    }

    $opt2 = $_POST["option2"];
    $opt2query = "INSERT INTO options (optcont,sid) VALUES (' $opt2 ', ' $sid ')";
    $qstat = mysqli_query($connection,$opt2query);
    if(!$qstat)
    {
        die(" nhi chali" . mysqli_error($connection));
    }

    $noofopt = $_POST["noofopt"];
    if($noofopt == "3" || $noofopt == "4")
    {
      $opt3 = $_POST["option3"];
      $opt3query = "INSERT INTO options (optcont,sid) VALUES (' $opt3 ', ' $sid ')";
      $qstat = mysqli_query($connection,$opt3query);
      if(!$qstat)
      {
        die(" nhi chali" . mysqli_error($connection));
      }      
    }
    
    if($noofopt == "4")
    {
      $opt4 = $_POST["option4"];
      $opt4query = "INSERT INTO options (optcont,sid) VALUES (' $opt4 ', ' $sid ')";
      $qstat = mysqli_query($connection,$opt4query);
      if(!$qstat)
      {
        die(" nhi chali" . mysqli_error($connection));
      }      
    }    
        
    header("Location: surveys.php");   
    exit();
  }

?>