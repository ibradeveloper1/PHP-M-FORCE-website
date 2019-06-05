<?php

if(isset($_POST['recovery-submit'])){

	//this variable will change from bytes to hex with random characters.
	$selector = bin2hex(random_bytes(8));
	//this token variable will athenicate the user
	$token = random_bytes(32);

	//this link will be send to the email.
	$url = "localhost/LoginandSignup/views/create-password.php?selector=" . $selector . "&validator=" . bin2hex($token);

	//this will set the timer for the token
	$expires = date("U") + 1800;
	//mysql connection to database
	$con = mysqli_connect('localhost', 'root','','custlogin');

	//this will grab the name email form the form
	$email = $_POST["email"];

	$sql = "select * from customers where cust_email = '$email'";
	$query = mysqli_query($con,$sql);
	$row = mysqli_num_rows($query);
	//if the email is the correct email registered to this site it will run this if statement else it will do nothing.
		if($row != 1){
			header("location: ../views/forgotpass.php?reset=failed");
		}else{

	$sql = "delete from pwdreset where pwdResetEmail=?;";
	$stmt = mysqli_stmt_init($con);
	if(!mysqli_stmt_prepare($stmt, $sql)){
		echo "There was an error!";
		exit();
	}else{
		mysqli_stmt_bind_param($stmt, "s", $email);
		// this line will run the sql stmt variable.
		mysqli_stmt_execute($stmt);
	}

	$sql = "insert into pwdReset (pwdResetEmail, pwdResetSelector, pwdResetToken, pwdResetExpires) values(?,?,?,?);";
	$stmt = mysqli_stmt_init($con);
	if(!mysqli_stmt_prepare($stmt, $sql)){
		echo "There was an error!";
		exit();
	}else{
		// this line is hashing the token so it has more security
		$hashedToken = password_hash($token, PASSWORD_DEFAULT);
		//these are the values being inserted into the database
		mysqli_stmt_bind_param($stmt, "ssss", $email, $selector, $hashedToken, $expires);
		// this line will run the sql stmt variable.
		mysqli_stmt_execute($stmt);
	}

	mysqli_stmt_close($stmt);
	mysqli_close($con);

	// this will send the email
	$to = $email;
	$subject = 'Reset your password for group login project';
	$message = '<p>We recieved a password reset request. The link to reset your password is below. If you did not make this request, Please ignore this email.</p>';
	$message .= '<p>Here is your password reset link: <br/>';
	$message .= ' <a hre="'. $url. '">'. $url .'</a></p>';

	$headers = "From: Grouplogin <umarsyed080597@gmail.com>\r\n";
	$headers .= "Reply-To: umarsyed080597@gmail.com\r\n";
	//*******this line is very important for html to work in side the email sent like the href****!!!!1
	$headers .= "Content-type: text/html\r\n";

	mail($to, $subject, $message, $headers);
	header("location: ../views/forgotpass.php?reset=success");
}

}
else{
	header("location: ../views/forgotpass.php");
}

?>