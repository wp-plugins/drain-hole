<?php _e ('Year', 'drainhole'); ?>: 
<select name="year" id="years">
	<?php for ($x = $start; $x <= $end; $x++) : ?>
		<option value="<?php echo $x; ?>" <?php if ($x == $current) echo ' selected="selected"'; ?>><?php echo $x ?></option>
	<?php endfor; ?>
</select> 