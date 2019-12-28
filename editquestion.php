<?php
	include 'database.php';
	if(!empty($_POST))
	{
		$question=$_POST["qcont"];
		$qid=$_POST["qid"];
		if($_POST["editcat"]=="Other")
    $category=$_POST["editothcat"];
    else
      $category=$_POST["editcat"];
    $sql= "update questions set qcont= '$question', category= '$category' where qid= '$qid' ";
		$qstat =mysqli_query($connection, $sql);
		if(!$qstat)
		{
						die(" nhi chali" . mysqli_error($connection));

		}
		else
		{
			header("Location: qview.php?qid=". $qid);
			exit();
		
	}
			
	
	}
?>