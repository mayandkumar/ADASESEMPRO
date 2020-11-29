function validate()
{
	<?php
	$get_atm_bal="SELECT `ATM_amount` FROM `ATM` WHERE `SNo`='1'";
	$c=$conn->query($get_atm_bal);
	$atm_bal;
	while($row=$c->fetch_assoc()){
	global $atm_bal;
	$atm_bal=$row['ATM_amount'];
	}
	?>
	var x=document.forms["myForm"]["withdraw_amount"].value;
	var y='<?php echo $atm_bal?>';
		if(x>10000)
		{
			alert("Amount must be less than or equal to 10000.");
			return false;
		}
		if(x%100!=0)
		{
			
			alert("Amount must be in multiple of 100.");
			return false;
		}
		if(x>y)
		{
			alert("Insufficient Cash in ATM.");
			return false;
		}
		return true;
}