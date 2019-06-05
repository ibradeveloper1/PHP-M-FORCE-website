<?php
//all this does is opens the session then destroys it so we can not go back.
session_start();
session_destroy();
header('location: ../views/loginpage.php');

?>