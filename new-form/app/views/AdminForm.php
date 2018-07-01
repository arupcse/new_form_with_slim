<?php
// echo "<pre>";
// echo "Admin List: " . print_r($data['admin_list'], TRUE);
// echo "</pre>";

?>

<h1><?php echo $form_title_admin; ?></h1>

<p class="key">
	Fileds marked with an <span><img src="/images/icons/asterisk.gif" alt="img-asterisk"></span> are mandatory
</p>
<form action=""  method="post" name="adminForm" id="standard" enctype="multipart/form-data" accept-charset="utf-8">

	<h4>Section Title</h4>
	<p>
		This is breif description of this section
	</p>
	<fieldset>
		<label class="mandatory" for = "users">Users:</label>

		<div class="field">
			<select name = "users" id = "users">
				<option value="">&#91;Please Select&#93;</option>
				<?php foreach ($data['admin_list'] as $key => $value): ?>
					<option value = "<?php echo $value;?>"><?php echo $key; ?></option>
				<?php endforeach; ?>
			</select>
			<br/>
			<label class="error" for = "users"><?php echo (!is_null($data['invalid_email'])) ? $data['invalid_email'] : ''; ?></label>
		</div>
	</fieldset>
	<div class="submit">
		<input type="submit" id="continue_button" name="continue_button" value="continue">
	</div>
</form>
