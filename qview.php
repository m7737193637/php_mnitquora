<?php
	include 'database.php';
	 session_start();
  if (!isset($_SESSION['username']) || empty($_SESSION['username'])) 
    header("Location: login1.php");
 $user=$_SESSION["userid"];

 if(!empty($_GET["qid"]))
 {
 	$qid=$_GET["qid"];
 	if(isset($_GET["aidindex"]))
 	$aidindex=$_GET["aidindex"];

 	$sql="select q.qid, a.username, q.qcont, q.category, q.userid from questions as q inner join accounts as a on q.userid=a.userid where qid= '$qid' ";
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
            $id=$ans["aid"];
 $vote= "SELECT votetype, voteid from votes where userid='$user' and aid= '$id' limit 1";
 $qstatus=mysqli_query($connection, $vote);
 if(!$qstatus)
              die(" nhi chali" . mysqli_error($connection));

 if($qstatus && mysqli_num_rows($qstatus)>0)
 {
  $qres=mysqli_fetch_assoc($qstatus);
    $ans["vstat"]=$qres["votetype"];
    $ans["voteid"]=$qres["voteid"];
 }
 else
  $ans["vstat"]=0;

            $anss[$i]=$ans;
            
            $i++;
            
          }
      }
 }
$category=[];
$j=0;
$sql3="SELECT distinct  category from questions";
$qstat3=mysqli_query($connection, $sql3);

if($qstat3 && mysqli_num_rows($qstat3)>0)
{
  while($row1=mysqli_fetch_assoc($qstat3))
  {
    $category[$j]=$row1;
    $j++;
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
    <script type="text/javascript" src="functions.js"></script>
    <title>MnitQuora</title>
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
              
              <textarea rows="15" class="form-control" id="yourans"  name="yourans" required><?php echo $anss[$aidindex]["acont"] ;?></textarea>
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


<div class="modal fade" id="quesmodal" role="dialog">
    <div class="modal-dialog">
    
      <div class="modal-content">
        <div class="modal-header" >
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4><span class="glyphicon glyphicon-pencil"></span> Ask a question</h4>
        </div>
        <div class="modal-body" style="padding:40px 50px;">
      
      <div class= "form-group" >
      <form role="form" action="question.php" method="post">
         <div class="form-group">
              <label for="qcont"><span class="glyphicon glyphicon-pencil"></span> Ask a Question</label>
              <textarea rows=10 class="form-control" id="qcont" placeholder="Enter your question" name="qcont" required></textarea>
            </div>
             <div class="form-group">
              <label for="askcat"><span class="glyphicon glyphicon-eye-open"></span> Category</label>
              <select class="form-control" name="askcat" id="askcat" required onChange="catchange();">
                <option value="" selected disabled hidden>Select Category</option>
                <?php 
                  foreach ($category as $catform) {
                    ?>
                    <option value=<?php echo $catform["category"] ?>><?php echo $catform["category"] ?> </option>
                  <?php }
                ?>
                <option value="Other">None of These</option>
              </select><br>
              <input type="text" class="form-control" name="othcat" id="othcat" style="display: none;">
            </div>
             <div class="form-group">
              <label for="ask"><span class="glyphicon glyphicon-eye-open"></span>Ask</label>
              <input type="submit" class="form-control" type="button" id="ask" name="ask" >
            </div>

            <div class="form-group">
              <input type="hidden" class="form-control"  name="userid" value=<?php echo $_SESSION["userid"] ?> >
            </div>
            

</form>
</div>
  
    </div>
  </div>
</div>
</div> 
 



<div class="modal fade" id="editquesmodal" role="dialog">
    <div class="modal-dialog">
    
      <div class="modal-content">
        <div class="modal-header" >
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4><span class="glyphicon glyphicon-pencil"></span> Edit question</h4>
        </div>
        <div class="modal-body" style="padding:40px 50px;">
      
      
  <div class= "form-group" >
      <form role="form" action="editquestion.php" method="post">
         <div class="form-group">
              <label for="qcont"><span class="glyphicon glyphicon-pencil"></span> Question</label>
              <textarea rows=10 class="form-control" id="qcont" name="qcont" required><?php echo $que["qcont"] ;?> </textarea>
            </div>
             <div class="form-group">
              <label for="editcat"><span class="glyphicon glyphicon-eye-open"></span> Category</label>
              <select class="form-control" name="editcat" id="editcat" required onChange="editcatchange();">
                <?php 
                  foreach ($category as $catform) {
                    ?>
                    <option value=<?php echo $catform["category"] ?> <?php if($catform["category"]==$que["category"]) echo "selected" ?> ><?php echo $catform["category"] ?> </option>
                  <?php }
                ?>
                <option value="Other">None of These</option>
              </select><br>
              <input type="text" class="form-control" name="editothcat" id="editothcat" style="display: none;">
            
            </div>
             <div class="form-group">
              <label for="ask"><span class="glyphicon glyphicon-eye-open"></span>Edit</label>
              <input type="submit" class="form-control" type="button" id="ask" name="ask" >
            </div>

        	 <div class="form-group">
              <input type="hidden" class="form-control"  name="qid" value=<?php echo $qid?> >
            </div>
                       

</form>
</div>
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
        	<?php if($_SESSION['userid']==$que["userid"]) { ?> 
        	       <h4><a href="javascript:editquestion()" ?>Edit</a></h4>
        	       <?php } ?>
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

          <?php if($ans["vstat"]==0) {?> 
          <button class="btn btn-primary " onclick="vote(<?php echo $ans["aid"] ?>, 1, <?php echo $qid ?>);"><span class="glyphicon glyphicon-thumbs-up"></span>Upvote</button>
            <button class="btn btn-primary " onclick="vote(<?php echo $ans["aid"] ?>, 2, <?php echo $qid ?>);"><span class="glyphicon glyphicon-thumbs-down"></span>Downvote</button>
          <?php } else { ?>
            <button class="btn btn-primary " onclick="cvote(<?php echo $ans["voteid"] ?>, <?php echo $ans["vstat"] ?>,<?php echo $ans["aid"] ?>, <?php echo $qid ?>  )"> <?php if($ans["vstat"]==1) { ?> Upvoted <?php  } else { ?> Downvoted <?php } } ?></button>
        </div>
        
  </div>
	</div>
   </div>
<?php } ?>

</div>


<footer class="container-fluid text-center">
  <h4><font color="#ffffff    ">This Website is developed by <font style="font-weight: bold">Manish Bhagwani</font> and <font style="font-weight: bold">Pulkit Garg</font></font></h4>  
</footer>
<script >  function question()
  {
    $("#quesmodal").modal();
  }
  function editquestion()
  {
    $("#editquesmodal").modal();
  }
  $(window).scroll(function() {
  sessionStorage.scrollTop = $(this).scrollTop();
});

$(document).ready(function() {
  if (sessionStorage.scrollTop != "undefined") {
    $(window).scrollTop(sessionStorage.scrollTop);
  }
});
</script>
</body>
</html>