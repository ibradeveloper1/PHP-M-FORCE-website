<?php 

if(isset($_POST["reset-password-submit"])){

	$selector = $_POST["selector"];
	$validator = $_POST["validator"];
	$password = $_POST["pwd"];
	$passwordRepeat = $_POST["pwd-repeat"];

	 if (empty($password) || empty($passwordRepeat)){

        header("location: ../views/create-password.php");exit();
      }else if($password != $passwordRepeat){

		header("location: ../views/loginpage.php?newpwd=pwdnptsame");
		exit();
}

//getting current date
$currentDate = date("U");

// connection string
$con = mysqli_connect('localhost', 'root','','custlogin');

$sql = "select * from pwdreset where pwdResetSelector=? and pwdResetExpires >= ?";

	$stmt = mysqli_stmt_init($con);
	if(!mysqli_stmt_prepare($stmt, $sql)){
		echo "There was an error!";
		exit();
	}else{
		mysqli_stmt_bind_param($stmt, "ss", $selector, $currentDate);
		// this line will run the sql stmt variable.
		mysqli_stmt_execute($stmt);

		$result = mysqli_stmt_get_result($stmt);
		if(!$row = mysqli_fetch_assoc($result)){
			echo "You need to re-submit your reset request.";
			exit();
		}else{
			$tokenBin = hex2bin($validator);
			$tokenCheck = password_verify($tokenBin, $row["pwdResetToken"]);

			if($tokenCheck === false){
				echo "You need to re-submit your reset request";
			}else if($tokenCheck === true){
				$tokenEmail = $row["pwdResetEmail"];

				$sql = "select * from customers where cust_email = ?";
				$stmt = mysqli_stmt_init($con);
				if(!mysqli_stmt_prepare($stmt, $sql)){
					echo "There was an error!";
					exit();
				}else{
					mysqli_stmt_bind_param($stmt, "s", $tokenEmail);
					mysqli_stmt_execute($stmt);
					$result = mysqli_stmt_get_result($stmt);
					if(!$row = mysqli_fetch_assoc($result)){
						echo "There was an error!";
						exit();
					}else{

						$sql = "update customers set cust_password=? where cust_email=?";
						$stmt = mysqli_stmt_init($con);
						if(!mysqli_stmt_prepare($stmt, $sql)){
							echo "There was an error!";
							exit();
						}else{
							$newPwdHash = password_hash($password, PASSWORD_DEFAULT);
							mysqli_stmt_bind_param($stmt, "ss", $newPwdHash, $tokenEmail);
							mysqli_stmt_execute($stmt);

							$sql = "delete from pwdReset where pwdResetEmail=?";
							$stmt = mysqli_stmt_init($conn);
							if(!myswli_stmt_prepare($stmt, $sql)){
								echo "There was an error!";
								exit();
							}else{
								myswli_stmt_bind_param($stmt, "s", $tokenEmail);
								mysqli_stmt_execute($stmt);
								header("location: ../signuppage.php?newpwd=passwordupdated");
							}
						}
					}
				}
			}
		}
	}

}else{
	header("location: ../views/loginpage.php?newpwd=empty");
	
}

?>