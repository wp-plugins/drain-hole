<?php if (!defined ('ABSPATH')) die ('No direct access allowed'); ?><form action="" method="post" onsubmit="return save_file(<?php echo $file->id ?>,this)">
	<table width="100%">
		<tr>
			<th align="right" width="80"><?php _e ('Filename', 'drain-hole'); ?>:</th>
			<td><input style="width: 95%" type="text" name="file" value="<?php echo htmlspecialchars ($file->file) ?>"/></td>
		</tr>
		<tr>
			<th align="right" width="80"><?php _e ('Name', 'drain-hole'); ?>:</th>
			<td><input style="width: 95%" type="text" name="name" value="<?php echo htmlspecialchars ($file->name) ?>"/></td>
		</tr>
		<tr>
			<th valign="top" align="right" width="80"><?php _e ('Description', 'drain-hole'); ?>:</th>
			<td><textarea name="description" style="width: 95%"><?php echo htmlspecialchars ($file->description); ?></textarea></td>
		</tr>
		<tr>
			<th align="right" width="80"><?php _e ('Hits', 'drain-hole'); ?>:</th>
			<td><input style="width: 95%" type="text" name="hits" value="<?php echo $file->hits ?>"/></td>
		</tr>
		<tr>
			<th align="right" width="80"><?php _e ('SVN', 'drain-hole')?>:</th>
			<td><input style="width: 95%" type="text" name="svn" value="<?php echo $file->svn ?>"/></td>
		</tr>
		<tr>
			<th align="right" ><?php _e ('Icon', 'drain-hole'); ?>:</th>
			<td>
				<select name="icon">
					<option value="-"><?php _e ('Default', 'drain-hole'); ?></option>
					<?php echo $this->select ($file->available_icons (), $file->icon); ?>
				</select>
			</td>
		</tr>
		<tr>
			<th align="right" ><?php _e ('MIME Type', 'drain-hole'); ?>:</th>
			<td>
				<select name="mime">
					<option value="-"><?php _e ('Auto-detect', 'drain-hole') ?></option>
					<?php foreach ($types AS $type) : ?>
					<option value="<?php echo $type ?>"<?php if ($file->mime == $type) echo ' selected="selected"' ?>><?php echo $type ?></option>
					<?php endforeach; ?>
				</select>
			
			</td>
		</tr>
		<tr>
			<th align="right"><?php _e ('Options', 'drain-hole'); ?>:</th>
			<td>
				<input type="checkbox" name="options" value="force_download" id="force_<?php echo $file->id ?>"<?php echo $this->checked (in_array ('force_download', $file->options)) ?>/>
				<label for="force_<?php echo $file->id ?>"><?php _e ('Force download', 'drain-hole'); ?></label>

				<input type="checkbox" name="options" value="force_access" id="force_access<?php echo $file->id ?>"<?php echo $this->checked (in_array ('force_access', $file->options)) ?>/>
				<label for="force_access<?php echo $file->id ?>"><?php _e ('Force access level', 'drain-hole'); ?></label>
			</td>
		</tr>
		<tr>
			<th></th>
			<td><input type="submit" name="save" value="<?php _e ('Save', 'drain-hole'); ?>"/> <input type="submit" name="cancel" value="<?php _e ('Cancel', 'drain-hole'); ?>" onclick="Modalbox.hide (); return false"/></td>
		</tr>
	</table>
</form>
