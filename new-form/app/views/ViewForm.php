<?php

if(!empty($data)){
    // Display data in a table
    echo '<table border = "1" cellpadding = "5" cellspacing = "0" >';
    foreach ($data[0] as $key => $value) {
        $row_content = strpos($value, '|') > 0 ? str_replace("|", "<br/>",$value) : $value;
        echo "<tr><th>".$key."</th><td>". $row_content . "</td></tr>";
    }
    echo "</table>";
}
// echo "<pre>";
// echo "Inv Detail:" . print_r($data, TRUE);
// echo "</pre>";
