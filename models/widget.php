<?php

class DH_Widget extends Widget
{
	var $title  = '';
	
	function has_config () { return true; }
	
	function load ($config)
	{
		if (isset ($config['title']))
			$this->title = $config['title'];
	}
	
	function display ($args)
	{
		extract ($args);

		echo $before_widget;
		if ($this->title)
			echo $before_title.$this->title.$after_title;
			
		the_drainhole_stats ();
		echo $after_widget;
	}
	
	function config ($config, $pos)
	{
		?>
		<table>
			<tr>
				<th>Title:</th>
				<td><input type="text" name="<?php echo $this->config_name ('title', $pos) ?>" value="<?php echo htmlspecialchars ($config['title']) ?>"/></td>
			</tr>
		</table>
		<?php
	}
	
	function save ($data)
	{
		return array ('title' => $data['title']);
	}
}

?>