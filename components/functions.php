<?php


//gets the data for each user and puts it in an array for later use.
function getUsersData($id){
	$con = mysqli_connect('localhost', 'root', '', 'custlogin');
	$array = array();
	$q = "select * from customers where cust_ID = '$id'";
	$query = mysqli_query($con,$q);
	$row = mysqli_num_rows($query);
	while($r = mysqli_fetch_assoc($query)){
		$array['cust_fname'] = $r['cust_fname'];
		$array['cust_lname'] = $r['cust_lname'];
		$array['cust_email'] = $r['cust_email'];
		$array['cust_username'] = $r['cust_username'];
		$array['cust_company'] = $r['cust_company'];
		$array['cust_phone'] = $r['cust_phone'];
		$array['street_number'] = $r['street_number'];
		$array['street'] = $r['street'];
		$array['city'] = $r['city'];
		$array['province'] = $r['province'];
		$array['postal_code'] = $r['postal_code'];
		$array['unit'] = $r['unit'];

	}
	return $array;
}

//this will get the id for the user

function getId($email){
	$con = mysqli_connect('localhost', 'root', '', 'custlogin');
	$q = "select cust_ID from customers where cust_email = '$email' or cust_username = '$email'";
	$query = mysqli_query($con,$q);
	$row = mysqli_num_rows($query);
	while($r = mysqli_fetch_assoc($query)){
		return $r['cust_ID'];
	}
}

function getId2($username){
	$con = mysqli_connect('localhost', 'root', '', 'custlogin');
	$q = "select cust_ID from customers where cust_username = '$username'";
	$query = mysqli_query($con,$q);
	$row = mysqli_num_rows($query);
	while($r = mysqli_fetch_assoc($query)){
		return $r['cust_ID'];
	}
}
?>