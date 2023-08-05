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
		echo "<tr><th>Account</th></tr>";

		// Skip the header row
		fgetcsv($file);

		// Fetching data from the CSV file row by row
		while (($data = fgetcsv($file)) !== false) {
			// Escape data to prevent SQL injection
			$account = mysqli_real_escape_string($conn, $data[0]);
			

			// Insert data into the database table
			$sql = "INSERT INTO employeedb2 (account) VALUES ('$account')";
			if ($conn->query($sql) === true) {
				// Data inserted successfully
				echo "<tr>";
				foreach ($data as $i) {
					echo "<td>" . htmlspecialchars($i) . "</td>";
				}
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

		echo "\n</table>";
		?>
	</center>
</body>

</html>
