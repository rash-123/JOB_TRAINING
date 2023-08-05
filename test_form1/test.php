<!DOCTYPE html>
<html>

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
        $file = fopen("testfile1.csv", "r");
        echo "<table border=2>\n";
        echo "<tr><th>sno</th><th>Account</th></tr>";

        // Skip the header row
        fgetcsv($file);

        // Prepare the INSERT statement
        $stmt = $conn->prepare("INSERT INTO employeedb2 (sno, account) VALUES (?, ?)");

        // Bind parameters to the prepared statement
        $stmt->bind_param("ss", $sno, $account);

        // Fetching data from the CSV file row by row
        while (($data = fgetcsv($file)) !== false) {
            // Escape data to prevent SQL injection
            $sno = mysqli_real_escape_string($conn, $data[0]);
            $account = mysqli_real_escape_string($conn, $data[1]);

            // Execute the prepared statement
            if ($stmt->execute()) {
                // Data inserted successfully
                echo "<tr>";
                foreach ($data as $i) {
                    echo "<td>" . htmlspecialchars($i) . "</td>";
                }
                echo "</tr> \n";
            } else {
                // Error inserting data
                echo "Error: " . $stmt->error;
            }
        }

        // Closing the file
        fclose($file);

        // Close the prepared statement
        $stmt->close();

        // Close the database connection
        $conn->close();

        echo "\n</table>";
        ?>
    </center>
</body>

</html>
