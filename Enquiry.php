<?php
session_start();
include ("connect.php");
global $conn;

$acc_no = $_SESSION["acc_no"];

$sql_get_balance = "SELECT `Balance` FROM `Customers` WHERE `AccountNo` = '$acc_no'";
$get_balance_result = $conn->query($sql_get_balance);

while($row = $get_balance_result->fetch_assoc()){
		global $balance;
		$balance = $row['Balance'];
}


?>
<html>
<head>
	<title>ATM</title>
	<meta charset="utf-8">
	<link rel="stylesheet" href="css/index1.css">
	<!-- font -->
	<link href="https://fonts.googleapis.com/css?family=Lato&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Gugi&display=swap" rel="stylesheet">
	<style>
	span{
		height: 10px;
		width:5px;
		padding:0.5%;
		margin-right:3%;
		background-color:#4CAF50;
		text-decoration: none;
		border-color: white;
		border-style: solid;
		border-radius: 10px;
		text-align:center;
		font-family:lato,cursive;
		color:white;
	}
	span:hover
	{
		background-color:green;
		cursor:pointer;
	}
	a{
		text-decoration:none;
	}
	div{
		text-align:center;
		font-family:lato,cursive;
		color:white;
	}
	</style>
</head>

<!--Main Code goes here-->

<body>
	<div class="Head">
		<h1>Your Account Balance is:</h1>
		<p>Rs.<?= $balance?></p>
	</div>
	<div class="receipt">
		<p>Do you Want to Print Receipt?</p>
		<p><a href="menu.php"><span>Yes</span></a><a href="menu.php"><span>No</span></a></p>
	</div>
</body>
</html>