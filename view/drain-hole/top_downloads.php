<ul>
<?php foreach ($files AS $file) : $hole = DH_Hole::get ($file->hole_id); ?>
	<li><?php echo $file->url ($hole); ?> (<?php echo $file->downloads ?>)</li>
<?php endforeach; ?>
</ul>