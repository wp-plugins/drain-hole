<div class="wrap">
	<div class="pagertools"><a href="<?php echo $this->url () ?>/csv.php?id=<?php echo $hole->id ?>&amp;type=files" title="Download as CSV"><img src="<?php echo $this->url () ?>/images/csv.png" width="16" height="16" alt="CSV"/></a></div>
	
	<h2><?php _e ('Files for', 'drainhole'); ?> <?php echo $hole->url; ?></h2>
	
	<p><?php _e ('Files are stored in', 'drainhole'); ?> <code><?php echo $hole->directory; ?></code></p>
	
	<?php $this->render_admin ('pager', array ('pager' => $pager)); ?>
	
	<?php if (count ($files) > 0) : ?>
	<table class="holes">
		<thead>
		<tr>
			<th><?php echo $pager->sortable ('id', __ ('ID', 'drainhole')) ?></th>
			<th align="left"><?php echo $pager->sortable ('file', __ ('File', 'drainhole')) ?></th>
			<th align="left"><?php echo $pager->sortable ('version', __ ('Version', 'drainhole')) ?></th>
			<th><?php echo $pager->sortable ('hits', __ ('Hits', 'drainhole')) ?></th>
			<th align="left"><?php echo $pager->sortable ('updated_at', __ ('Updated', 'drainhole')) ?></th>
			<th><?php _e ('Branch', 'drainhole'); ?></th>
			<th><?php _e ('Charts', 'drainhole'); ?></th>
			<th></th>
		</tr>
		</thead>
		
		<?php if ($pager->total_pages () > 1) : ?>
		<tfoot>
			<tr>
				<td colspan="8">
			<div class="pagertools">
			<?php foreach ($pager->area_pages () AS $page) : ?>
				<?php echo $page ?>
			<?php endforeach; ?>
			</div>
				</td>
			</tr>
			
		</tfoot>
		<?php endif; ?>
		
		<?php foreach ($files AS $pos => $file) : ?>
			<tr id="file_<?php echo $file->id ?>" class="<?php if ($pos % 2 == 1) echo 'alt' ?><?php if (!$file->exists ($hole)) echo ' missing' ?>">
				<?php $this->render_admin ('files_item', array ('file' => $file, 'hole' => $hole)); ?>
			</tr>
		<?php endforeach; ?>
	</table>
	
	<div id="loading" style="display: none">
		<img src="<?php echo $this->url () ?>/images/loading.gif" alt="loading" width="32" height="32"/>
	</div>
	
	<?php endif;?>
</div>

<div class="wrap">
	<h2><?php _e ('Add A File', 'drainhole'); ?></h2>
	
	<p><?php _e ('New files can be added by uploading here (if the directory has appropriate write-permissions), or by uploading with an FTP client and \'scanning\' the directory for changes.', 'drainhole'); ?></p>

	<form action="<?php echo $_SERVER['REQUEST_URI'] ?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">
		<table>
			<tr>
				<th><?php _e ('New filename', 'drainhole'); ?>:</th>
				<td><input size="40" type="text" name="filename" value=""/> <span class="sub"><?php _e ('Optional, uploaded filename will be used if not given', 'drainhole'); ?></span></td>
			</tr>
			
			<?php if ($hole->can_write ()) : ?>
			<tr>
				<th><?php _e ('Upload a file', 'drainhole'); ?>:</th>
				<td><input size="40" type="file" name="file"/> <span class="sub"><?php _e ('Optional, an empty file suitable for later upload or SVN will otherwise be created', 'drainhole'); ?></span></td>
			</tr>
			<?php endif; ?>
		
			<tr>
				<td></td>
				<td>
					<input type="submit" name="upload" value="<?php _e ('Create &amp; upload', 'drainhole'); ?>"/>
					<input type="submit" name="rescan" value="<?php _e ('Re-scan', 'drainhole'); ?>" id="rescan"/>
				</td>
			</tr>
		</table>
	</form>
	
</div>