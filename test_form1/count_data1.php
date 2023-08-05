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
            die("Connection failed: " . $conn->connect_error);
        }

        // Fetch data from the database table using JOIN operation
        $sql = "SELECT employeedb1.sno, employeedb1.name, employeedb1.id, employeedb1.account, employeedb1.pass, employeedb1.auth, employeedb1.date, employeedb2.account FROM employeedb1 INNER JOIN employeedb2 ON employeedb1.account = employeedb2.account";

        $count =  "";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Start the HTML table
            echo "<table border=2>\n";
            echo "<tr><th>SNO</th><th>NAME</th><th>ID</th><th>EMAIL</th><th>PASS</th><th>AUTH</th><th>DATE</th><th>Account</th></tr>";

            // Output data of each row
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row["sno"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["name"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["id"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["email"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["pass"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["auth"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["date"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["account"]) . "</td>";
                echo "</tr>";
            }

            // Close the HTML table
            echo "</table>";
        } else {
            echo "0 results";
        }

        // Close the database connection
        $conn->close();
        ?>
    </center>
</body>

</html>
