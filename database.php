<?php
 
 	$host = "localhost";
 	$username="root";
 	$password="";
 	$database="mnitquora";
 	$connection= mysqli_connect($host,$username, $password, $database);
 	if(mysqli_connect_error()){
 		echo "error" . myysqli_connect_error();
 	}
 	?>