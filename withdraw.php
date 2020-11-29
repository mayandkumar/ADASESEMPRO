<?php
$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "ATM_System";

$conn = new mysqli($dbhost, $dbuser, $dbpass,$dbname);

session_start();
$account_no = $_SESSION["acc_no"];
$pin_no;

//echo "Hello".$account_no."<br>";
	global $account_no;
	$account_no = $_SESSION["acc_no"];

	
	
	/* $sql_get_pin = "SELECT `PIN` FROM `Users` WHERE `Account_No` = '$account_no'";
	
	$get_pin_result = $conn->query($sql_get_pin);
	
//	echo "Account No :".$account_no;
	//
	//$pin_no = $get_pin_result;

	while($row = $get_pin_result->fetch_assoc()){
			global $pin_no;
			$pin_no = $row['PIN'];
	}
	//echo "Actual Pin : ".$pin_no;
	


$entered_pin_no  = $_POST["pin_no"]; */
$amount = $_POST["withdraw_amount"];
$balance;

$sql_get_balance = "SELECT `Balance` FROM `Customers` WHERE `AccountNo` = '$account_no'";
$get_balance_result = $conn->query($sql_get_balance);

$get_atm_bal="SELECT `ATM_amount` FROM `ATM` WHERE `SNo`='1'";
$c=$conn->query($get_atm_bal);
$atm_bal;
while($row=$c->fetch_assoc()){
	global $atm_bal;
	$atm_bal=$row['ATM_amount'];
}

while($row = $get_balance_result->fetch_assoc()){
		global $balance;
		$balance = $row['Balance'];
}


if(isset($_POST["pin_no"])&&!empty($_POST["pin_no"])){
		global $entered_pin_no;
		$entered_pin_no = $_POST["pin_no"];
}

if(isset($_POST["withdraw_amount"])&&!empty($_POST["withdraw_amount"])){
		global $amount;
		$amount = $_POST["withdraw_amount"];
}
$updated_balance;

// -1 : pins donot match
// 0 : insufficient balance 
// 1 : successful transaction 
$message ;
$msg="Error";
function withdraw(){
		global $balance;
		global $amount;
		global $account_no;
		/* global $pin_no;
		global $entered_pin_no; */
		global $conn;
		global $atm_bal;
		/* if($pin_no!=$entered_pin_no){
			global $message ;
			$message = "Pin Invalid";
			return -1;
			} */
		if($amount>10000)
		{
			global $message;
			$message="Amount must be less than or equal to 10000.";
			return -1;
		}
		if($amount%100!=0)
		{
			global $message;
			$message="Amount must be in multiple of 100.";
			return -1;
		}
		if($amount>$atm_bal)
		{
			global $message;
			$message= "Insufficient Cash in ATM.";
			return -1;
		}
		if($balance<$amount){
			global $message ;
			$message = "Insufficient balance in your account.";
			return -1;
			}
		else{
			global $account_no;
			global $updated_balance;
			$updated_balance = $balance - $amount;
			$_SESSION["updated_balance"] = $updated_balance; 
			$coun=0;
			$sql1="SELECT `SNo` FROM `Withdraw`";
			$c=mysqli_query($conn,$sql1);
			while($row=mysqli_fetch_array($c)){
				$coun=$row[0];
			}
			$coun+=1;
			$atm_bal-=$amount;
			$up_amount="UPDATE `ATM` SET `ATM_Amount`='$atm_bal' WHERE `SNo`='1'";
			$conn->query($up_amount);
			$sql = "UPDATE `Customers` SET `Balance` = '$updated_balance' WHERE `AccountNo` = '$account_no'";
			$sql_withdraw = "INSERT INTO `Withdraw` VALUES ('$account_no','$amount','$updated_balance','$coun')";
			global $conn;
			$conn->query($sql);
			$conn->query($sql_withdraw);
			global $message ;
			$message = "Successful transaction : Rs ".$amount ;
			global $msg;
			$msg="Collect Your Cash";
			return 1;
		}
}
$retval = withdraw();
//echo "withdraw Function ".$updated_balance." : ".$retval;

?>
<html>
<head>
<meta charset="utf-8">
<link rel="stylesheet" href="css/index1.css">
<link href="https://fonts.googleapis.com/css?family=Lato&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Gugi&display=swap" rel="stylesheet">
<style>
/* Center the loader */
#loader {
  position: absolute;
  left: 50%;
  top: 50%;
  z-index: 1;
  width: 150px;
  height: 150px;
  margin: -75px 0 0 -75px;
  border: 16px solid #f3f3f3;
  border-radius: 50%;
  border-top: 16px solid #3498db;
  width: 120px;
  height: 120px;
  -webkit-animation: spin 2s linear infinite;
  animation: spin 2s linear infinite;
  }
  
  @-webkit-keyframes spin {
  0% { -webkit-transform: rotate(0deg); }
  100% { -webkit-transform: rotate(360deg); }
  }
  
  @keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
  }
  
  /* Add animation to "page content" */
  .animate-bottom {
  position: relative;
  -webkit-animation-name: animatebottom;
  -webkit-animation-duration: 1s;
  animation-name: animatebottom;
  animation-duration: 1s
  }
  
  @-webkit-keyframes animatebottom {
  from { bottom:-100px; opacity:0 } 
  to { bottom:0px; opacity:1 }
  }
  
  @keyframes animatebottom { 
  from{ bottom:-100px; opacity:0 } 
  to{ bottom:0; opacity:1 }
  }
  
  #myDiv {
  display: none;
  text-align: center;
  }
  
  
  #hideme {
  -moz-animation: cssAnimation 0s ease-in 3s forwards;
  /* Firefox */
  -webkit-animation: cssAnimation 0s ease-in 3s forwards;
  /* Safari and Chrome */
  -o-animation: cssAnimation 0s ease-in 3s forwards;
  /* Opera */
  animation: cssAnimation 0s ease-in 3s forwards;
  -webkit-animation-fill-mode: forwards;
  animation-fill-mode: forwards;
  }
  @keyframes cssAnimation {
  to {
  width:0;
  height:0;
  overflow:hidden;
  }
  }
  @-webkit-keyframes cssAnimation {
  to {
  width:0;
  height:0;
  visibility:hidden;
  }
  }
  .ini{
	  color:#fff;
	  font-family: "Gugi",cursive;
  }
  #myback{
	  display:none;
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
	<body onload="myFunction()" style="margin:0;background-color: rgb(204, 242, 255);">
  <div id="loader">
  </div>
  <div id="hideme">
  <h1 class="ini"><big>Transaction under process....</big></h1>
  </div>
  <div style="display:none;" id="myDiv" class="animate-bottom">
    <h1 class="ini"><strong><?= $msg ?></strong></h1>
	<h3><?= $message ?></h3><br>
	<br>
  <br>
  <img src="img/A2.gif"></img>
  </div>
  <div id="myback">
		<p>Do you Want to Print Receipt?</p>
		<p><a href="menu.php"><span>Yes</span></a><a href="menu.php"><span>No</span></a></p>
	</div>
  
  <script>
  var myVar;
  
  function myFunction() {
  myVar = setTimeout(showPage, 3000);
  }
  
  function showPage() {
  document.getElementById("loader").style.display = "none";
  document.getElementById("myDiv").style.display = "block";
  document.getElementById("myback").style.display = "block";
  }
  </script>
	
	</body>

</html>
