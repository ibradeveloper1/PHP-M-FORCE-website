<?php

session_start();

//connection to database
$con = mysqli_connect('localhost', 'root');

//this line specifes the db name
$db = mysqli_select_db($con, 'custlogin');

//if the button name submit in the views/loginpage.php is submited it runs this if statement.
if(isset($_POST['submit'])){
	//creating php variables that are equal to the form input field names.
	$email = $_POST['email'];
	$password = $_POST['password'];

	//selects email and password from the customers table
	$sql = "select * from customers where cust_email = '$email' and cust_password = '$password' or cust_username = '$email' and 
			cust_password = '$password'";

	//excutes the sql querey above
	$query = mysqli_query($con,$sql);

	//must write the querey variable inside of the $row vraiable for it to work.
	$row = mysqli_num_rows($query);
		if($row == 1){
			//if login is good it runs this
			$_SESSION['cust_email'] = $email;
			$_SESSION['cust_username'] = $username;
			$_SESSION['cust_password'] = $password;
			header('location: ../views/loggedinpage.php');
		}else{
			//if login does not work it runs this
			header('location: ../views/loginpage.php?error=loginerror');
		}
	}

?>