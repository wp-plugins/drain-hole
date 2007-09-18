<form action="" method="post" onsubmit="return save_new_version(<?php echo $file->id ?>,this)">
	<table width="100%">
		<tr>
			<th align="right"><?php _e ('File', 'drainhole'); ?>:</th>
			<td><code><?php echo $file->name () ?></code></td>
		</tr>
		<tr>
			<th align="right"><?php _e ('Current version', 'drainhole'); ?>:</th>
			<td><input style="width: 95%" type="text" name="old_version" value="<?php echo $file->version ?>" readonly="readonly"/></td>
		</tr>
		<tr>
			<th align="right"><?php _e ('New version', 'drainhole'); ?>:</th>
			<td><input tabindex="1" id="newversion" style="width: 95%" type="text" name="new_version" value="<?php echo $file->next_version () ?>"/></td>
		</tr>
		<tr>
			<th valign="top" align="right"><?php _e ('Version history', 'drainhole'); ?>:</th>
			<td>
				<textarea tabindex="2" style="width: 95%" name="reason" rows="3"></textarea>
			</td>
		</tr>
		<?php if ($file->svn) :?>
			<tr>
				<th align="right"><?php _e ('SVN Update', 'drainhole'); ?>:</th>
				<td>
					<input tabindex="3" type="checkbox" name="svn"/>
					<span class="sub"><?php _e ('Update the download from SVN (using version info if applicable)', 'drainhole'); ?></span>
				</td>
			</tr>
		<?php endif; ?>
		<tr>
			<th align="right"><?php _e ('Keep previous', 'drainhole'); ?>:</th>
			<td>
				<input tabindex="3" type="checkbox" name="branch"/>
				<span class="sub"><?php _e ('Selecting this will retain the previous version', 'drainhole'); ?></span>
			</td>
		</tr>
		<tr>
			<td></td>
			<td>
				<input tabindex="4" type="submit" name="save" value="<?php _e ('Save', 'drainhole'); ?>"/>
				<input tabindex="5" type="submit" name="cancel" value="<?php _e ('Cancel', 'drainhole'); ?>" onclick="Modalbox.hide (); return false;"/>
			</td>
		</tr>
	</table>
</form>
