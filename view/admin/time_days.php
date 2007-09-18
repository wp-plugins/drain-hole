<?php _e ('Day', 'drainhole'); ?>: 
<select name="day" id="days">
	<?php for ($x = 1; $x <= 31; $x++) : ?>
		<option value="<?php echo $x; ?>" <?php if ($x == $current) echo ' selected="selected"'; ?>><?php echo $x ?></option>
	<?php endfor; ?>
</select> 