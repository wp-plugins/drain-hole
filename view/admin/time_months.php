<?php global $wp_locale; ?><?php _e ('Month', 'drainhole'); ?>: 
<select name="month" id="months">
	<?php for ($x = 1; $x <= 12; $x++) : ?>
		<option value="<?php echo $x; ?>" <?php if ($x == $current) echo ' selected="selected"'; ?>><?php echo $wp_locale->get_month ($x) ?></option>
	<?php endfor; ?>
</select> 