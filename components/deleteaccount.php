<?php

session_start();

//connection to database
$con = mysqli_connect('localhost', 'root', '', 'custlogin');

if(isset($_POST['submit'])){
	//creating php variables that are equal to the form input field names.
	$email = $_POST['email'];
	$password = $_POST['password'];
	$confirmpassword = $_POST['confirmpassword'];
	//selecting the email 
	$mysql = "select * from customers where cust_email = '$email'";
	//setting the query
	$query = mysqli_query($con,$mysql);
	//running the querey
	$row = mysqli_num_rows($query);
	//if email does not exists then create user else redirect to s
	if($row == 1){

		if($password == $confirmpassword){
			//selects email and password from the customers table
			$sql = "delete from customers where cust_email = '$email' and cust_password = '$password'";

			//excutes the sql querey above
			mysqli_query($con,$sql);
			header("location: ../views/loginpage.php");
			
		}else{
			header("location: ../views/deleteaccount.php?delete=failed");
		}
	}else{
			header("location: ../views/deleteaccount.php?delete=failed");
		}
	
}

?>