<div style="float: right; width: 200px; margin: 10px; text-align: center">
	<p>$icon$</p>

	<table class="download">
		<tr>
			<th><?php _e ('Download', 'drainhole'); ?>:</th>
			<td>$url$</td>
		</tr>
		<tr>
			<th><?php _e ('Version', 'drainhole'); ?>:</th>
			<td>$version$</td>
		</tr>
		<tr>
			<th><?php _e ('Updated', 'drainhole'); ?>:</th>
			<td>$updated$</td>
		</tr>
		<tr>
			<th><?php _e ('Size', 'drainhole'); ?>:</th>
			<td>$size$</td>
		</tr>
	</table>
	
	<?php	$options = get_option ('drainhole_options');
			if (!$options || !isset ($options['kitten']) || $options['kitten'] == false)
				_e ('<br/><small>Powered by <a href="http://urbangiraffe.com/plugins/drain-hole/">Drain Hole</a></small>', 'drainhole');
			?>
</div>
