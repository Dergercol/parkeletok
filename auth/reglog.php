<?php
/*  ПОДСКАЗКА
    В то время как функция __autoload() также может быть использована 
    для автоматической загрузки классов и интерфейсов, следует отдать 
    предпочтение spl_autoload_register(), потому, что она предоставляет
    гораздо более гибкую альтернативу, позволяя регистрировать 
    необходимое количество автозагрузчиков, например для корректной 
    работы сторонних библиотек. В связи с этим, использование 
    __autoload() не рекомендуется и она может быть объявлена устаревшей 
    в будущем.
*/
function __autoload( $className ) {
    $className = str_replace( "..", "", $className );
    require_once( "classes/$className.php" );
    echo "Loaded classes/$className.php<br>";
}

$member = new Member();
echo "Object has been created: ";

$cookie_name = "islogged";

// Database credentials - to be specified
$servername = "localhost";
$username = "root";
$password = "jahiro7113";
$database = "tyuiu";

// Establish connection with the database
$conn = mysqli_connect($servername, $username, $password, $database);
// Die if something goes wrong
if(!$conn) {
    die("Database connection failure.\nError: ".mysqli_connect_error());
}

// Check whether we are logging in or registering
if(isset($_POST['login']))
{
    $user = $_POST['username'];
    $pass = $_POST['password'];

/* 
*   Making a password to be secure!
*   Our website and user accounts must be as secure as possible
*   Those people trust us! We can't let them down, is that clear to you?
*/
    $phash = sha1(sha1($pass."brent")."brent");
    $sql = "select * from users where username='$user' and password='$phash';";

    $result = mysqli_query($conn, $sql);
    $count = mysqli_num_rows($result);

    if($count == 1)
    {
        $cookie_value = $user;
        setcookie($cookie_name, $cookie_value, time() + (60*60*24*30), "/");
        header("Location: http://www.tyuiu.ml/");
    }
    else
    {
        echo "Username or passoword is incorrect";
    }
}
// If we're registering, do it
else if(isset($_POST['register']))
{
    $user = $_POST['username'];
    $pass = $_POST['password'];

    $phash = sha1(sha1($pass."brent")."brent");

    $sql = "select * from users where username='$user';";

    $result = mysqli_query($conn, $sql);
    $count = mysqli_num_rows($result);
    
    // If this username does not exist in the database, proceed to the registration
    if($count == 0)
    {
        $sql = "insert into users (id, username, password) values ('', '$user', '$phash');";
        $result = mysqli_query($conn, $sql);
    }
    // Otherwise, throw an error to the user
    else
    {
        echo "This username was already taken.";
    }
}

?>
