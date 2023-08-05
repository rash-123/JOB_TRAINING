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

//create a table in the db
$sql = "CREATE TABLE `employeedb2` (`sno` INT(60) NOT NULL AUTO_INCREMENT, `name` VARCHAR(255) NOT NULL, `id` VARCHAR(100) NOT NULL, `email` VARCHAR(255) NOT NULL, `pass` VARCHAR(255) NOT NULL, `auth` VARCHAR(255) NOT NULL,`date` INT(60), PRIMARY KEY (`sno`))";

//create a table creation success
$result = mysqli_query($conn, $sql);


?>