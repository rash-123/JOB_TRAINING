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

        // Accounts to get the count for
        $accounts = array(
            "shashank.tiwari@aspolmedia.com",
            "2@asp.com",
            "3@asp.com",
            "4@asp.com",
            "5@asp.com",
            "6@asp.com",
            "7@asp.com",
            "8@asp.com"
        );

        // Start the HTML table
        echo "<table border=2>\n";
        echo "<tr><th>Account</th><th>Name Count</th></tr>";

        // Loop through each account and get the count using JOIN
        foreach ($accounts as $account) {
            // Escape data to prevent SQL injection
            $escaped_account = mysqli_real_escape_string($conn, $account);

            // Fetch data from the database table using JOIN and COUNT
            $sql = "SELECT employeedb2.account, COUNT(employeedb1.name) AS name_count FROM employeedb1 INNER JOIN employeedb2 ON employeedb1.account = employeedb2.account WHERE employeedb2.account = '$escaped_account'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $name_count = $row["name_count"];
                $account = $row["account"];
            } else {
                $name_count = 0;
            }

            // Display the account and name count in the HTML table
            echo "<tr>";
            echo "<td>" . htmlspecialchars($account) . "</td>";
            echo "<td>" . htmlspecialchars($name_count) . "</td>";
            echo "</tr>";
        }

        // Close the HTML table
        echo "</table>";

        // Close the database connection
        $conn->close();
        ?>
    </center>
</body>

</html>
