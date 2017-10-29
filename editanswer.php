<?php
	include 'database.php';
	if(!empty($_POST))
	{
		$yourans=$_POST["yourans"];
		$qid=$_POST["qid"];
		$userid=$_POST["userid"];
		$aid=$_POST["aid"];
		$sql= "update answers set acont= '$yourans' where aid= '$aid' ";
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