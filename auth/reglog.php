<?php

require_once('database.php');

// Database credentials - to be specified
$username = "root";
$password = "jahiro7113";
$database = "tyuiu";


// Establish connection with the database
$db = new Database($username, $password, $database);

// Login cookie name
$cookie_name = "islogged";

// Check whether we are logging in or registering
if(isset($_POST['login']))
{

    $user = $_POST['username'];
    $pass = $_POST['password'];

    // Checking if username and password match something in the database
    if($db->checklogin($user, $pass)) {
        // Setting an islogged cookie with the value of username for 30 days
        setcookie($cookie_name, $user, time()+60*60*24*30);
    }

}
// If we're registering, do it
else if(isset($_POST['register']))
{
    $user = $_POST['username'];
    $pass = $_POST['password'];
    
    // Adding a record into the database
    $db->adduser();
}

?>
