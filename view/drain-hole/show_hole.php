<?php if (!empty ($files)) : ?>
	<ul>
<?php foreach ($files AS $file) : ?>
		<li>
			<?php echo $file->url ($hole, $file->file); ?> (<?php echo $file->bytes ($file->filesize ($hole)) ?>)
			<?php if ($file->description) echo '<br/>'.$file->description; ?>
		</li>
<?php endforeach; ?>
	</ul>
<?php endif; ?>