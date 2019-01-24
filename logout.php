<?php
require_once("include/session.php");
require_once ("include/function.php");

$_SESSION['User_Id'] = NULL;
session_destroy();
redirect_to('login.php');