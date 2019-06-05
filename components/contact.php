<?php
session_start();

require_once '../lib/assets/phpmailer/PHPMailerAutoload.php';

$errors = [];

if(isset($_POST['name'], $_POST['email'], $_POST['message'])){
    $fields = [
        'name' => $_POST['name'],
        'email' => $_POST['email'],
        'message' => $_POST['message']
    ];

    foreach($fields as $field => $data){
        if(empty($data)){
            $errors[] = 'The '.$field.' field is required.';
        }
    }

    if(empty($errors)){
        $m = new phpmailer;
        $m->SMTPDebug = 2;
        
        $m->isSMTP();
        $m->SMTPAuth = true;
        $m->Host = 'smtp.gmail.com';
        $m->Username = 'umarsyed080597@gmail.com';
        $m->Password = 'Sundayfunday1';
        $m->SMTPSecure = 'ssl';
        $m->Port = 465;

        $m->isHTML(true);

        $m->Subject = 'Contact form submmited';
        $m->Body = 'From: '.$fields['name'].' ('.$fields['email'].')<p>'.$fields['message'].'</p>';

        $m->From = 'umarsyed080597@gmail.com';
        $m->FromName = 'Contact';

        $m->AddAddress('umarsyed080597@gmail.com', 'umar syed');

        if($m->send()){
            header('Location: ../views/thanks.php');
        }else{
            echo("failed");
        }
    }

}else{
    $errors[] = 'something went wrong.';
}

$_SESSION['errors'] = $errors;
$_SESSION['fields'] = $fields;
?>