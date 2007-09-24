<ul id="subsubmenu">
  <li><a <?php if ($sub == '') echo 'class="current"'; ?>href="<?php echo $url ?>"><?php _e ('Files &amp; Holes', 'drainhole') ?></a></li>
  <li><a <?php if ($sub == 'downloads') echo 'class="current"'; ?>href="<?php echo $url ?>&amp;sub=downloads"><?php _e ('Downloads', 'drainhole') ?></a></li>
  <li><a <?php if ($sub == 'options') echo 'class="current"'; ?>href="<?php echo $url ?>&amp;sub=options"><?php _e ('Options', 'drainhole') ?></a></li>
</ul>