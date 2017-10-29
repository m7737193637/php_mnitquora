<?php
	include 'database.php';
	 session_start();
  if (!isset($_SESSION['username']) || empty($_SESSION['username'])) 
    header("Location: login1.php");
 
 if(!empty($_GET["qid"]))
 {
 	$qid=$_GET["qid"];
 	if(isset($_GET["aidindex"]))
 	$aidindex=$_GET["aidindex"];
 	$sql="select q.qid, a.username, q.qcont, q.category from questions as q inner join accounts as a on q.userid=a.userid where qid= '$qid' ";
 	$qstat=mysqli_query($connection, $sql);

	if($qstat && mysqli_num_rows($qstat)>0)
	{
		$que=mysqli_fetch_assoc($qstat);
	}


	$sql2="select an.acont, an.up, an.down, ac.username, an.userid, an.aid from answers as an inner join accounts as ac on an.userid=ac.userid where an.qid='$qid'";
 	$qstat2=mysqli_query($connection, $sql2);
 	$anss=[];
 	$i=0;
 	      if($qstat2 && mysqli_num_rows($qstat2)>0)
      {
          while($ans=mysqli_fetch_assoc($qstat2))
          {
            $anss[$i]=$ans;
            $i++;
          }
      }
      


 }

?>

<html>
<head>
   <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="mystyle.css">
  </head>

<body>


<header class="container-fluid text-center" style="background-color: #002147;color: #ffffff">
  <ul style="list-style: none;" >
    <li><h1>Mnit Quora</h1></li>
</li>
</ul>

</header>



<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>                        
      </button>
      <a class="navbar-brand" href="#">Logo</a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">
        <li class="<?php if($makeactive=="home") echo "active" ?>"><a href="<?php echo "main.php"  ?>"><span class="glyphicon glyphicon-home"></span>Home</a></li>
        <li class="<?php if($makeactive=="answer") echo "active" ?>"><a href="<?php echo "main.php?unans=true"  ?>"><span class="glyphicon glyphicon-pencil"></span>Answer</a></li>
        <li class="<?php if($makeactive=="ask") echo "active" ?>"><a href="javascript:question();">Ask Question</a></li>
        <li><a href="https://www.google.com"><span class="glyphicon glyphicon-earphone"></span>Contact Us</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="#"> <?php echo $_SESSION["username"]; ?></a></li>
        <li><a href="logout1.php">Logout</a></li>
      </ul>
    </div>
  </div>
</nav>




<div class="modal fade" id="ansmodal" role="dialog">
    <div class="modal-dialog">
    <?php          
    if(isset($_GET["aidindex"]))
    {?>
     <script >
              $("#ansmodal").modal();       
     </script>
    <?php } ?>
     

      <div class="modal-content">
        <div class="modal-header" >
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4><span class="glyphicon glyphicon-pencil"></span>Edit Answer</h4>
        </div>
        <div class="modal-body" style="padding:40px 50px;">
          <form role="form" action="editanswer.php" method="post">
            <div class="form-group">
              
              <textarea rows="15" class="form-control" id="yourans"  name="yourans" ><?php echo $anss[$aidindex]["acont"] ;?></textarea>
          </div>
              <input type="hidden" name="qid" value=  "<?php echo $qid ?>" >
              <input type="submit" class="form-control" type="button" id="answer" name="answer" >
 <div class="form-group">
 			<input type="hidden" name="aid" value=  "<?php echo $anss[$aidindex]["aid"] ?>" >
              <input type="hidden" class="form-control"  name="userid" value=<?php echo $_SESSION["userid"] ?> >
            </div>
           

          </form>
        </div>
          </div>
      </div>
      
    </div>



<div class="container-fluid "  >    
  <div class="row">
    <div class="col-sm-10 col-md-offset-1" >
		<div class="panel panel-primary">
			<div class="panel-heading" style="background-color: #337ab7;">     	<h3><?php echo $que["qcont"] ?></h3><br></div>
         <div class="panel-body">
        	<h4><font color="#084386" >Category:</font><?php echo $que["category"] ?></h4>
        	<h4><font color="#084386" >Asked By:</font> <?php echo $que["username"] ?></h4>
        	
        </div>
        
  </div>
	</div>
   </div>

   <?php for($j=0;$j<$i;++$j) { $ans=$anss[$j];?>
     <div class="row">
    <div class="col-sm-10 col-md-offset-1" >
		<div class="panel panel-primary">
         <div class="panel-body">
         	<h4><font color="#084386" >Answer: </font> <?php echo $ans["acont"] ?></h4>
        	
        	<h4><font color="#084386" >Answered By:</font> <?php echo $ans["username"] ?></h4>
        	<h4><font color="#084386" >Upvotes: </font> <?php echo $ans["up"] ?></h4>
        	<h4><font color="#084386" >Downvotes: </font> <?php echo $ans["down"] ?></h4>
        	<?php if($_SESSION['userid']==$ans["userid"]) { ?> 
        	       <h4><a href="<?php echo "qview.php?qid=" . $qid .  "&aidindex=" . $j ?>" >Edit</a></h4>
        	       <?php } ?>

        </div>
        
  </div>
	</div>
   </div>
<?php } ?>

</div>


<footer class="container-fluid text-center">
  <h4><font color="#ffffff    ">This Website is made by <font style="font-weight: bold">Manish Bhagwani</font> and <font style="font-weight: bold">Pulkit Garg</font></font></h4>  
</footer>

</body>
</html>