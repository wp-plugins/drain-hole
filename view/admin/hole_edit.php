<form method="post" action="" onsubmit="return save_hole(<?php echo $hole->id ?>,this)">
	<table width="100%">
		<tr>
		  <th valign="top" align="right" width="120"><?php _e ('URL', 'drainhole') ?>:<br/><span class="sub"><?php _e ('Relative to site root', 'drainhole') ?></span></th>
		  <td><input style="width: 95%" type="text" name="urlx" value="<?php echo htmlspecialchars ($hole->url); ?>"/></td>
		</tr>
		<tr>
		  <th valign="top" align="right" ><?php _e ('Directory', 'drainhole') ?>:<br/><span class="sub"><?php _e ('Relative to root', 'drainhole') ?></span></th>
		  <td><input style="width: 95%" type="text" name="directoryx" value="<?php echo htmlspecialchars ($hole->directory); ?>"/></td>
		</tr>
		<tr>
		  <th valign="top" align="right" ><?php _e ('Access Level', 'drainhole') ?>:<br/><span class="sub"><?php _e ('File security', 'drainhole') ?></span></th>
		  <td valign="top" >
		  	<select name="role">
					<option value="-"><?php _e ('Anybody - no login required', 'drainhole'); ?></option>
					<?php if (class_exists ('WPShopper')) : ?>
					<option value="paid"<?php if ($role == 'paid') echo ' selected="selected"' ?>><?php _e ('Purchased - via WP Shopper', 'drainhole'); ?></option>
					<?php endif; ?>

					<?php global $wp_roles; foreach ($wp_roles->role_names as $key => $rolename) : ?>
						<option value="<?php echo $key ?>"<?php if ($hole->role == $key) echo ' selected="selected"'; ?>><?php echo $rolename ?></option>
					<?php endforeach; ?>
				</select>
			</td>
		</tr>

		<tr>
		  <th valign="top" align="right" ><?php _e ('Access error URL', 'drainhole') ?>:<br/><span class="sub"><?php _e ('Redirect on access error', 'drainhole'); ?></span></th>
		  <td valign="top" >
				<input type="text" size="40" name="redirect_urlx" value="<?php echo htmlspecialchars ($hole->role_error_url) ?>"/>
		  </td>
		</tr>
		<tr>
			<th align="right"><label for="hotlink"><?php _e ('Stop hot-links', 'drainhole'); ?>:</label></th>
			<td>
				<input type="checkbox" name="hotlink" id="hotlink"<?php if ($hole->hotlink) echo ' checked="checked"' ?>/>
			</td>
		</tr>
		<th></th>
			<td>
				<input type="submit" name="save" value="<?php _e ('Save', 'drainhole'); ?>"/>
				<input type="submit" name="cancel" value="<?php _e ('Cancel', 'drainhole'); ?>" onclick="Modalbox.hide (); return false"/>
			</td>
		</tr>
	</table>
</form>



