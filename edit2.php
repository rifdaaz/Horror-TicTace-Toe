<?php
	session_start();
	if(!(isset($_SESSION['Name']))){
		header("Location: profile.php"); /* this redirect user to index page if user is not logged in */
    exit();
    }
    //include "navbar.php";
	include "connection.php";
?>
<!DOCTYPE html>
<html>
<link href="css/bootstrap2.css" rel="stylesheet">
 <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Butcherman+Caps" />
 <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Creepster+Caps" />
<head>
	<title>edit profile</title>
	<style type="text/css">
		.form-control
		{
			width:250px;
			height: 38px;
		}
		.form1
		{
			margin: 10px 10px;
		}
		label
		{
			color: white;
		}

	</style>
</head>
<body style="background: url(images/bg.png)" class="jalan">
<nav class="navbar navbar-default">
  <div class="container-fluid"> 
    <!-- Brand and toggle get grouped for better mobile display -->
    <img src = "images/judul.png" style = " width: 202px;height: 72px;"> </img>
    <!-- <h1 style=" color: #440000; font-family: "Butcherman Caps" ;"> Tic Tac Toe</h1>
    <h3 style="position : relative ; color: #440000 ; font-family: "Butcherman Caps" ;"> Horror</h3>-->
</div></nav>
<div class="container  text-center">
<h1 style="text-align: center;color: brown;">Edit Information</h1>
	<?php
		
		$sql = "SELECT * FROM users WHERE username='$_SESSION[Name]'";
		$result = mysqli_query($db,$sql) or die (mysql_error());

		while ($row = mysqli_fetch_assoc($result)) 
		{
			$first=$row['first'];
			$last=$row['last'];
			$username=$row['username'];
			$password=$row['password'];
			$email=$row['email'];
			$contact=$row['contact'];
		}
	?>
	<div class="profile_info" style="text-align: center;">
		<h2 style="color: brown;">Welcome,</h2>	
		<h3 style="color: brown;"><?php echo $_SESSION['Name']; ?></h3>
	</div><br><br>
	
	<div class="form1">
		
	<form action="" method="post" enctype="multipart/form-data">
		<input class="form-control text-left center-block" type="file" name="file">

		<label><h5><b style="color:brown; ">First Name :</b></h4></label>
		<input class="form-control text-left center-block" type="text" name="first" value="<?php echo $first; ?>">

		<label><h5><b style="color:brown;">Last Name</b></h5></label>
		<input class="form-control text-left center-block" type="text" name="last" value="<?php echo $last; ?>">

		<label><h5><b style="color:brown;">Username</b></h5></label>
		<input class="form-control text-left center-block" type="text" name="username" value="<?php echo $username; ?>">

		<!--<label><h5><b style="color:brown;">Password</b></h5></label>
		<input class="form-control text-left center-block" type="text" name="password" value="<?php echo $password; ?>">-->

		<label><h5><b style="color:brown;">Email</b></h5></label>
		<input class="form-control text-left center-block" type="text" name="email" value="<?php echo $email; ?>">

		<label><h5><b style="color:brown;"> Contact No</b></h5></label>
        <input class="form-control text-left center-block" type="text" name="contact" value="<?php echo $contact; ?>"><br><br>
        

		<br>
		<div style="padding-left: 100px;">
			<button class="btn btn-default" type="submit" name="submit">save</button></div>
	</form>
</div>
    </div>
	<?php 

		if(isset($_POST['submit']))
		{
			move_uploaded_file($_FILES['file']['tmp_name'],"images/".$_FILES['file']['name']);

			$first=$_POST['first'];
			$last=$_POST['last'];
			$username=$_POST['username'];
			$password=$_POST['password'];
			$email=$_POST['email'];
			$contact=$_POST['contact'];
			$pic=$_FILES['file']['name'];

			$sql1= "UPDATE users SET username='$username', password='$password', first='$first', last='$last', email='$email', contact='$contact', pic='$pic' WHERE username ='".$_SESSION['Name']."';";

			if(mysqli_query($db,$sql1))
			{
				?>
					<script type="text/javascript">
						alert("Saved Successfully.");
						window.location="profile.php";
					</script>
				<?php
			}
		}
 	?>
	  <a href="profile.php" > <button style="float:left; margin:2%;" class="btn btn-default"> <span class="glyphicon glyphicon-profile"> </span>Back</button></a>
</body>
</html>

