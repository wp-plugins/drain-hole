<?php $size = $file->filesize ($hole); ?>
<div class="wrap">
	<div class="pagertools"><a href="<?php echo $this->url () ?>/csv.php?id=<?php echo $file->id ?>&amp;type=stats" title="Download as CSV"><img src="<?php echo $this->url () ?>/images/csv.png" width="16" height="16" alt="CSV"/></a></div>
	<h2><?php _e ('Download Statistics for', 'drainhole'); ?> <?php echo $file->file ?></h2>
	
	<?php if ($pager->total > 25) :?>
	<?php $this->render_admin ('pager', array ('pager' => $pager)); ?>
	<?php endif; ?>
	
	<?php if (count ($stats) > 0) : ?>
	<table class="files">
		<thead>
			<tr>
				<th><?php echo $pager->sortable ('created_at', __ ('Download At', 'drainhole')) ?></th>
				<th><?php echo $pager->sortable ('ip', __ ('IP', 'drainhole')) ?></th>
				<th><?php echo $pager->sortable ('speed', __ ('Speed', 'drainhole')) ?></th>
				<th><?php echo $pager->sortable ('time_taken', __ ('Time Taken', 'drainhole')) ?></th>
				<th width="16"></th>
			</tr>
		</thead>
		
		<tfoot>
			<tr>
				<td colspan="5">
			<?php if ($pager->total_pages () > 1) : ?>
			<div class="pagertools">
			<?php foreach ($pager->area_pages () AS $page) : ?>
				<?php echo $page ?>
			<?php endforeach; ?>
			</div>
			<?php endif; ?>
				</td>
			</tr>
			
		</tfoot>
		
		<tbody>
		<?php foreach ($stats AS $stat) : ?>
		<tr id="stat_<?php echo $stat->id ?>">
			<td><?php echo date (get_option ('date_format'), $stat->created_at); ?> <?php echo date (get_option ('time_format'), $stat->created_at)?></td>
			<td><a href="http://ws.arin.net/whois/?queryinput=<?php echo $stat->ip ?>"><?php echo $stat->ip; ?></a></td>
			<td><?php if ($stat->speed > 0) echo DH_File::bytes ($stat->speed).'/s' ?></td>
			<td><?php if ($stat->speed == 0) echo __ ('Cancelled', 'drainhole'); else echo DH_File::timespan ($stat->time_taken) ?></td>
			<td><a href="#" onclick="return delete_stat(<?php echo $stat->id ?>)"><img src="<?php echo $this->url () ?>/images/delete.png" width="16" height="16" alt="Delete"/></a></td>
		</tr>
		<?php endforeach; ?>
		</tbody>
	</table>
	
	<div id="loading" style="display: none">
		<img src="<?php echo $this->url () ?>/images/loading.gif" alt="loading" width="32" height="32"/>
	</div>
	<?php else : ?>
	<p><?php _e ('There are no statistics for this file!', 'drainhole'); ?></p>
	<?php endif; ?>
</div>

<div class="wrap">
	<h2><?php _e ('Clear Statistics For This File', 'drainhole'); ?></h2>
	
	<form action="<?php echo $_SERVER['REQUEST_URI'] ?>" method="post" accept-charset="utf-8">
		<input type="submit" name="clear_stats" value="<?php _e ('Clear Statisitics', 'drainhole'); ?>"/>
	</form>
</div>