<?php

public class Database
{
    protected $conn;

    public function __construct($username, $password, $dbname) {
        // Establish connection with the database
        $this->$conn = mysqli_connect("localhost", $username, $password, $dbname);
        
        // Die if something goes wrong
        if(!$this->$conn) {
            die("Database connection failure.\nError: ".mysqli_connect_error());
        }
    } 

    /**
     *  Adds a new user record into the database
     *      if user does not exist already
     *
     *  @param string $username User preferred username
     *  @param string $password User password  
     */
    public function adduser($username, $password) {
        if(!user_exists($username)) {
            // Encrypting the password
            $phash = sha1(sha1($password."brent")."brent");
            $sql = "insert into users (id, username, password) values ('', '$username', '$phash');";
            $result = mysqli_query($this->$conn, $sql);
        }
    }

    private function user_exists($username) {
        $sql = "select * from users where username='$user';";
        $result = mysqli_query($conn, $sql);
        $count = mysqli_num_rows($result);

        return (count > 0) ? true : false;
    }
}

?>