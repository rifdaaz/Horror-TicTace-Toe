<?php 
session_start();
if(isset($_GET['r'])){
	include 'connection.php';
	$ret ="";
	$conn = new MySQLi($server,$username,$password);
	$sql = "select * from ".$dbname.".gamesessions where sessionid=".$_SESSION['gamesessionid'];
	$result = $conn->query($sql);
	while($row = $result->fetch_assoc()){
		$count = $row['count'] ;
		$pl1id = $row['pl1id'];
		$pl2id = $row['pl2id'];
		$boxs = array(0,$row['box1'],$row['box2'],$row['box3'],$row['box4'],$row['box5'],$row['box6'],$row['box7'],$row['box8'],$row['box9']);
		if($boxs[1] == 1 && $boxs[2] == 1 && $boxs[3] == 1 ||
        	$boxs[4] == 1 && $boxs[5] == 1 && $boxs[6] == 1 ||
            $boxs[7] == 1 && $boxs[8] == 1 && $boxs[9] == 1 ||

            $boxs[1] == 1 && $boxs[4] == 1 && $boxs[7] == 1 ||
            $boxs[2] == 1 && $boxs[5] == 1 && $boxs[8] == 1 ||
            $boxs[3] == 1 && $boxs[6] == 1 && $boxs[9] == 1 ||

            $boxs[1] == 1 && $boxs[5] == 1 && $boxs[9] == 1 ||
            $boxs[3] == 1 && $boxs[5] == 1 && $boxs[7] == 1)
        {
            $ret = "pl1";
			echo $ret;
			$hash=$_SESSION['Id'].$_SESSION['gamesessionid'];
			$conn2 = new MySQLi($server,$username,$password,$dbname);
			if($pl1id == $_SESSION['Id']){
				$querywin="INSERT INTO status(sessionid, Id, winstatus, hash) VALUES(".$_SESSION['gamesessionid'].", ".$_SESSION['Id'].", 1,'".$hash."')";
				$winning= $conn2-> query($querywin);
				
			}else {
				$querylose="INSERT INTO status(sessionid, Id, winstatus, hash) VALUES(".$_SESSION['gamesessionid'].", ".$_SESSION['Id'].", 0,'".$hash."')";
				$losing= $conn2-> query($querylose);
				
			}		
			   
        }
        else if($boxs[1] == 2 && $boxs[2] == 2 && $boxs[3] == 2 ||
            $boxs[4] == 2 && $boxs[5] == 2 && $boxs[6] == 2 ||
           	$boxs[7] == 2 && $boxs[8] == 2 && $boxs[9] == 2 ||

           	$boxs[1] == 2 && $boxs[4] == 2 && $boxs[7] == 2 ||
           	$boxs[2] == 2 && $boxs[5] == 2 && $boxs[8] == 2 ||
            $boxs[3] == 2 && $boxs[6] == 2 && $boxs[9] == 2 ||

            $boxs[1] == 2 && $boxs[5] == 2 && $boxs[9] == 2 ||
            $boxs[3] == 2 && $boxs[5] == 2 && $boxs[7] == 2)
        {  
            $ret = "pl2";
			echo $ret;
			$hash=$_SESSION['Id'].$_SESSION['gamesessionid'];
			$conn2 = new MySQLi($server,$username,$password,$dbname);
			if($pl2id == $_SESSION['Id']){
				$querywin="INSERT INTO status(sessionid, Id, winstatus, hash) VALUES(".$_SESSION['gamesessionid'].", ".$_SESSION['Id'].", 1,'".$hash."')";
				$winning= $conn2-> query($querywin);
				
			}else {
				$querylose="INSERT INTO status(sessionid, Id, winstatus, hash) VALUES(".$_SESSION['gamesessionid'].", ".$_SESSION['Id'].", 0,'".$hash."')";
				$losing= $conn2-> query($querylose);
			}
        }
		else if($count == 9){
			$ret = "draw";
			echo $ret;
			$hash=$_SESSION['Id'].$_SESSION['gamesessionid'];
			$conn2 = new MySQLi($server,$username,$password,$dbname);
			if($pl1id == $_SESSION['Id']){
				$querywin="INSERT INTO status(sessionid, Id, winstatus, hash) VALUES(".$_SESSION['gamesessionid'].", ".$_SESSION['Id'].", 2,'".$hash."')";
				$winning= $conn2-> query($querywin);
				
			}else {
				$querylose="INSERT INTO status(sessionid, Id, winstatus, hash) VALUES(".$_SESSION['gamesessionid'].", ".$_SESSION['Id'].", 2,'".$hash."')";
				$losing= $conn2-> query($querylose);
			}
		}
	}
	if($ret == ""){
		$sql = "select * from ".$dbname.".gamesessions where sessionid=".$_SESSION['gamesessionid'] ;
		$result = $conn->query($sql);
		while($row = $result->fetch_assoc()){
	
			$pl1id= $row['pl1id'];
			$pl2id= $row['pl2id'];
			$pl1scr = $row['pl1scr'];
			$pl2scr = $row['pl2scr'];
			$count = $row['count'];
			$turn = $row['turn'];
			$boxs = array($row['box1'],$row['box2'],$row['box3'],$row['box4'],$row['box5'],$row['box6'],$row['box7'],$row['box8'],$row['box9']);
			
			for($i=0; $i<9; $i++){
				if($_SESSION['boxs'][$i] != $boxs[$i])
				{
					$_SESSION['boxs'][$i] = $boxs[$i];
					echo $i+1;
				}
			}
		}
	}
}
?>