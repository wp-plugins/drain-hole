<?php if (!defined ('ABSPATH')) die ('No direct access allowed'); ?><tr>
  <th valign="top" align="right" width="100"><?php _e ('URL', 'drainhole') ?>:<br/><span class="sub"><?php _e ('Relative to site root', 'drainhole') ?></span></th>
  <td><input style="width: 95%" type="text" name="urlx" value="<?php echo htmlspecialchars ($url); ?>"/></td>
</tr>
<tr>
  <th valign="top" align="right" ><?php _e ('Directory', 'drainhole') ?>:<br/><span class="sub"><?php _e ('Relative to root', 'drainhole') ?></span></th>
  <td><input style="width: 95%" type="text" name="directoryx" value="<?php echo htmlspecialchars ($directory); ?>"/></td>
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
				<option value="<?php echo $key ?>"<?php if ($role == $key) echo ' selected="selected"'; ?>><?php echo $rolename ?></option>
			<?php endforeach; ?>
		</select>
		
		<?php _e ('on access error redirect to URL', 'drainhole'); ?>: <input type="text" size="40" name="redirect_urlx" value="<?php echo $redirect ?>"/>
  </td>
</tr>