<?php if (!defined ('ABSPATH')) die ('No direct access allowed'); ?><div class="wrap" style="min-width: 820px">
	<div class="options">
		<a href="#" onclick="return print_chart ()"><img src="<?php echo $this->url () ?>/images/printer.png" width="16" height="16" alt="Printer"/></a>
		<a href="<?php echo $chart->source ?>&amp;csv"><img src="<?php echo $this->url () ?>/images/csv.png" width="16" height="16" alt="Csv"/></a>
	</div>
	<h2><?php printf (__ ('File Charts for %s', 'drainhole'), $file->name ()); ?></h2>

	<div style="margin: 0 auto; width: 810px">
		<form action="<?php echo $base ?>" method="get" accept-charset="utf-8">
			<p>
				<?php _e ('Chart', 'drainhole'); ?>:
			<select name="type" id="type">
				<option value="access"<?php if ($type == 'access') echo ' selected="selected"' ?>><?php _e ('Downloads over time', 'drainhole'); ?></option>
			</select>
	
			<?php _e ('Display', 'drainhole'); ?>: 
				<select name="display" id="display">
					<option value="hourly"<?php if ($display == 'hourly') echo ' selected="selected"' ?>><?php _e ('Hourly', 'drainhole'); ?></option>
					<option value="daily"<?php if ($display == 'daily') echo ' selected="selected"' ?>><?php _e ('Daily', 'drainhole'); ?></option>
					<option value="monthly"<?php if ($display == 'monthly') echo ' selected="selected"' ?>><?php _e ('Monthly', 'drainhole'); ?></option>
				</select>

				<?php $chart->show_time ($display, $file); ?>
	
				<input type="submit" name="show" value="<?php _e ('Show', 'drainhole'); ?>" id="show"/>
				<input type="hidden" name="page" value="<?php echo $_GET['page'] ?>"/>
				<input type="hidden" name="chart" value="<?php echo $_GET['chart'] ?>"/>
			</p>
		</form>
	
		<?php echo $chart->get (); ?>
	
		<?php echo $chart->previous ($display, $file); ?>
		<?php echo $chart->next ($display, $file); ?>
		
		<div style="clear: both"></div>
	</div>
</div>