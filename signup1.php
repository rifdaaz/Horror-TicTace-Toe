<?php 
session_start();// session started

		if(isset($_SESSION['Name'])){ /*
 this check if user is log in  by checking $_SESSION['Name'] variable  */	
		header("Location:online.php"); 
		}
	
	

?><!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>SignUp - Online Test</title>
<link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Butcherman+Caps" />
<link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Creepster+Caps" />

<?php 
$user ="";
$pass = "";
$rpass="";
//$first = "";
//$last = "";
$email = "";
//$contact = "";
$error1 = "";// this will be use for displaying error (Username or password is incorrect)
$error = "";// this will be use for displaying sql connect errors

    if(isset($_POST['username'])){ /* this if checks is form is submitted by checking that $_POST['username'] is set or exists */
	$pass = $_POST['password'];
	$rpass = $_POST['rpassword'];
  $user = $_POST['username'];
  //$first = $_POST['firstname'];
  //$last = $_POST['lastname'];
  $email = $_POST['email'];
  //$contact = $_POST['contact'];
	if($pass == $rpass){

   include 'connection.php'; /* this file contains variables used for connecting to database ($server,$username,$password,$dbname)*/
//$conn=mysqli_connect("localhost","root","","pweb");  
$conn = new mysqli($server, $username, $password,$dbname);// this create connection
if ($conn->connect_error) { //  this checks if there error connecting to server
	$error = die("Connection failed: " . $conn->connect_error); // saves error  in $error
} 
$user =  trim(htmlspecialchars($_POST['username']));/* this will trim(remove extra spaces) and remove html tags from username*/
$pass = trim(htmlspecialchars($_POST['password']));/* this will trim(remove extra spaces) and remove html tags from password*/
$sql = "SELECT * FROM `users` WHERE username='".$user."'";
$result= $conn->query($sql);
if($result->num_rows>0){
	$error = "Username Already Exists!";
}
else {
  
  $sql = "INSERT INTO `users`(`username`, `password`, `email`) VALUES ('".$user."','".$pass."','".$email."')";
if($conn->query($sql)== true){
		   
			$sql = "select * from users where username='".$user."'";
			$result=$conn->query($sql);
			while($row = $result->fetch_assoc()){
				
		    $_SESSION['Name'] =  $row['username'];
			$_SESSION['Id'] = $row['Id'];
			$sql = "DELETE FROM ".$dbname.".`online` WHERE plrid=".$_SESSION["Id"];
			$conn->query($sql);
			$sql = "INSERT INTO ".$dbname.".`online`(`plrid`, `plrname`) VALUES (".$_SESSION['Id'].",'".$_SESSION['Name']."')";
			$conn->query($sql);
			
			
			header("Location:dashboard.php"); /* Redirect browser */
exit();
			}		
			
}	
}
	}
	else {
		$error = "Passwords not matched!";
		}
	
	}
	 


   
?>
<link href="css/bootstrap2.css" rel="stylesheet">

<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body style="background: url(images/bg.png) center;" class="jalan">

<nav class="navbar navbar-default">
  <div class="container-fluid"> 
    <!-- Brand and toggle get grouped for better mobile display -->
    <img src = "images/judul.png" style = " width: 202px;height: 72px;"> </img>
    <!-- <h1 style=" color: #440000; font-family: "Butcherman Caps" ;"> Tic Tac Toe</h1>
    <h3 style="position : relative ; color: #440000 ; font-family: "Butcherman Caps" ;"> Horror</h3>-->
    <a href="index.php">
    <button style="float:right; margin:2%;" class="btn btn-default">Login </button></a>
      
</div></nav>

<div class="container text-center" >
  
  <h2 style= "float:center; color: #440000; font-family: "Butcherman Caps" ;"> Sign Up </h2> 
 
  <hr>
  
    
    <form action="signup.php" method="post" >
    <div class="form-group text-left center-block" style=" width:50%;" ><br>
      <label for="usr">Username:</label>
      <input placeholder="Enter You Username..." type="text" class="form-control" name="username"required value="<?php echo $user?>"> 
    </div>
     <!-- <input placeholder="Enter Your First Name..." type="text" class="form-control" name="firstname"required value="<?php echo $first?>"> 
    <form action="signup.php" method="post" >
    <div class="form-group text-left center-block" style=" width:50%;" ><br>
      <label for="firstname">First Name:</label>
      <input placeholder="Enter Your First Name..." type="text" class="form-control" name="firstname"required value="<?php echo $first?>"> 
    </div>-->
    <!--<div class="form-group text-left center-block" style=" width:50%;" ><br>
      <label for="last">Last Name:</label>
      <input placeholder="Enter Your Last Name..." type="text" class="form-control" name="lastname"required value="<?php echo $last?>"> 
    </div>-->
    <div class="form-group text-left center-block" style=" width:50%;" ><br>
      <label for="email">Email:</label>
      <input placeholder="Enter Your E-mail..." type="text" class="form-control" name="email"required value="<?php echo $email?>"> 
    </div>
    <!--<div class="form-group text-left center-block" style=" width:50%;" ><br>
      <label for="contact">Contact:</label>
      <input placeholder="Enter Your Contact..." type="text" class="form-control" name="contact"required value="<?php echo $contact?>"> 
    </div>-->
    <div class="form-group text-left center-block" style=" width:50%;" ><br>
      <label for="pwd">Password:</label>
      <input placeholder="Enter your Password..." type="password" class="form-control" name="password" required value="<?php echo $pass?>"> 
    </div>
    <div class="form-group text-left center-block" style=" width:50%;" ><br>
      <label for="pwd">Re-type Password:</label>
      <input placeholder="Re-type Password..." type="password" class="form-control" name="rpassword" required value="<?php echo $rpass?>"> 
    </div>
    <br><br>
    <?php echo '<p style="color:red">'.$error. "</p>"?>
    <h4 style="color: #440000; font-family: "Creepster Caps" ;"><input id="submit"  type="submit" class="btn-primary" value="Sign Up"/> <button class="btn-primary" type="reset" > Clear </button></h4>
  </form>
  
<div>
  Already Have an Account? Click Here to Login
</div> 
<br>
<br>
<br>
<br>
<br>
   <br><b>&copy; TicTacToe Kelompok entah apa ya</b> </div> 
</html>
