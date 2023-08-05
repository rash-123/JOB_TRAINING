<?php
echo "connecting the database <br>";

$servername = "localhost";
$username = "root";
$password = "Ask4priyesh88#";
$database = "testdb";

$conn = musqli_connect($servername, $username, $password, $database);

if(!$conn){
    exit("sorry we failed to connect" . mysqli_connect_error());
}
else{
    echo "connection was successful";
}

$sql = "CREATE TABLE table1(`sno` INT NOT NULL AUTO_INCREMENT, `name` VARCHAR(255) NOT NULL, `id` INT(60) NOT NULL, `email` VARCHAR(255) NOT NULL, `pass` VARCHAR(255) NOT NULL, `auth` VARCHAR(255) NOT NULL, `date` NOT NULL DEFAULT TIMESTAMP, PRIMARY KEY(sno))";

$result = mysquli_query($conn, $sql);

if($result) {
    echo "the table was created successfully!<br>";
}
else{
    echo "the table was not created successfully because of this error". mysqli_error($conn);
}

?>