<?php 
	session_start();
	if(!(isset($_SESSION['Name']))){
		header("Location: index.php"); /* this redirect user to index page if user is not logged in */
	exit();
	}include "connection.php";
if (isset($_POST['submit'])){
    // var_dump($_FILES['image']);die;
    $namaGambar = $_FILES['image']['name'];
    $tmpname = $_FILES['image']['tmp_name']; //penyimpanan sementara 
    // var_dump($namaGambar);die;
    $eror = $_FILES['image']['error'];
    $size = $_FILES['image']['size']; 

 // cek apakah eror atau gak 

 if ($eror === 4){ // 4 artinya gambar tidak di upload, atau boleh tulis !$eror
  echo "<script> 
   alert ('harap upload foto');
   document.location.href = 'profile.php';
   </script>";
  return False ;
 }

 // cek ekstensi 

 $ekstensigambarValid = ['jpg','jpeg','png']; // ini ekstensi yang diperbolehkan 
 $ekstensifilegambar = explode('.', $namaGambar);
 $ekstensigambar = strtolower((end($ekstensifilegambar)));

 if (!in_array($ekstensigambar, $ekstensigambarValid)){

  echo "<script> 
   alert ('ekstensi gambar tidak valid');
   document.location.href = profile.php'; 
   </script>";
  return False ;

 }
 //  cek size foto 

 if ($size > 2000000){
  echo "<script> 
   alert ('ukuran size kebesaran');
   document.location.href = 'profile.php';
   </script>";
  return False ;
 }

 // jika lolos pengecekan, upload file
 // genetate nama gambar baru 

//  $namaGambarBaru  = uniqid();
//  $namaGambarBaru .- ".";
//  $namaGambarBaru .= $ekstensigambar;

 move_uploaded_file($tmpname, 'images/' . $namaGambar);

 include 'connection.php';
$conn = new mysqli($server, $username, $password,$dbname);// this create connection
$sql = "SELECT * from users where username='".$_SESSION['Name']."'";
$result=$conn->query($sql);
                // var_dump($result);die;
$row = $result->fetch_assoc();

$pass = $row['password'];
$id = $row['Id'] ;  
$image= $row['pic'];
            // var_dump($image);die;

$conn->query($sql);
$sql = "UPDATE INTO ".$dbname.".`users`(`id`, `username`, `password`, `pic`) VALUES ('".$id."', '".$_SESSION['Name']."', '". $pass."', '". $namaGambar."')";
$conn->query($sql);
//  return $namaGambarBaru;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">    
    <title>Document</title>

<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="css/stylesheet.css" rel="stylesheet">

</head>
<body style="background:url(images/bgpageonline.png);">

<nav class="navbar navbar-default">
  <div class="container-fluid"> 

  <div class="container-fluid"> 
    <!-- Brand and toggle get grouped for better mobile display -->
  <a href="online.php" > <button class="btn btn-default"> Back </button></a>

	<a class="navbar-brand"><img style="width: 65px; height: auto; margin-left: 25px; margin-top: 5px;"
          class="img-fluid" src="images/logo.png" alt="TOETICTAC"></a>

	<a><img style="width: 50px; height: auto; margin-top: 10px;" src="images/toetictac.svg"</a>

  <!-- <a href="online.php" class="btn btn-menu">Back</a>

  <a class="navbar-brand"><img style="width: 65px; height: auto; margin-left: 25px; margin-top: 5px;"
          class="img-fluid" src="images/logo.png" alt="TOETICTAC"></a>

	<a><img style="width: 50px; height: auto; margin-top: 20px;" src="images/toetictac.svg"</a> -->
      
</div></nav>

    <div class="container">

    
    <div class="card">
      <br>
    <h6 style="background-color: transparent;"><?= $_SESSION['Name']?>'s PROFILE</h6>
    <?php
    include 'connection.php';
    $conn = new mysqli($server, $username, $password,$dbname);// this create connection
    $sql = "SELECT * from users where username='".$_SESSION['Name']."'";
            $result=$conn->query($sql);
                // var_dump($result);die;
			$row = $result->fetch_assoc();
				
		        
            $image= $row['pic'];
            // var_dump($image);die;
    
    ?>
  <div>  
  <img src="images/<?= $image;?>" class="card-img-top" alt="Foto <?=$_SESSION['Name']?>" style="width:300px">
  </div>
  
    <!-- Button trigger modal -->
  <div class="container">
  <div class="row justify-content-center card-body">
     </div>
     <!-- <p class="card-text" style="margin-left: 16px">Nama: <?= $_SESSION['Name']?></p> -->
  <div class="row2 justify-content-center card-body"> 

  <div class="container-fluid"> 
  <button type="button" class="col-6 btn btn-menu" data-bs-toggle="modal" data-bs-target="#staticBackdrop"> Change Image </button>
  <a style= "color: black" href="editProfile.php"> <button type="button" style="width:150px" class="col-6 btn btn-menu"> Change Password </button> </a>
  </div>
  </div>
  </div>
</div>
</div>
<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Change Image</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <form action="" method= "post" enctype="multipart/form-data">
    <label class="form-label">Change Image</label>
    <input name="image" type="file" class="form-control" >
    <button type="submit" name="submit" class="btn btn-primary">Submit</button>
  </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
</body>

<!-- Option 1: Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>

<!-- Option 2: Separate Popper and Bootstrap JS -->
<!--
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js" integrity="sha384-q2kxQ16AaE6UbzuKqyBE9/u/KzioAlnx2maXQHiDX9d4/zp8Ok3f+M7DPm+Ib6IU" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.min.js" integrity="sha384-pQQkAEnwaBkjpqZ8RU1fF1AKtTcHJwFl3pblpTlHXybJjHpMYo79HY3hIi4NKxyj" crossorigin="anonymous"></script>
-->
</html>









