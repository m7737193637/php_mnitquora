<?php
  include 'database.php';
  $msgs=array("", "Wrong Password", "Username doesn't exist");
    $err=0;
    
  if(!empty($_POST))
  {
    $usrname=$_POST["email"];
    $psw=$_POST["password"];
    $sql="SELECT userid, password FROM accounts WHERE accounts.username = '$usrname' ";
    $qstat = mysqli_query($connection, $sql);
    if(!$qstat)
    {
      die(" nhi chali" . mysqli_error($connection));
    }
    else
    {
      if(mysqli_num_rows($qstat)>0)
      {
        $pass=mysqli_fetch_assoc($qstat);
        if($pass['password']==$psw)
          {
            session_start();
            $_SESSION['username'] = $usrname;
            $_SESSION['userid']=$pass['userid'];
            header("location: main.php");
            exit();
          }
        else
          $err=1;
      }
      else
        $err=2 ;
   /*
echo "<script>$('#myModal').modal('show')</script>";*/
    }

  }
  ?>

  <!DOCTYPE html>
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
  </style>
</head>
<body>

<header class="container-fluid text-center" style="background-color: #d9534f;">
  <h1><font color="white">Model Log-In page</font></h1>
<!--   <p>Resize this responsive page to see the effect!</p> 
 --></header>
 <center><div style="margin-top: 4%">
  <button type="button" class="btn btn-warning btn-lg" id="myBtn">Login</button>
  <button type="button" class="btn btn-warning btn-lg" id="myBtn2">SignUp</button>
</div>
</center>
  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header" style="padding:35px 50px;">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4><span class="glyphicon glyphicon-lock"></span> Login</h4>
        </div>
        <div class="modal-body" style="padding:40px 50px;">
          <form role="form" action="<?php echo($_SERVER['PHP_SELF']); ?>" method="post">
            <?php if (isset($msgs[$err]) && !empty($msgs[$err])) { ?>
              <script>
                $("#myModal").modal();
              </script>
            <div class="alert alert-warning">
            <?php echo $msgs[$err] ?>
            </div>
            <?php } ?>
            
            <div class="form-group">
              <label for="usrname"><span class="glyphicon glyphicon-user"></span> Username</label>
              <input type="text" class="form-control" id="usrname" placeholder="Enter email" name="email" required>
            </div>
            <div class="form-group">
              <label for="psw"><span class="glyphicon glyphicon-eye-open"></span> Password</label>
              <input type="password" class="form-control" id="psw" placeholder="Enter password" name="password" required>
            </div>
            <div class="checkbox">
              <label><input type="checkbox" value="" checked>Remember me</label>
            </div>
              <button type="submit" class="btn btn-danger btn-block"><span class="glyphicon glyphicon-off"></span> Login</button>
          </form>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-danger btn-default pull-left" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancel</button>
          <p>Not a member? <a href="#">Sign Up</a></p>
          <p>Forgot <a href="#">Password?</a></p>
        </div>
      </div>
      
    </div>
  </div> 

  <!-- Modal -->
  <div class="modal fade" id="myModal2" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header" style="padding:35px 50px;">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4><span class="glyphicon glyphicon-registration-mark"></span> SignUp</h4>
        </div>
        <div class="modal-body" style="padding:40px 50px;">
          <form role="form" action="welcome2.php" method="post">
            <div class="form-group">
              <label for="usrname"><span class="glyphicon glyphicon-user"></span> Username</label>
              <input type="text" class="form-control" id="usrname" placeholder="Enter Username" name="username" required>
            </div>
            <div class="form-group">
              <label for="psw"><span class="glyphicon glyphicon-eye-open"></span> Password</label>
              <input type="password" class="form-control" id="psw" placeholder="Enter password" name="password" required>
            </div>
<div class="form-group">
              <label for="psw"><span class="glyphicon glyphicon-pencil"></span> E-mail</label>
              <input type="text" class="form-control" id="psw" placeholder="Enter E-mail Id" name="email" required>
            </div>

            <!-- 
            <div class="form-group">
              <label for="psw"><span class="glyphicon glyphicon-eye-open"></span> Confirm Password</label>
              <input type="password" class="form-control" id="psw" placeholder="Enter password" name="password">
            </div> -->
              <button type="submit" class="btn btn-danger btn-block"><span class="glyphicon glyphicon-off"></span> SignUp</button>
          </form>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-danger btn-default pull-left" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancel</button>
     <!--      <p>Not a member? <a href="#">Sign Up</a></p>
          <p>Forgot <a href="#">Password?</a></p>
      -->   </div>
      </div>
      
    </div>
  </div> 
 
<script>
$(document).ready(function(){
    $("#myBtn").click(function(){
        $("#myModal").modal();
    });
});

$(document).ready(function(){
    $("#myBtn2").click(function(){
        $("#myModal2").modal();
    });
});
</script>

</body>
</html>
