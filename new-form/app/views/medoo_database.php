<h1> Fetched Data </h1>

<?php

	$table_headers = array();
	// $innerArray = $medoo_message[0];

	foreach ($medoo_message[0] as $key => $value) {
		if (!in_array($key, $table_headers)) {
			array_push($table_headers, $key);
		}
	}
	// echo "<pre>";
	// echo "table headerss:" . print_r($table_headers, TRUE);
    // echo "</pre>";

		echo '<table border = "1" cellpadding = "5" cellspacing = "0" >'
			 ."<tr>";
			 foreach ($table_headers as $headers) {
			 	echo "<th>" . $headers . "</th>";
			 }
		echo "<th colspan=2>Action</th>"
			 ."</tr>";

		foreach ($medoo_message as $innerArray) {
			echo "<tr>";
			foreach ($innerArray as $key => $value) {
				echo "<td>". $value . "</td>";
				if ($key == 'id') {
					$row_id = $value;
				}
			}
			echo "<td><a href = 'form/". $row_id. "/view'>View </a></td>"
				."<td><a href = 'form/". $row_id. "/delete'>Delete </a></td>"
				."</tr>";
		}
		echo "</table>";
	// echo "<pre>";
	// echo "meddo_select_message:" . print_r($medoo_message, TRUE);
    // echo "</pre>";
