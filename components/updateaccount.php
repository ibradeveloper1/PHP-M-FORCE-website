<?php 

session_start();
$con = mysqli_connect('localhost', 'root', '', 'custlogin');

//one issue with this is it will have to either update all fields or it will only update only one field...!
if(isset($_POST['submit'])){
	//creating php variables that are equal to the form input field names.
	$email = $_POST['email'];
	$username = $_POST['username'];
	$firstname =$_POST['fname'];
	$lastname = $_POST['lname'];
	$companyname = $_POST['company-name'];
	$phone = $_POST['phone'];
	$street = $_POST['street'];
	$streetnumber = $_POST['streetnumber'];
	$city = $_POST['city'];
	$province = $_POST['province'];
	$postalcode = $_POST['postalcode'];
	$unit = $_POST['unit'];
	//selecting the email 
	//$mysql = "select cust_fname, cust_lname from customers where cust_email = '$email'";
	$mysql = "select * from customers where cust_email = '$email'";
	//setting the query
	$query = mysqli_query($con,$mysql);
	//running the querey
	$row = mysqli_num_rows($query);
	//if email does not exists then create user else redirect to s
	if($row == 1){

		//$sql = "delete from customers where cust_email = '$email' and cust_password = '$password'";
		$sql = "update customers set cust_fname = '$firstname', cust_lname = '$lastname', cust_email = '$email', cust_username = '$username' , cust_company = '$companyname' ,cust_phone = '$phone', street = '$street', street_number = '$streetnumber', city = '$city', province = '$province', postal_code = '$postalcode', unit = '$unit'  where cust_email = '$email'";

		//excutes the sql querey above
		mysqli_query($con,$sql);
		header("location: ../views/loggedinpage.php");
			
	}else{
			header("location: ../views/updateaccount.php?error=failed");
		}
	
}

?>