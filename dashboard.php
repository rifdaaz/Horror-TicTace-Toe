<?php 
session_start();
if(!(isset($_SESSION['Name']))){
	header("Location: index.php"); /* this redirect user to index page if user is not logged in */
exit();
}
include 'connection.php'; // this file contains $server,$username,$password
// PHP script on challenge
?>
<?php 
  $conn = new mysqli($server, $username, $password);
    $winner=0;
    $winAvg=0;
    $drawAvg=0;
    $loseAvg=0;
    $loser=0;
    $endraw=0;

  $sqlwin= "select * from ".$dbname.".status where Id=".$_SESSION['Id']." and winstatus=1";
  $sqllose= "select * from ".$dbname.".status where Id=".$_SESSION['Id']." and winstatus=0";
  $sqldraw= "select * from ".$dbname.".status where Id=".$_SESSION['Id']." and winstatus=2";
  $win = $conn->query($sqlwin);
  $lose = $conn->query($sqllose);
  $draw = $conn->query($sqldraw);

  $winner= mysqli_num_rows($win);
  $loser= mysqli_num_rows($lose);
  $endraw= mysqli_num_rows($draw);

  $totalPlay = $winner+$endraw+$loser;
  $winAvg= ($winner/$totalPlay)*100;
  $drawAvg= ($endraw/$totalPlay)*100; 
  $loseAvg= ($loser/$totalPlay)*100;
  ?>
  <?php 
// PHP script on challenge
if(isset($_POST['plrid'])){
$id = $_POST['plrid']; // get id of challenged player
$name ="";
$conn = new mysqli($server, $username, $password);
$sql = "SELECT * FROM ".$dbname.".`users` WHERE Id =".$id;
$result = $conn->query($sql);
if($result->num_rows>0){
	while($row = $result->fetch_assoc()){
		$name = $row['username']; // get the name of challenged player
	}
}
$sql = "select * from $dbname.requests";// select requests 
$result = $conn->query($sql);
$i = 0;
if($result->num_rows>0){
	while($row = $result->fetch_assoc()){// check if the request is already sended.
	      if($row['senderid'] == $_SESSION["Id"] && $row['recieverid'] == $id){
			 $i=1;
			 break; 
		  }
	}
}
if($i == 0){// insert request in request table
$sql = "INSERT INTO ".$dbname.".`requests`(`senderid`, `sendername`, `recieverid`, `recievername`, `status`)  VALUES (".$_SESSION['Id'].",'".$_SESSION['Name']."',".$id.",'".$name."',false)";
$conn->query($sql) ;
}
	$sql = "SELECT requestid FROM ".$dbname.".`requests` WHERE senderid=".$_SESSION['Id']." and recieverid=$id";// get the id of request send
	$result = $conn->query($sql);
	while($row = $result->fetch_assoc()){
	   $_SESSION['requestid'] = $row['requestid']; // set a session for request id
	   header("Location: challenge.php"); /* Redirect to challenge page */
exit();
}
}

$error = "";
   
// Create connection

?>
<!--
=========================================================
* Paper Dashboard 2 - v2.0.1
=========================================================

