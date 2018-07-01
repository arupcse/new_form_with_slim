<?php

// echo "<pre>";
// echo "email error:" . print_r($data['email_error'], TRUE);
// echo "</pre>";
?>
<h4><a href= "">Go Back</a></h4>
<h3>There was an error in sending the email</h3>
<p>
    <?php
    if (!empty($data['email_error'])) {
        foreach ($data['email_error'] as $key => $value) {
           echo $key." : ".$value. "<br/>";
       }
    }
    ?>
</p>
