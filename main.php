<?php
  include 'database.php';

  session_start();
  if (!isset($_SESSION['username']) || empty($_SESSION['username'])) 
    header("Location: login1.php");
     
  if(!empty($_GET))
  {
    $qid=$_GET["qid"];
  }
    $data=[];
    $i=0;
    $cat="All Questions";
  

  if(!empty($_POST) && isset($_POST["category"]) )
  {
    $cat=$_POST["category"];
    $sql= "select qid, qcont, category from questions where questions.category = '$cat' ";   
  }
 else
   { $sql= "select qid, qcont, category from questions ";
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
  <style>
    /* Remove the navbar's default rounded borders and increase the bottom margin */ 
    .navbar {
      margin-bottom: 50px;
      border-radius: 0;
    }
    
    /* Remove the jumbotron's default bottom margin */ 
     .jumbotron {
      margin-bottom: 0;
  
      
    }
   ul li{
    display: inline;
   }
    /* Add a gray background color and some padding to the footer */
    footer {
      background-color: #002147;
      padding: 25px;
    }

 .navbar {
      background-color: #002147;
      z-index: 9999;
      border: 0;
      font-size: 12px !important;
      line-height: 1.42857143 !important;
      letter-spacing: 4px;
      border-radius: 0;
      font-family: Montserrat, sans-serif;
  }
  .navbar li a, .navbar .navbar-brand {
      color: #fff !important;
  }
  .navbar-nav li a:hover, .navbar-nav li.active a {
      color: #002147 !important;
      background-color: #fff !important;
  }
  .navbar-default .navbar-toggle {
      border-color: transparent;
      color: #fff !important;
  }

  .modal-header,  .close {
      background-color: #084386;
      color:white !important;
      text-align: center;
      font-size: 30px; 

  }
  .modal-footer {
      background-color: #f9f9f9;
  }
  .modal-dialog
  {

        margin-top: 10%;
  }

</style>
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
        <li class="active"><a href="#"><span class="glyphicon glyphicon-home"></span>Home</a></li>
        <li><a href="javascript:answer();"><span class="glyphicon glyphicon-pencil"></span>Answer</a></li>
        <li><a href="javascript:question();">Ask Question</a></li>
        <li><a href="https://www.google.com"><span class="glyphicon glyphicon-earphone"></span>Contact Us</a></li>
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
            <h3>categories</h3>
            <form action="<?php echo($_SERVER['PHP_SELF']); ?>" method="post">    
            <?php foreach ($category as $row1) {?>
            <input type="radio" name="category" value= <?php echo $row1["category"] ?> <?php if($cat==$row1["category"]) echo "checked"; ?> > <?php echo $row1["category"] ?>
            <br>
            <?php }?>
            <input  type="submit"  >
            </form>
  
        </div>
        
  </div>
    </div>

 
    <div class="col-sm-9"> 
      <div class="panel panel-primary">
        <div class="panel-heading" ><?php echo $cat; ?></div>
        <div class="panel-body">
        <?php foreach ($data as $row) 
        {?>
          <div>
      <?php echo $row["qcont"]  ?><br>
      <?php echo $row["category"]  ?><br>
      <a href="<?php echo "main.php?qid=" . $row["qid"]; ?>"><button class=" btn btn-primary" id="answer ">Answer</button></a>
     </div>
     <?php }?>


        </div>
      </div>
    </div>
   </div>
</div>


<div class="modal fade" id="ansmodal" role="dialog">
    <div class="modal-dialog">
    
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
              <label for="qcont"><span class="glyphicon glyphicon-pencil"></span> Ask a Question</label>
              <textarea class="form-control" id="qcont" placeholder="Enter your question" name="qcont" required></textarea>
            </div>
             <div class="form-group">
              <label for="category"><span class="glyphicon glyphicon-eye-open"></span> Category</label>
              <input type="text" class="form-control" id="category" placeholder="Enter category" name="category" required>
            </div>
             <div class="form-group">
              <label for="ask"><span class="glyphicon glyphicon-eye-open"></span>Ask</label>
              <input type="submit" class="form-control" type="button" id="ask" name="ask" >
            </div>

            <div class="form-group">
              <input type="text" class="form-control"  name="userid" value=<?php echo $_SESSION["userid"] ?> >
            </div>
            

</form>
</div>
    </div>
  </div>
</div>
</div> 
 




<footer class="container-fluid text-center">
  <h4><font color="#ffffff    ">This Website is made by <font style="font-weight: bold">Manish Bhagwani</font> and <font style="font-weight: bold">Pulkit Garg</font></font></h4>  
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
</script>
</body>

</html>