* Product Page: https://www.creative-tim.com/product/paper-dashboard-2
* Copyright 2020 Creative Tim (https://www.creative-tim.com)

Coded by www.creative-tim.com

 =========================================================

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
-->
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <link rel="apple-touch-icon" sizes="76x76" href="./assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="./assets/img/favicon.png">
 
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>
    TIC TAC TOE
  </title>
  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
  <!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
  <!-- CSS Files -->
  <link href="./css/css/bootstrap.min.css" rel="stylesheet" />
  <link href="./css/css/bootstrap2.css" rel="stylesheet" />
  <link href="./css/css/paper-dashboard.css?v=2.0.1" rel="stylesheet" />
  <!-- CSS Just for demo purpose, don't include it in your project -->
  <link href="./assets/demo/demo.css" rel="stylesheet" />
  <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Butcherman+Caps" />
  <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Creepster+Caps" />
</head>

<body style="background: url(images/bg.png) center;" class="jalan">
  <div class="wrapper ">
    <div class="sidebar" data-color="white" data-active-color="danger">
      <div class="logo">
        <a href="" class="simple-text logo-mini">
          <!-- <div class="logo-image-small">
            <img src="./assets/img/logo-small.png">
          </div> -->
          <!-- <p>CT</p> -->
        </a>
        <img src= "images/judul.png" class="simple-text logo-normal">
          <!-- <div class="logo-image-big">
            <img src="../assets/img/logo-big.png">
          </div> -->
        </a>
      </div>
      <div class="sidebar-wrapper">
        <ul class="nav">
          <li class="active ">
            <a href="dashboard.php" style="font-size=18px;">
              <img src= "images/tengkorak.png" style = "widht:35px;height:45px"></img>
              Beranda
            </a>
          </li>
          <li>
            <a href="profile.php">
            <img src= "images/tengkorak.png" style = "widht:35px;height:45px"></img>
              Profile
            </a>
          </li>
          <li>
            <a href="logout.php">
              <img src= "images/tengkorak.png" style = "widht:35px;height:45px"></img>
              Log Out
            </a>
          </li>
        </ul>
      </div>
    </div>

    <div class="main-panel" style= "img: url  (images/bg.png);height: 100vh;">
      <!-- Navbar -->
      <nav class="navbar navbar-expand-lg navbar-absolute fixed-top navbar-transparent">
        <div class="container-fluid">
          <div class="navbar-wrapper">
            <div class="navbar-toggle">
              <button type="button" class="navbar-toggler">
                <span class="navbar-toggler-bar bar1"></span>
                <span class="navbar-toggler-bar bar2"></span>
                <span class="navbar-toggler-bar bar3"></span>
              </button>
            </div>
            <a class="navbar-brand" href="dashboard.php" style= "font-family= "Creepster Caps" ;">Beranda</a>
          </div>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-bar navbar-kebab"></span>
            <span class="navbar-toggler-bar navbar-kebab"></span>
            <span class="navbar-toggler-bar navbar-kebab"></span>
          </button>
          <div class="collapse navbar-collapse justify-content-end" id="navigation">
            <form>
              <div class="input-group no-border">
                <!--<input type="text" value="" class="form-control" placeholder="Search...">-->
                <div> <?php echo $_SESSION['Name']; ?></div>
                <div class="input-group-append">
                  <div class="input-group-text">
                    <i class="nc-icon nc-zoom-split"></i>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </nav>
      <!-- End Navbar -->
      <div class="content">
      <div class="row">
          <div class="col-md-12">
            <div class="card ">
              <div class="card-header ">
                <h1 class="card-title"> Selamat Datang,  <?php echo $_SESSION['Name']; ?> </h1>
               
                <div  style="text-align:center;">
                    <h1 style = "color: brown;  font-family: "Creepster";"> </h1>
                    <h4 class="text-left" style = "font-family : "Creepster"; font-size:10px"> Nama Pemain : <?php echo $_SESSION['Name'];?> </h4>
                    <hr>
                    <div style="width:80%; margin-left:10%; text-align:center">
                    <div style="width:80%; margin-left:10%; text-align:left;">
                        
                  <span id="onlinepl"> </span>
                    <p> <?php echo $error // display error ?></p>
                    </div>
                    </div>
                  </div>
                <div class="stats">
                  <a href ="dashboard.php">
                  <i href="dashboard.php" class="fa fa-history" style="width:20px"></i>
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
      <div class="row">
          <div class="col-md-6">
            <div class="card card-chart">
              <div class="card-header ">
                <h5 class="card-title">Main Secara Online</h5>
                <p class="card-category">Ayo mainnnnnn</p>
              </div>
              <div class="card-body ">
              
              </div>
              <a href = online.php style=>
              <button type="submit" style="background: linear-gradient(88.46deg, #360101 7.65%, #780101 98.18%), #55C595;
                    border: 3px solid #FFFFFF; position: relative;
                    box-sizing: border-box;width: 200px; height: 50px; left: 25%; top: 0px;
                    box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25);
                    border-radius: 27.5px;" class="btn-primary">Main Secara Online</button>
            </a>
              <div class="card-footer ">

                <hr>
                <div class="stats">
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="card card-chart">
              <div class="card-header">
                <h5 class="card-title">Main kuy</h5>
                <p class="card-category">Line Chart with Points</p>
              </div>
              <div class="card-body">
              </div>
              <a href = "mainsendiri.php">
              <button type="submit"  style="background: linear-gradient(88.46deg, #360101 7.65%, #780101 98.18%), #55C595;
                    border: 3px solid #FFFFFF; position: relative;
                    box-sizing: border-box;width: 200px; height: 50px; left: 25%; top: 0px;
                    box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25);
                    border-radius: 27.5px;" class="btn-primary">Main sendiri aja deh</button>
            </a>
              <div class="card-footer">
                <div class="chart-legend">
                </div>
                <hr />
                <div class="card-stats">
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-stats">
              <div class="card-body ">
                <div class="row">
                  <div class="col-5 col-md-4">
                    <div class="icon-big text-center icon-warning">
                      <i class="nc-icon nc-globe text-warning"></i>
                    </div>
                  </div>
                  <div class="col-6 col-md-7">
                    <div class="numbers">
                      <p class="card-category">Jumlah Main</p>
                      <p class="card-title"><?php echo $totalPlay;?> Kali</p>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card-footer ">
                <hr>
                <div class="stats">
                 
                  
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-stats">
              <div class="card-body ">
                <div class="row">
                  <div class="col-5 col-md-4">
                    <div class="icon-big text-center icon-warning">
                      <i class="nc-icon nc-money-coins text-success"></i>
                    </div>
                  </div>
                  <div class="col-6 col-md-7">
                    <div class="numbers">
                      <p class="card-category">Menang</p>
                      <p class="card-title"><?php echo $winner;?> Kali</p>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card-footer ">
                <hr>
                <div class="stats">
                  <i class="fa fa-calendar-o"></i>
                  Yey, Menang
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-stats">
              <div class="card-body ">
                <div class="row">
                  <div class="col-5 col-md-4">
                    <div class="icon-big text-center icon-warning">
                      <i class="nc-icon nc-vector text-danger"></i>
                    </div>
                  </div>
                  <div class="col-6 col-md-7">
                    <div class="numbers">
                      <p class="card-category">Seri</p>
                      <p class="card-title"><?php echo $endraw;?> Kali</p>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card-footer ">
                <hr>
                <div class="stats">
                  <i class="fa fa-clock-o"></i>
                  cie ga kalah nih 
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-stats">
              <div class="card-body ">
                <div class="row">
                  <div class="col-5 col-md-4">
                    <div class="icon-big text-center icon-warning">
                      <i class="nc-icon nc-favourite-28 text-primary"></i>
                    </div>
                  </div>
                  <div class="col-6 col-md-7">
                    <div class="numbers">
                      <p class="card-category">Kalah</p>
                      <p class="card-title"><?php echo $loser;?> Kali</p>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card-footer ">
                <hr>
                <div class="stats">
                  <i class="fa fa-refresh"></i>
                  yey payah
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="content">
        <div class="row">
          <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-stats">
              <div class="card-body ">
                  <div class="col-6 col-md-7">
                    <div class="numbers">
                      <p class="card-category text-left">Rasio Menang-Seri-Kalah</p>
                      <p class="card-title"><p><?php echo $winner;?> : <?php echo $endraw;?> : <?php echo $loser;?></p>
                    </div>
                </div>
              </div>
              <div class="card-footer ">
              <hr>
                <div class="stats">
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-stats">
              <div class="card-body ">
                <div class="row">
                  <div class="col-5 col-md-4">
                    <div class="icon-big text-center icon-warning">
                      <i class="nc-icon nc-money-coins text-success"></i>
                    </div>
                  </div>
                  <div class="col-6 col-md-7">
                    <div class="numbers">
                      <p class="card-category">Rasio Menang</p>
                      <p class="card-title"><p><?php echo round($winAvg,1);?> %</p>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card-footer ">
                <hr>
                <div class="stats">
                  <i class="fa fa-calendar-o"></i>
                  Yey kamu selamat
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-stats">
              <div class="card-body ">
                <div class="row">
                  <div class="col-5 col-md-4">
                    <div class="icon-big text-center icon-warning">
                      <i class="nc-icon nc-vector text-danger"></i>
                    </div>
                  </div>
                  <div class="col-6 col-md-7">
                    <div class="numbers">
                      <p class="card-category">Rasio Seri</p></p>
                      <p class="card-title"><?php echo round($drawAvg,1);?> %</p>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card-footer ">
                <hr>
                <div class="stats">
                  <i class="fa fa-clock-o"></i>
                  cie ga kalah nih ye
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-stats">
              <div class="card-body ">
                <div class="row">
                  <div class="col-5 col-md-4">
                    <div class="icon-big text-center icon-warning">
                      <i class="nc-icon nc-favourite-28 text-primary"></i>
                    </div>
                  </div>
                  <div class="col-6 col-md-7">
                    <div class="numbers">
                      <p class="card-category">Rasio Kalah</p>
                      <p class="card-title"><?php echo round($loseAvg,1);?> %</p>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card-footer ">
                <hr>
                <div class="stats">
                  <i class="fa fa-refresh"></i>
                  yey payah
                </div>
              </div>
            </div>
          </div>
        </div>
        <!--<div class="row">
          <div class="col-md-12">
            <div class="card ">
              <div class="card-header ">
                <h5 class="card-title"> Pemain Online </h5>
                <p class="card-category">24 Hours performance</p>
                <div  style="text-align:center;">
                    <h1 style = "color: brown;  font-family: "Creepster";"> online players: </h1>
                    <h4 class="text-left" style = "font-family : "Creepster"; font-size:10px"> Nama Pemain : <?php echo $_SESSION['Name'];?> </h4>
                    <hr>
                    <div style="width:80%; margin-left:10%; text-align:center">
                    <div style="width:80%; margin-left:10%; text-align:left;">
                        
                  <span id="onlinepl"> </span>

                      
                    
                    <p> <?php echo $error // display error ?></p>
                    </div>
                    </div>
                  </div>
                <div class="stats">
                  <i class="fa fa-history"></i> Updated 3 minutes ago
                </div>
              </div>
            </div>
          </div>
        </div>-->
    </div>
      <footer class="footer  footer-white ">
        <div class="container-fluid">
          <div class="row">
            <nav class="footer-nav">
            </nav>
            <div class="credits ml-auto">
              <span style="color:white">
                © Tic Tac Toe <i class="fa fa-heart heart"></i> yuhu
              </span>
          </div>
        </div>
      </footer>
    </div>
  </div>
  </div>
  
  <!--   Core JS Files   -->
  <script src="./assets/js/core/jquery.min.js"></script>
  <script src="./assets/js/core/popper.min.js"></script>
  <script src="./assets/js/core/bootstrap.min.js"></script>
  <script src="./assets/js/plugins/perfect-scrollbar.jquery.min.js"></script>
  <!--  Google Maps Plugin    -->
  <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script>
  <!-- Chart JS -->
  <script src="./assets/js/plugins/chartjs.min.js"></script>
  <!--  Notifications Plugin    -->
  <script src="./assets/js/plugins/bootstrap-notify.js"></script>
  <!-- Control Center for Now Ui Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="./assets/js/paper-dashboard.min.js?v=2.0.1" type="text/javascript"></script>
</body>

</html>
