<?php 


session_start();

//connection string
$db = mysqli_connect("localhost","root","","custlogin");

//if the signuppage.php form is submited
if(isset($_POST['submit'])){
	//creating php variables that are equal to the form input field names.
	$firstname =$_POST['fname'];
	$lastname = $_POST['lname'];
	$email = $_POST['email'];
	$username = $_POST['username'];
	$password = $_POST['password'];
	$confirmpassword = $_POST['confirm-password'];
	$companyname = $_POST['company-name'];
	$phone = $_POST['phone'];
	$street = $_POST['street'];
	$streetnumber = $_POST['streetnumber'];
	$city = $_POST['city'];
	$province = $_POST['province'];
	$postalcode = $_POST['postalcode'];
	$unit = $_POST['unit'];

	//selecting the email 
	$mysql = "select * from customers where cust_email = '$email'";
	//setting the query
	$query = mysqli_query($db,$mysql);
	//running the querey
	$row = mysqli_num_rows($query);
	//if email does not exists then create user else redirect to s
	if($row != 1){
	
	//if both passwords match
	if($password == $confirmpassword){

		//this md5 will not work because it is not able to read the parsed password back for now. but to parse the password we will need to use this variable with md5.

		///$password = md5($password);

		//sql querey for inserting into the table
		$sql = "insert into customers(cust_fname, cust_lname, cust_password, cust_email, cust_username, cust_company, cust_phone, street, street_number, city, province, postal_code, unit) values('$firstname','$lastname','$password','$email', '$username' ,'$companyname','$phone', '$street','$streetnumber','$city','$province','$postalcode','$unit')";

		mysqli_query($db, $sql);
		//if form is correct it redirects to login page up

		header("location: ../views/loginpage.php");

		
	}else{
		//if form is wrong it redirects to sign up and gives error
		header("location: ../views/signuppage.php?signup=password");
	}

}else{
	//if form is wrong it redirects to sign up and gives errors
	header("location: ../views/signuppage.php?email=alreadyexists");
}
}

?>