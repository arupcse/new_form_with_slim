<?php
	// echo "<pre>";
	// echo "form data:" . print_r($data['error_message_array'], TRUE);
	// echo "env var:" . print_r(phpinfo(), TRUE);
	// echo "data:" . print_r($data, TRUE);
	// echo "SERVER: " . print_r($_SERVER['HTTP_USER_AGENT'], TRUE);
	// echo "Browser: " . print_r(get_browser(null,true), TRUE);
	// echo "\nPHP_uname: " . print_r(php_uname(), TRUE);
	// echo "\nPHP_OS: " . print_r(PHP_OS, TRUE);
	// echo "</pre>";
	// $host = gethostname();
	// $ip = gethostbyname($host);
	// echo "\nSERVER HOST: ".$host;
	// echo "\nSERVER IP ADDRESS: ".$ip;
	// echo "\nSERVER['REMOTE_HOST']: ".$_SERVER['REMOTE_HOST'];

?>

<h1><?php echo $form_title; ?></h1>

<p class="key">
	Fileds marked with an <span><img src="/images/icons/asterisk.gif" alt="img-asterisk"></span> are mandatory
</p>
<form action=""  method="post" name="form" id="standard" enctype="multipart/form-data" accept-charset="utf-8">

  	<input type="hidden" name="<?php echo $csrf_name_key; ?>" value="<?php echo $cs_name; ?>">
  	<input type="hidden" name="<?php echo $csrf_value_key; ?>" value="<?php echo $cs_value; ?>">

	<h4>Text Type Group</h4>
	<p>
		This is breif description of Text Type Group
	</p>
	<fieldset>

		<label class="mandatory" for = "full_name">Full name:</label>

		<div class="field">

			<input class = "input-text" type = "text" name = "full_name" id = "full_name" size = "50" maxlength = "255"
			value="<?php echo (isset($_POST['full_name'])) ? $_POST['full_name'] : '';?>" /><br/>

			<label class="error" for = "full_name"><?php echo (!is_null($error_message_array['full_name'])) ? $error_message_array['full_name'] : ''; ?></label>

		</div>
	</fieldset>

	<fieldset>

		<label class="mandatory" for="email">Email:</label>

		<div class="field">

			<input class="input-text" type="text" name="email" id="email"
			size="50" maxlength="255" value="<?php echo  (isset($_POST['email'])) ? $_POST['email']: '';?>"  />
			<br/>
			<label class="error" for="email"><?php echo (!is_null($error_message_array['email'])) ? $error_message_array['email'] : ''; ?></label>

		</div>
	</fieldset>

	<fieldset>

		<label class="mandatory" for="comments">Comments:</label>

		<div class="field">
			<textarea class="input-text" name="comments" id = "comments" cols = "47" rows = "4"><?php echo isset($_POST['comments']) ? $_POST['comments'] : '';?></textarea>
			<br/>
			<label class="error" for="comments"><?php echo (!is_null($error_message_array['comments'])) ? $error_message_array['comments'] : ''; ?></label>

		</div>
	</fieldset>

	<h4>Single Value Group</h4>
	<p>
		This is breif description of Single Value Group
	</p>
	<fieldset>

		<label class="mandatory" >Are you a local or international student?:</label>

		<div class = "field">
			<input type = "radio" name = "student_type" id = "student_type_local_id" value = "Local" <?php if (isset($_POST['student_type']) && $_POST['student_type'] == "Local") echo "checked";?>>
				<label  for = "student_type_local_id">Local</label>

			<input type = "radio" name = "student_type" id = "student_type_international_id" value = "International" <?php if (isset($_POST['student_type']) && $_POST['student_type'] == "International") echo "checked";?>>
				<label  for = "student_type_international_id">International</label>

			<input type = "radio" name = "student_type" id = "student_type_other_id" value = "Other" <?php if (isset($_POST['student_type']) &&  $_POST['student_type'] == "Other") echo "checked";?>>
				<label  for = "student_type_other_id">Other</label>

			<br/>
			<label class="error" for="student_type"><?php echo (!is_null($error_message_array['student_type'])) ? $error_message_array['student_type'] : ''; ?></label>
		</div>
	</fieldset>
	<div id="div_other">
		<fieldset>
			<label class="mandatory"  for="other">Other:</label>

			<div class = "field">
				<input class = "input-text" type = "text" name = "other" id = "other" size = "50" maxlength = "255"
				value="<?php echo (isset($_POST['other'])) ? $_POST['other'] : '';?>" /><br/>
			</div>
		</fieldset>
	</div>

	<fieldset>

		<label class="mandatory" >I am interested in: </label>

		<div class = "field">
			<input type = "checkbox" name = "student_interest[]" id = "student_interest_diploma_id" <?php if(isset($_POST['student_interest'])){if (in_array("a diploma certificate", $_POST['student_interest'])) echo "checked";}  ?> value = "a diploma certificate">
				<label for = "student_interest_diploma_id">A diploma or certificate</label>
			<br/>
			<input type = "checkbox" name = "student_interest[]" id = "student_interest_bachelor_id" <?php if(isset($_POST['student_interest'])){if (in_array("a bachelor degree (undergraduate qualification)", $_POST['student_interest'])) echo "checked";}?> value = "a bachelor degree (undergraduate qualification)">
				<label for = "student_interest_diploma_id">A bachelor degree (undergraduate qualification)</label>
			<br/>
			<input type = "checkbox" name = "student_interest[]" id = "student_interest_master_id" <?php if(isset($_POST['student_interest'])){if (in_array("a master degree or PhD (postgraduate qualification)", $_POST['student_interest'])) echo "checked";}?> value = "a master degree or PhD (postgraduate qualification)">
				<label for = "student_interest_master_id">A master degree or PhD (postgraduate qualification)</label>

			<br/>
			<label class="error" for="student_interest[]"><?php echo (!is_null($error_message_array['student_interest'])) ? $error_message_array['student_interest']  : ''; ?></label>
		</div>
	</fieldset>

	<fieldset>
		<label class="mandatory" for = "campus">Campus:</label>

		<div class="field">
			<select name = "campus" id = "campus">
				<option value="">&#91;Please Select&#93;</option>
				<option value = "Croydon" <?php if ($_POST['campus'] == "Croydon") echo "selected";?>>Croydon</option>
				<option value = "Hawthorn" <?php if ($_POST['campus'] == "Hawthorn") echo "selected";?>>Hawthorn</option>
				<option value = "Wantirna" <?php if ($_POST['campus'] == "Wantirna") echo "selected";?>>Wantirna</option>
				<option value = "Interstate" <?php if ($_POST['campus'] == "Interstate") echo "selected";?>>Interstate</option>
			</select>
			<br/>
			<label class="error" for = "campus"><?php echo (!is_null($error_message_array['campus'])) ? $error_message_array['campus'] : ''; ?></label>
		</div>
	</fieldset>

	<h4>Multiple Value Group</h4>
	<p>
		This is breif description of Multiple Value Group
	</p>

	<fieldset>
		<label class="mandatory"  for = "faculty">Faculty</label>
		<div class="field">
			<select name = "faculty[]" multiple = "multiple" id = "faculty">
				<option value = "">&#91;Please Select&#93;</option>
				<option value="Faculty of Business and Law" <?php if(!empty($_POST['faculty']) && (in_array("Faculty of Business and Law", $_POST['faculty']))) echo 'selected'; ?>>Faculty of Business and Law</option>
				<option value="Faculty of Health, Arts and Design" <?php if(!empty($_POST['faculty']) && (in_array("Faculty of Health, Arts and Design", $_POST['faculty']))) echo 'selected'; ?>>Faculty of Health, Arts and Design</option>
				<option value="Faculty of Science, Engineering and Technology" <?php if(!empty($_POST['faculty']) && (in_array("Faculty of Science, Engineering and Technology", $_POST['faculty']))) echo 'selected'; ?>>Faculty of Science, Engineering and Technology</option>
				<option value="Department of Business and Finance" <?php if(!empty($_POST['faculty']) && (in_array("Faculty of Health, Arts and Design", $_POST['faculty']))) echo 'selected'; ?>>Department of Business and Finance</option>
				<option value="Department of Design, Media and ICT" <?php if(!empty($_POST['faculty']) && (in_array("Department of Design, Media and ICT", $_POST['faculty']))) echo 'selected'; ?>>Department of Design, Media and ICT</option>
				<option value="Department of Foundation and Pathways" <?php if(!empty($_POST['faculty']) && (in_array("Department of Foundation and Pathways", $_POST['faculty']))) echo 'selected'; ?>>Department of Foundation and Pathways</option>
				<option value="Department of Health, Science, Education and Social Services" <?php if(!empty($_POST['faculty']) && (in_array("Department of Health, Science, Education and Social Services", $_POST['faculty']))) echo 'selected'; ?>>Department of Health, Science, Education and Social Services</option>
				<option value="Department of Trades and Engineering Technology" <?php if(!empty($_POST['faculty']) && (in_array("Department of Trades and Engineering Technology", $_POST['faculty']))) echo 'selected'; ?>>Department of Trades and Engineering Technology</option>
			</select>
			<br/>
			<label class="error" for = "faculty"><?php echo (!is_null($error_message_array['faculty'])) ? $error_message_array['faculty'] : ''; //  $message['faculty']; ?></label>
		</div>
	</fieldset>

	<h4>File Upload Group</h4>
	<p>
		This is breif description of File Upload Group
	</p>

	<fieldset>
		<label class="mandatory" for="file_to_upload"> Upload a file </label>
		<div class="field">
			<input type="file" name="file_to_upload" id="file_to_upload">
			<br/>
			<label class="error" for="file_to_upload">
			<?php
				echo (!is_null($error_message_array['file_to_upload'])) ? $error_message_array['file_to_upload'] : '';
				// echo (!is_null($data['file_to_upload'])) ? $data['file_to_upload'] : '';
			?>
			</label>
		</div>
	</fieldset>

	<div class = "submit">
		<input type = "submit" name = "submit_button" id = "submit_button" value = "Submit">
	</div>
</form>
