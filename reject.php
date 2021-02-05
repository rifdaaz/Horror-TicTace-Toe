<?php 
session_start();
if(isset($_POST['requestid'])){
	$reqid = $_POST['requestid'];
	include "connection.php";
	// Create connection
$conn = new mysqli($server, $username, $password);
$sql = "DELETE from ".$dbname.".requests where requestid=".$reqid;
$conn->query($sql);
header("Location: online.php");
}
?>