<form action="" method="post" onsubmit="return save_version(<?php echo $version->id ?>,this)">
	<table width="100%">
		<tr>
			<th align="right" width="80"><?php _e ('Version', 'drainhole'); ?>:</th>
			<td><input style="width: 35%" type="text" name="version" value="<?php echo htmlspecialchars ($version->version) ?>"/></td>
		</tr>
		<tr>
			<th align="right" width="80"><?php _e ('Hits', 'drainhole'); ?>:</th>
			<td><input style="width: 35%" type="text" name="hits" value="<?php echo $version->hits ?>"/></td>
		</tr>
		<tr>
			<th align="right"><?php _e ('Date', 'drainhole'); ?>:</th>
			<td>
				<input size="2" type="text" name="day" value="<?php echo date ('j', $version->created_at) ?>"/> /
				<input size="2" type="text" name="month" value="<?php echo date ('n', $version->created_at) ?>"/> /
				<input size="4" type="text" name="year" value="<?php echo date ('Y', $version->created_at) ?>"/> (D/M/Y)
			</td>
		</tr>
		<tr>
			<th valign="top" align="right" width="80"><?php _e ('Reason', 'drainhole'); ?>:</th>
			<td><textarea name="reason" style="width: 95%"><?php echo htmlspecialchars ($version->reason); ?></textarea></td>
		</tr>
		<tr>
			<th></th>
			<td><input type="submit" name="save" value="<?php _e ('Save', 'drainhole'); ?>"/> <input type="submit" name="cancel" value="<?php _e ('Cancel', 'drainhole'); ?>" onclick="Modalbox.hide (); return false"/></td>
		</tr>
	</table>
</form>
