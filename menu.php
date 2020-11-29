<?php

session_start(); #Session Creation : line was commented earlier ,

$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "ATM_System";

$conn = new mysqli($dbhost, $dbuser, $dbpass,$dbname);

//include ("connect.php") ;
//include ("user_login.php") ;
global $AccountNo;
$AccountNo = $_SESSION['acc_no'] ;

global $Balance;
global $Customer_Name;
global $Contact_No;

$sql_select = "SELECT `AccountNo`,`CustomerName`,`PIN`,`MobileNo`,`Balance` FROM `Customers` WHERE `AccountNo` = '$AccountNo'" ;
$sql_select_result = $conn->query($sql_select);

#$sql = "SELECT Account_No, Customer_Name, Balance, Contact_No FROM User_data WHERE Account_No = '$acc_no'"; #MySQL Query
#$query_run = mysql_query($sql) ;
#$row = $result_sql1->fetch_assoc()

while($row = $sql_select_result->fetch_assoc()){
	#Fetch the customer name
	$cust_name = $row['CustomerName'];
	global $Customer_Name ;
	$Customer_Name = $cust_name ;

	#Fetch the Account Balance
	$bal = $row['Balance'];
	global $Balance ;
	$Balance = $bal ;

	#Fetch the Contact Details
	$contact = $row['MobileNo'];
	global $Contact_No;
	$Contact_No = $contact;

}

?>

<!DOCTYPE html>
<html>
<head>
	<title>ATM</title>
	<link href="https://fonts.googleapis.com/css?family=Lato&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Gugi&display=swap" rel="stylesheet">

<style>

body
{
	background-color: #F0F0F0;
	background-image:url("img/front.jpg");
	width:100%;
	background-size:100%;
	font-family:lato;
}
h1 
{
	font-family:"Gugi",cursive;
	color:#fff;
}
	
.User_Table
{
	height: 200px;
	width:  70%;
	position: relative;
	left: 15%;
	
}

td{
	font-family:lato;
	background-color:#fff;
	text-align:center;
}

.Logout
{
	height: 30px;
	width: 5%;
	position: absolute;
	left: 80%;
	background-color: #4CAF50;
	border-radius: 10px;
	color: white;
}

.Withdraw
{
	height: 70px;
	width: 20%;
	position: relative;
	left: 10%;
	background-color: #4CAF50;
	border-style: solid;
	border-radius: 10px;
	border-color: white;
	text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 25px;
    color: white;
}

.Withdraw:hover
{
	background-color: green;
	cursor: pointer;
}

.Deposit
{
	height: 70px;
	width: 20%;
	position: relative;
	left: 10%;
	background-color: #4CAF50;
	border-style: solid;
	border-radius: 10px;
	border-color: white;
	text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 25px;
    color: white;
}

.Deposit:hover
{
	background-color: green;
	cursor: pointer;
}

.History
{
	height: 70px;
	width: 20%;
	position: relative;
	left: 10%;
	background-color: #4CAF50;
	border-style: solid;
	border-radius: 10px;
	border-color: white;
	text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 25px;
    color: white;
}

.History:hover
{
	background-color: green;
	cursor: pointer;
}

.Pin_Change
{
	height: 70px;
	width: 20%;
	position: relative;
	left: 10%;
	background-color: #4CAF50;
	border-style: solid;
	border-radius: 10px;
	text-align: center;
    text-decoration: none;
	border-color: white;
    display: inline-block;
    font-size: 25px;
    color: white;
}

.Pin_Change:hover
{
	background-color: green;
	cursor: pointer;
}


.Current_Balance
{
	height: 70px;
	width: 30%;
	position: relative;
	left: 35%;
	top: 10%;
	background-color: #4CAF50;
	color: white;
	font-size: 25px;
	border-style: solid;
	border-radius: 10px;
	text-align: center;
    text-decoration: none;
	border-color: white;
    display: inline-block;
    border-style: solid;
    border-radius: 10px;
}

.Current_Balance:hover
{
	background-color:green;
	cursor:pointer;
}


</style>

</head>
<body>

<button class="Logout"><a href = "logout.php" style="text-decoration:none;"><font style="color:white ;">Logout</font></a></button>

<h1 align="center">
<u>Welcome </u>
</h1>
<br>
<br>

<!--Tabular Representation of Customer Details-->
<table class="User_Table" border="4px">
<tr>
<td><b>Account Number  </b></td>
<td><?php echo $AccountNo ; ?></td>
</tr>
<tr>
	
<td><b>Customer Name  </b></td>
<td><?php echo $Customer_Name ; ?></td>

</tr>
<tr>

<td><b>Contact Number  </b></td>

<td><?php echo $Contact_No ; ?> </td>

</tr>
</table>

<br>
<br>

<a href="withdraw.html"><button class = "Withdraw">Withdraw Amount</button></a>
<a href="deposit.html"><button class = "Deposit">Deposit Amount</button></a>
<a href="transaction.php"><button class = "History">Transaction History</button></a>
<a href="pinChange.html"><button class = "Pin_Change">Pin Change</button></a>;

<br>
<br>
<a href="Enquiry.php"><button class = "Current_Balance">Balance Enquiry</button></a>

</body>
</html>
