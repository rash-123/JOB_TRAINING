<!DOCTYPE html>
<html>

<body>
	<center>

		<?php
		
		echo "<html><body><center><table border=2>\n\n";

		// Open a file and mode
		$file = fopen("testFile.csv", "r");
        echo "<tr><th>name</th><th>age</th><th>email</th><th>id</th><th>pass</th>";
		// Fetching data from csv file row by row
		while (($data = fgetcsv($file)) !== false) {

			// HTML tag for placing in row format
			echo "<tr>";
			foreach ($data as $i) {
				echo "<td>" . htmlspecialchars($i)
					. "</td>";
			}
			echo "</tr> \n";
		}

		// Closing the file
		fclose($file);

		echo "\n</table></center></body></html>";
		?>
	</center>
</body>

</html>


