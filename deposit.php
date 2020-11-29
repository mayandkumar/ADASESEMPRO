<?php
session_start();
include ("connect.php");
global $conn;

$cheque_no = 1;
$amount = $_POST["deposit_amount"];
$acc_no = $_SESSION["acc_no"];

$message = "Successful transaction : Deposited Rs ".$amount ;
$sql_get_balance = "SELECT `Balance` FROM `Customers` WHERE `AccountNo` = '$acc_no'";
$get_balance_result = $conn->query($sql_get_balance);

while($row = $get_balance_result->fetch_assoc()){
		global $balance;
		$balance = $row['Balance'];
}
global $balance;
$updated_balance=$balance+$amount;
$coun=0;
$sql1="SELECT `ChequeNo` FROM `Deposit`";
//$sql1=$conn->query($sql1);
//$count=mysqli_query($conn,$sql1);
//$row=mysqli_fetch_assoc($count);
//$coun=$row['max_no'];
$c=mysqli_query($conn,$sql1);
while($row=mysqli_fetch_array($c)){
	$coun=$row[0];
}
//$result= mysql_query("SELECT MAX(column_name) AS maximum FROM table");

//$row = mysql_fetch_assoc($result); 

//$maximum = $row['maximum'];

$coun+=1;
// $cheque_no=$cheque_no+$coun;
$get_atm_bal="SELECT `ATM_amount` FROM `ATM` WHERE `SNo`='1'";
$c=$conn->query($get_atm_bal);
while($row=$c->fetch_assoc()){
	global $atm_bal;
	$atm_bal=$row['ATM_amount'];
}
$atm_bal+=$amount;
$up_amount="UPDATE `ATM` SET `ATM_Amount`='$atm_bal' WHERE `SNo`='1'";
$conn->query($up_amount);
$sql = "UPDATE `Customers` SET `Balance` = '$updated_balance' WHERE `AccountNo` = '$acc_no'";
$sql_deposit = "INSERT INTO `Deposit` VALUES ('$acc_no','$coun','$amount')";
$conn->query($sql_deposit);		
$conn->query($sql);


?>
<html>
<head>
<link rel="stylesheet" href="css/index1.css">
<link href="https://fonts.googleapis.com/css?family=Lato&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Gugi&display=swap" rel="stylesheet">
<style>
#myback{
	  display:block;
	  margin: 0 auto;
	  margin-top:15px;
	  
	text-align: center;
    text-decoration: none;
    font-size: 25px;
    color: white;
  }
  
  h3,#myback{
	  color:#fff;
	  font-family:lato,cursive;
  }
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
</style>
</head>
	<body>
	<br>
	<h3 style="text-align:center;"><?= $message ?></h3><br>
	<div id="myback">
		<p>Do you Want to Print Receipt?</p>
		<p><a href="menu.php"><span>Yes</span></a><a href="menu.php"><span>No</span></a></p>
	</div>
	</body>

</html>