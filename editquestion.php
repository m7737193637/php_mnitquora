<?php
	include 'database.php';
	if(!empty($_POST))
	{
		$question=$_POST["qcont"];
		$qid=$_POST["qid"];
	    $category=$_POST["category"];
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