<?php
  include 'database.php';

  session_start();
  if (!isset($_SESSION['username']) || empty($_SESSION['username'])) 
    header("Location: login1.php");
   

    $data=[];
    $makeactive="home";
    $i=0;
    $catdisp="All Questions";
    $cat="All";
    $unans=false; 

  if(!empty($_GET))
  {
    if(isset($_GET["unans"]))
    $unans=$_GET["unans"];
    if(isset($_GET["qid"]))
   {
    $qid=$_GET["qid"];
    }
  }

  if(!empty($_POST) && isset($_POST["category"]) )
  {
    $cat=$_POST["category"];
    
    if($unans==false)
    {
      $makeactive="home";  
      $catdisp=$cat;
      if($cat!="All")
    $sql= "SELECT qid, qcont, category, noans from questions where questions.category = '$cat' order by noans desc" ;   
    else
    {
      $catdisp="All Questions";
    $sql= "select qid, qcont, category, noans from questions order by noans desc" ;   
    }
    }
    else
    {
      $makeactive="answer";
      $catdisp="Unanswered in " . $_POST["category"] ;
      if($cat!="All")
      $sql= "select qid, qcont, category, noans from questions where questions.category = '$cat' AND noans=0";   
      else
        {$catdisp="All Unanswered";
      $sql= "select qid, qcont, category, noans from questions where noans=0";           
    }
    }
  }
  else if($unans==true)
  {
    $makeactive="answer";
        $catdisp="All Unanswered";    
        $sql= "select qid, qcont, category, noans from questions where  noans=0";       
  }
 else
   {
   $makeactive="home";   
    $catdisp="All Questions";
    $sql= "select qid, qcont, category, noans from questions order  by noans desc";
   }

    $qstat =mysqli_query($connection, $sql);
    if(!$qstat)
    {
            die(" nhi chali" . mysqli_error($connection));

    }
    else
    {

      if($qstat && mysqli_num_rows($qstat)>0)
      {
          while($row=mysqli_fetch_assoc($qstat))
          {
            $data[$i]=$row;
            $i++;
          }
      } }

/*
  $data=[];
  $i=0;
  $sql2="SELECT qid, qcont, category from questions where questions.noans = 0 ";
$qstat2 =mysqli_query($connection, $sql2);
   
    
      if($qstat2 && mysqli_num_rows($qstat2)>0)
      {
          while($row=mysqli_fetch_assoc($qstat2))
          {
            $data[$i]=$row;
            $i++;
          }
      }
    */






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


  

<div style="margin-left: 1%;margin-right: 2%;">    
  <div class="row">
    <div class="col-sm-3" >
      <div class="panel panel-primary">
        
        <div class="panel-heading " >Categories</div>
        <div class="panel-body">
            <form action="<?php echo "main.php?unans=" . $unans ;?>" method="post" id="catradio">    
            <input type="radio" name="category"  id="All" value= "All" onChange="autoSubmit();" <?php if($cat=="All") echo "checked"; ?>> <label for ="All">All</label> 
            <br>
           
            <?php foreach ($category as $row1) {?>
            <input type="radio" name="category"  id=<?php echo $row1["category"] ?> value= <?php echo $row1["category"] ?> onChange="autoSubmit();" <?php if($cat==$row1["category"]) echo "checked"; ?>> <label for =<?php echo $row1["category"] ?>><?php echo $row1["category"] ?></label> 
            <br>
            <?php }?>
            </form>
  
        </div>
        
  </div>
    </div>

 
    <div class="col-sm-9"> 
        <h3  style="color: blue;"><?php echo $catdisp; ?></h3> 
      
      <?php foreach ($data as $row) 
        {?>
      <div class="panel panel-primary">
        <div class="panel-heading" ><a href="<?php echo "qview.php?qid=" . $row["qid"]; ?>" style="color:black;" ><?php echo $row["qcont"]  ?></a></div>
        <div class="panel-body">
        
          <div>
<!--      <h4><a href="<?php echo "qview.php?qid=" . $row["qid"]; ?>" ><?php echo $row["qcont"]  ?></a></h4>
 -->  <h4><font color="#084386" >Category:</font> <?php echo $row["category"] ?></h4>
  <h4><font color="#084386" >Answers:</font> <?php echo $row["noans"] ?></h4>
  
  
      <a href="<?php echo "main.php?qid=" . $row["qid"]; ?>"><button class=" btn btn-primary" id="answer ">Answer</button></a> 
  
     </div>


        </div>
      </div>

     <?php }?>
    </div>
   </div>
</div>


<div class="modal fade" id="ansmodal" role="dialog">
    <div class="modal-dialog">
    <?php          
    if(isset($_GET["qid"]))
    {?>
     <script >
              $("#ansmodal").modal();       
     </script>
    <?php } ?>
     

      <div class="modal-content">
        <div class="modal-header" >
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4><span class="glyphicon glyphicon-pencil"></span> Answer</h4>
        </div>
        <div class="modal-body" style="padding:40px 50px;">
          <form role="form" action="answer.php" method="post">
            <div class="form-group">
              
              <textarea rows="15" class="form-control" id="yourans" placeholder=" Write your answer here" name="yourans" required></textarea>
          </div>
              <input type="hidden" name="qid" value=  "<?php echo $qid ?>" >
              <input type="submit" class="form-control" type="button" id="answer" name="answer" >
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
              <label for="qcont"><span class="glyphicon glyphicon-pencil"></span> Enter your question</label>
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
              <input type="text" class="form-control" name="othcat" id="othcat" style="display: none;" required="false">
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
 


<footer class="container-fluid text-center">
  <h4><font color="#ffffff    ">This Website is being developed by <font style="font-weight: bold">Pulkit Garg</font></font></h4>  
</footer>


<script>
  function answer()
  {
    $("#ansmodal").modal();
  }
  function question()
  {
    $("#quesmodal").modal();
  }

  function survey()
  {
    $("#surveymodal").modal();
  }
</script>
</body>

</html>