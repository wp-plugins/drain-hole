<script language="javascript" type="text/javascript" src="<?php bloginfo ('wpurl') ?>/wp-includes/js/tinymce/tiny_mce_popup.js"></script>
<script type="text/javascript" charset="utf-8">
function dothing ()
{
	var html;
	var inst = tinyMCE.selectedInstance;
	
	html = '[drain file ';
	html += document.getElementById ('drain_file').value;
	html += ' ' + document.getElementById ('drain_display').value + '] ';
	
	inst.execCommand('mceBeginUndoLevel');
	inst.execCommand('mceInsertContent', false, html);
	tinyMCE.handleVisualAid(inst.getBody(), true, tinyMCE.settings['visual']);
	inst.execCommand('mceEndUndoLevel');
}
</script>

<select name="file" id="drain_file">
<?php foreach ($files AS $file) : ?>
	<option value="<?php echo $file->id ?>"><?php echo $file->name (); ?></option>
<?php endforeach;?>
</select>

<select name="display" id="drain_display">
	<option value="show">Show file template</option>
	<option value="url">Show file URL</option>
	<option value="version">Show file version</option>
	<option value="svn">Show file SVN</option>
	<option value="hits">Show file hits</option>
</select>
<br/><br/>
<input type="submit" name="thing" value="<?php _e ('Add Drain Hole tag', 'drain-hole'); ?>"  onclick="return dothing ();"/>
