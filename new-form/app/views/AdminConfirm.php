
<form action=""  method="post" name="adminFormConfirm" id="standard" enctype="multipart/form-data" accept-charset="utf-8">

    <input type="hidden" name="useremail" value="<?php echo $data['users']?>">
    <h4>Confirm</h4>
    <p>
        An emal is about to sent to <?php echo $data['users']?>
    </p>
    <p>
        Do you wish to continue?
    </p>
    <div class="submit">
        <!--<input type="button" id="cancel_button" name="cancel_button" value="cancel" onclick="window.location='/legacy-form-demo/public/admin'">-->
        <input type="submit" id="cancel_button" name="cancel_button" value="cancel">
        <input type="submit" id="submit_button" name="submit_button" value="submit">
    </div>
</form>
