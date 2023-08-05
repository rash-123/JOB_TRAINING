<!DOCTYPE html>
<html>

<head>
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
  <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
  <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
</head>

<body>
  <center>
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
      exit("Connection failed: " . $conn->connect_error);
    }

    // Open the CSV file
    $file = fopen("testFile.csv", "r");
    echo "<div>";
    echo "<table id='example' class='display' style='width:100%'>\n";
    echo "<thead><tr><th>name</th><th>id</th><th>email</th><th>pass</th><th>auth</th><th>Action</th></tr></thead><tbody>";

    // Skip the header row
    fgetcsv($file);

    // Fetching data from the CSV file row by row
    while (($data = fgetcsv($file)) !== false) {
      // Escape data to prevent SQL injection
      $name = mysqli_real_escape_string($conn, $data[0]);
      $id = mysqli_real_escape_string($conn, $data[1]);
      $email = mysqli_real_escape_string($conn, $data[2]);
      $pass = mysqli_real_escape_string($conn, $data[3]);
      $auth = mysqli_real_escape_string($conn, $data[4]);

      // Insert data into the database table
      $sql = "INSERT INTO employeedb1 (name, id, email, pass, auth) VALUES ('$name', '$id','$email', '$pass', '$auth')";
      if ($conn->query($sql) === true) {
        // Data inserted successfully
        echo "<tr>";
        foreach ($data as $i) {
          echo "<td>" . htmlspecialchars($i) . "</td>";
        }
        echo "<td><button href='edit.php' class='edit-button'>Edit</button> <button class='delete-button' data-id='$id'>Delete</button></td>";
        echo "</tr> \n";
      } else {
        // Error inserting data
        echo "Error: " . $sql . "<br>" . $conn->error;
      }
    }

    // Closing the file
    fclose($file);

    // Close the database connection
    $conn->close();

    echo "\n</tbody></table>";
    echo "</div>";
    ?>
  </center>
</body>

<script>
 $(document).ready(function() {
    var table = $('#example').DataTable({
        info: false,
        ordering: false,
        paging: false
    });

    // Event handler for the "Delete" button click
    table.on('click', '.delete-button', function(e) {
        var row = $(this).closest('tr');
        var idToDelete = $(this).data('id'); // Get the ID from data-id attribute

        // Perform the delete operation using AJAX
        $.ajax({
            url: 'delete_record.php',
            type: 'POST',
            dataType: 'json',
            data: { id: idToDelete },
            success: function(result) {
                // Remove the row from the DataTable
                row.remove().draw(false);
            },
            error: function(error) {
                alert("Error deleting record: " + error);
            }
        });
    });

    table.on('click', '.edit-button', function(e) {
        var row = $(this).closest('tr');
        var data = table.row(row).data();
        var idToEdit = data[1]; // Assuming the 'id' column is at index 1
        // Redirect to the edit.php page with the ID as a parameter
        window.location.href = 'edit.php?id=' + idToEdit;
    });

});

</script>


</html>
