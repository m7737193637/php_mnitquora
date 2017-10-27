<?php
  include 'database.php';

  session_start();
  if (!isset($_SESSION['username']) || empty($_SESSION['username'])) 
    header("Location: login1.php");
     
  if(!empty($_GET))
  {
    $qid=$_GET["qid"];
  }

  if(!empty($_POST))
  {
    $qcont=$_POST["qcont"];
    $category=$_POST["category"];
    $userid=$_POST["userid"];
    $sql= "INSERT INTO questions (qcont, category, userid) VALUES ('$qcont', '$category' , '$userid' )";
    $qstat =mysqli_query($connetion, $sql);
    if(!$qstat)
    {
            die(" nhi chali" . mysqli_error($connection));

    }
    else
    {
      header("Location: welcome.php");
      exit();
    }

  }


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
    


?>

<html>
<head>
   <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <style>
  .modal-header, h4, .close {
      background-color: #d73924;
      color:white !important;
      text-align: center;
      font-size: 30px;
  }
  .modal-footer {
      background-color: #f9f9f9;
  }

		a:link, a:visited {
    background-color: #f44336;
    color: white;
    padding: 14px 25px;
    text-align: center; 
    text-decoration: none;
    display: inline-block;
}

a:hover, a:active {
    background-color: red;
}

</style>
</head>

<body>

  <div class= "form-group" >
      <form role="form" action="<?php echo($_SERVER['PHP_SELF']); ?>" method="post">
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
              <input type="hidden" class="form-control"  name="userid" value=<?php echo $_SESSION["userid"] ?> >
            </div>
            

</form>
</div>

<div>
  <h3>Unanswered Questions</h3>
<ul>
    
     
     <?php foreach ($data as $row) {?>
      <li><?php echo $row["qcont"]  ?></li>
      <li><?php echo $row["category"]  ?></li>
      <li><a href="<?php echo "welcome.php?qid=" . $row["qid"]; ?>"><button class=" btn btn-danger" id="answer ">Answer</button></a></li>
     
     <?php }?>

</ul>

  
</div>
 -->
<center>
 <a href="http://localhost:8080/new/logout1.php">logout</a>
</center>


<!-- 
<div class="modal fade" id="ansmodal" role="dialog">
    <div class="modal-dialog">
    
      <div class="modal-content">
        <div class="modal-header" style="padding:35px 50px;">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4><span class="glyphicon glyphicon-pencil"></span> Answer</h4>
        </div>
        <div class="modal-body" style="padding:40px 50px;">
          <form role="form" action="answer.php" method="post">
     <?php          
    if(!empty($_GET))
    {?>
     <script >
              $("#ansmodal").modal();       
     </script>
    <?php } ?>
            <div class="form-group">
              
              <textarea class="form-control" id="yourans" placeholder=" Write your answer here" name="yourans" required></textarea>
          </div>
              <input type="hidden" name="qid" value=  "<?php echo $qid ?>" >
              <input type="submit" class="form-control" type="button" id="answer" name="answer" >
 <div class="form-group">
              <input type="hidden" class="form-control"  name="userid" value=<?php echo $_SESSION["userid"] ?> >
            </div>
           

          </form>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-danger btn-default pull-left" data-dismiss="modal"> Cancel</button>
     <!      <p>Not a member? <a href="#">Sign Up</a></p>
          <p>Forgot <a href="#">Password?</a></p>
      --><!--    </div>
      </div>
      
    </div>
  </div> 
  --> 
<script>
$(document).ready(function(){
    $("#answer").click(function(){
        $("#ansmodal").modal();
    });
});
</script>
</body>
</html>