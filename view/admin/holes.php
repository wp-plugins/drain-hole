<div class="wrap">
	<div class="pagertools"><a href="<?php echo $this->url () ?>/csv.php?id=<?php echo $hole->id ?>&amp;type=holes" title="Download as CSV"><img src="<?php echo $this->url () ?>/images/csv.png" width="16" height="16" alt="CSV"/></a></div>
	
	<h2><?php _e ('Drain Holes', 'drainhole') ?></h2>

	<?php if (!isset ($options['kitten']) || $options['kitten'] == false) $this->render_admin ('kitten'); ?>
	<?php $this->render_admin ('pager', array ('pager' => $pager)); ?>
	
	<?php if (count ($holes) > 0) : ?>
	<table class="holes">
		<thead>
			<tr>
				<th><?php echo $pager->sortable ('id', 'ID') ?></th>
				<th align="left"><?php echo $pager->sortable ('name', 'Name') ?></th>
				<th><?php echo $pager->sortable ('hits', 'Hits') ?></th>
				<th><?php _e ('Edit', 'drainhole'); ?></th>
				<th><?php _e ('Files', 'drainhole'); ?></th>
				<th><?php _e ('Charts', 'drainhole'); ?></th>
				<th><?php _e ('Delete', 'drainhole'); ?></th>
			</tr>
		</thead>
		
		<?php if ($pager->total_pages () > 1) : ?>
		<tfoot>
			<tr>
				<td colspan="7">
			<div class="pagertools">
			<?php foreach ($pager->area_pages () AS $page) : ?>
				<?php echo $page ?>
			<?php endforeach; ?>
			</div>
				</td>
			</tr>
			
		</tfoot>
		<?php endif; ?>
		
		<tbody>
			<?php foreach ($holes AS $pos => $hole) : ?>
				<tr id="hole_<?php echo $hole->id ?>"<?php if ($pos % 2 == 1) echo ' class="alt"'?>>
					<?php $this->render_admin ('hole_item', array ('hole' => $hole)); ?>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
	<?php endif; ?>
	
	<div id="loading" style="display: none">
		<img src="<?php echo $this->url () ?>/images/loading.gif" alt="loading" width="32" height="32"/>
	</div>
</div>

<div class="wrap">
	<h2><?php _e ('New Drain Hole', 'drainhole'); ?></h2>
	
	<p><?php _e ('Drain Hole provides a central download repository.  You upload files into a specified directory (the drain hole), and it
	provides download access to the directory at a given URL, along with monitoring of download statistics and configurable permissions.  Direct access to the files is not allowed.', 'drainhole') ?></p>

	<form method="post" action="<?php echo $this->url ($_SERVER['REQUEST_URI']) ?>">
		<table width="100%">
			<tr>
			  <th valign="top" align="right" width="120"><?php _e ('URL', 'drainhole') ?>:<br/><span class="sub"><?php _e ('Relative to site root', 'drainhole') ?></span></th>
			  <td><input style="width: 95%" type="text" name="urlx" value="<?php echo htmlspecialchars ($url); ?>"/></td>
			</tr>
			<tr>
			  <th valign="top" align="right" ><?php _e ('Directory', 'drainhole') ?>:<br/><span class="sub"><?php _e ('Relative to root', 'drainhole') ?></span></th>
			  <td><input style="width: 95%" type="text" name="directoryx" value=""/>
				<br/><span class="sub"><?php _e ('You are advised to pick a directory outside of your <code>public_html</code>', 'drainhole'); ?></span>
				</td>
			</tr>
			<tr>
				<th></th>
				<td><input type="submit" name="create" value="<?php _e ('Create Drain Hole', 'drainhole'); ?>" id="create"/></td>
			</tr>
		</table>
	</form>
</div>