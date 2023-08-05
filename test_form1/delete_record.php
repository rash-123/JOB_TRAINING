<?php
// Database connection parameters
$servername = "localhost";  // Change this to your database server
$username = "root";  // Change this to your database username
$password = "Ask4priyesh88#";  // Change this to your database password
$dbname = "testdb";  // Change this to your database name

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Check if the ID parameter is provided via POST request
if (isset($_POST['id'])) {
  // Escape the ID to prevent SQL injection
  $idToDelete = mysqli_real_escape_string($conn, $_POST['id']);

  // Prepare the SQL query to delete the record
  $sql = "DELETE FROM employeedb1 WHERE id = '$idToDelete'";

  // Execute the query
  if ($conn->query($sql) === true) {
    // Return a success message
    echo json_encode(['status' => 'success']);
  } else {
    // Return an error message
    echo json_encode(['status' => 'error', 'message' => 'Error deleting record: ' . $conn->error]);
  }
} else {
  // Return an error message if the ID parameter is not provided
  echo json_encode(['status' => 'error', 'message' => 'ID parameter is missing']);
}

// Close the database connection
$conn->close();
?>
