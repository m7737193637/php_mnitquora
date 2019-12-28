<?php
  include 'database.php';
   session_start();
  if (!isset($_SESSION['username']) || empty($_SESSION['username'])) 
    header("Location: login1.php");
 $user=$_SESSION["userid"];
 $makeactive="surveys";

 $surveys=[];

 $surveysql = "SELECT s.sid, s.scont, s.votes, a.username from surveys as s inner join accounts as a on s.userid=a.userid order by s.votes desc";
 $qstat=mysqli_query($connection, $surveysql);
 $i=0;
 if($qstat && mysqli_num_rows($qstat)>0)
 {
    while($survey=mysqli_fetch_assoc($qstat))
    {
        $id = $survey["sid"];
        $votesql="SELECT vote from svotes where userid='$user' and sid = '$id' limit 1";
        $qstat2 = mysqli_query($connection, $votesql);
        if(!$qstat2)
           die(" nhi chali" . mysqli_error($connection));
        if($qstat2 && mysqli_num_rows($qstat2)>0)
        {
          $qres = mysqli_fetch_assoc($qstat2);
          $survey["myvote"]=$qres["vote"];
        }
        else
          $survey["myvote"]=0;

        $options=[];
        $j=0;
        $optionsql = "SELECT optid, optcont, votes from options where sid = '$id' ";
        $qstat3 = mysqli_query($connection, $optionsql);
        if(!$qstat3)
           die(" nhi chali" . mysqli_error($connection));
        if($qstat3 && mysqli_num_rows($qstat3)>0)
        {
          while($option = mysqli_fetch_assoc($qstat3))
          {
            $options[$j]=$option;
            $j++;
          }
          $survey["options"]=$options;
        }
        $surveys[$i]=$survey;
        $i++;
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
        <li class="<?php if($makeactive=="asksurvey") echo "active" ?>"><a href="javascript:survey();">Start Survey</a></li>
        <li class="<?php if($makeactive=="surveys") echo "active" ?>"><a href="surveys.php">Surveys</a></li>

 <!--        <li><a href="https://www.google.com"><span class="glyphicon glyphicon-earphone"></span>Contact Us</a></li>
 -->      
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="#"> <?php echo $_SESSION["username"]; ?></a></li>
        <li><a href="logout1.php">Logout</a></li>
      </ul>
    </div>
  </div>
</nav>




<div class="modal fade" id="surveymodal" role="dialog">
    <div class="modal-dialog">
    
      <div class="modal-content">
        <div class="modal-header" >
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4><span class="glyphicon glyphicon-pencil"></span> Start a Survey</h4>
        </div>
        <div class="modal-body" style="padding:40px 50px;">
      
      
  <div class= "form-group" >
      <form role="form" action="survey.php" method="post">
         <div class="form-group">
              <label for="scont"><span class="glyphicon glyphicon-pencil"></span> Enter your question </label>
              <textarea rows=10 class="form-control" id="scont" placeholder="Enter your question" name="scont" required></textarea>
            </div>


            <div class="form-group">
              <label for="noofopt"><span class="glyphicon glyphicon-eye-open"></span> Number of Options</label>
              <select class="form-control" name="noofopt" id="noofopt" required onChange="noofoptchange();">
                <option value="" selected disabled hidden>How many options?</option>
                    <option value="2">2</option>   
                    <option value="3">3</option>   
                    <option value="4">4</option>   
              </select><br>
              <div id="option1div" style="display: none;">
              <label for="option1">Option A</label>
              <input type="text" class="form-control" name="option1" id="option1" required>
              <br></div>
              <div id="option2div" style="display: none;">
              <label for="option2">Option B</label>
              <input type="text" class="form-control" name="option2" id="option2" required>
              <br></div>
              <div id="option3div" style="display: none;">
              <label for="option3">Option C</label>
              <input type="text" class="form-control" name="option3" id="option3" required="true">
              <br></div>
              <div id="option4div" style="display: none;">
              <label for="option4">Option D</label>
              <input type="text" class="form-control" name="option4" id="option4" required="true">
              <br></div>
              <!-- <input type="text" class="form-control" name="option2" id="option2" style="display: none;">
              <input type="text" class="form-control" name="option3" id="option3" style="display: none;">
              <input type="text" class="form-control" name="option4" id="option4" style="display: none;"> -->
            </div>


             <div class="form-group">
              <input type="submit" class="form-control" type="button" id="asksurvey" name="asksurvey" >
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


<div class="container-fluid "  >    
  <?php for($siter=0;$siter<$i;++$siter) {$survey=$surveys[$siter];?>
    <div class="row">
    <div class="col-sm-10 col-md-offset-1" >
    <div class="panel panel-primary">
         <div class="panel-heading" ><?php echo $survey["scont"]  ?></div>
      
         <div class="panel-body">
            <h4><font color="#084386" >Started By: </font> <?php echo $survey["username"] ?></h4>
            <h4><font color="#084386" >Votes: </font> <?php echo $survey["votes"] ?></h4>
          <?php 
           $options = $survey["options"]; 
           foreach ($options as $option) {
            $per = $survey["votes"]!=0?$option["votes"]*100/$survey["votes"]:0;
            $per = round($per,1);
          ?>
          <a onclick="svote(<?php echo $survey["sid"] ?>, <?php echo $option["optid"] ?>)"><font size="4"><?php echo $option["optcont"];?></font></a>

          <font size="3" color="#084386"><?php if($survey["myvote"]==$option["optid"]) echo " Voted by you"; ?></font>
          
          <div style="display: <?php if($per==0) echo "none"; else echo "block"; ?> ">
          <div class="progress" style="width: 20%" >
          <div class="progress-bar progress-bar-striped active" role="progressbar"
          aria-valuenow=<?php echo $per ?> aria-valuemin="0" aria-valuemax="100" style="width:<?php echo $per ?>%">
          <?php echo $per ?>%
          </div>
          </div>
          </div>

          <!-- <font size="4"><?php echo $option["votes"];?></font> -->
          <?php if($per==0) echo "<br>";   } ?>

         </div>
        
  </div>
  </div>
   </div>
<?php } ?>
</div>




<footer class="container-fluid text-center">
  <h4><font color="#ffffff    ">This Website is being developed by <font style="font-weight: bold">Pulkit Garg</font></font></h4>  
</footer>

<script >  function question()
  {
    $("#quesmodal").modal();
  }
  $(window).scroll(function() {
  sessionStorage.scrollTop = $(this).scrollTop();
});

$(document).ready(function() {
  if (sessionStorage.scrollTop != "undefined") {
    $(window).scrollTop(sessionStorage.scrollTop);
  }
});

  function survey()
  {
    $("#surveymodal").modal();
  }
</script>





</body>
</html>

