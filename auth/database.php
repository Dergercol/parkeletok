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
     *      if it doesn't exist already
     *
     *  @param string $username User preferred username
     *  @param string $password User password  
     */
    public function adduser($username, $password) {
        if(!user_exists($username)) {
            // Encrypting the password
            $phash = sha1(sha1($password."brent")."brent");
            $sql = sprintf("insert into users (id, username, password) values ('', '%s', '%s', );",
                            mysqli_real_escape_string($username), 
                            mysqli_real_escape_string($phash));

            $result = mysqli_query($this->$conn, $sql);
        }
    }

    /**
     *  Matches provided credentials with the ones in the database
     *  
     *  @param string $username User provided username
     *  @param string $password User provided password
     */
    public function checklogin($username, $password) {
        $sql = sprintf("select * from users where username='%s' and password='%s';", 
                        mysqli_real_escape_string($username),
                        mysqli_real_escape_string($password));

        $result = mysqli_query($conn, $sql);
        $count = mysqli_num_rows($result);

        return ($count > 0);
    }

    public function user_exists($username) {
        $sql = sprintf("select * from users where username='%s';", 
                        mysqli_real_escape_string($user));

        $result = mysqli_query($conn, $sql);
        $count = mysqli_num_rows($result);

        return ($count > 0);
    }
}

?>