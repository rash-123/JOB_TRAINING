<?php
echo "connecting to the database <br>";

/*ways to connect a mysql database
1. mysqli extension
2. pdo - php data object
*/

//connecting to the database
$servername = "localhost";
$username = "root";
$password = "Ask4priyesh88#";
$db = "testdb";

//create a connection object

$conn = mysqli_connect($servername, $username, $password,$db);

//die if connection was not successful
if(!$conn){
    exit("sorry we failed to connect: ". mysqli_connect_error());
}
else{
    echo "connection was successful";
}
?>