<div class="wrap">
	<h2><?php _e ('Drain Hole Options', 'drainhole'); ?></h2>
	
	<form action="<?php echo $this->ur; ($_SERVER['REQUEST_URI']) ?>" method="post" accept-charset="utf-8">
	<table width="100%">

		<tr>
			<th width="220" align="right"><?php _e ('Statistic retention', 'drainhole'); ?>:<br/>
				<span class="sub"><?php _e ('How many days to keep access statistics for', 'drainhole'); ?></span></th>
			<td><input type="text" size="5" name="stats" value="<?php echo $options['days'] ?>"/> 
				<span class="sub"><?php _e ('Enter 0 for no limit.  File hits are not cleared', 'drainhole'); ?></span></td>
		</tr>

		<tr>
			<th width="220" align="right">SVN path:</th>
			<td>
				<input size="50" type="text" name="svn" value="<?php echo $options['svn'] ?>"/>
			</td>
		</tr>
		<tr>
			<th width="220" align="right"><label for="google"><?php _e ('Google Analytics tracking', 'drainhole'); ?></label>:<br/>
				<span class="sub"><?php _e ('Add code to track downloads', 'drainhole'); ?></span></th>
			<td><input type="checkbox" name="google"<?php if ($options['google'] == true) echo ' checked="checked"' ?> id="google"/></td>
		</tr>
		<tr>
			<th width="220" align="right"><label for="update"><?php _e ('Update notification', 'drainhole'); ?>:</label><br/>
				<span class="sub"><?php _e ('Whether to check for updates', 'drainhole'); ?></span></th>
			<td><input type="checkbox" size="5" name="update" id="update"<?php if ($options['update'] == true) echo ' checked="checked"' ?>/> 
				</td>
		</tr>
		<tr>
			<th width="220" align="right"><?php _e ('Kitten protection', 'drainhole'); ?>:</th>
			<td>
				<input type="checkbox" name="kitten"<?php $this->checked ($options, 'kitten') ?>/>
				<span class="sub"><?php _e ('I hereby testify that I have supported this plugin.  If I check this option and haven\'t supported this plugin then a squad of winged monkeys will be sent to drop things on my head.', 'drainhole'); ?></span>
			</td>
		</tr>
		<tr>
			<th width="220" align="right"></th>
			<td><input type="submit" name="options" value="<?php _e ('Save options', 'drainhole'); ?>"/></td>
		</tr>
	</table>

		</form>
</div>

<div class="wrap">
	<h2><?php _e ('Delete Drain Hole', 'drainhole'); ?></h2>
	
	<p><?php _e ('This operation removes all data associated with Drain Hole and disables the plugin.  It does not delete any files', 'drainhole'); ?></p>
	
	<form action="<?php echo $this->url ($_SERVER['REQUEST_URI']) ?>" method="post" accept-charset="utf-8">
		

		<input type="submit" value="Delete" name="delete"/>
	</form>
</div>