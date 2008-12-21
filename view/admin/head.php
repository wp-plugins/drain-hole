<?php if (!defined ('ABSPATH')) die ('No direct access allowed'); ?>
<script type="text/javascript" charset="utf-8">
	var wp_base             = '<?php echo $this->url () ?>/ajax.php';
	var wp_dh_loading       = '<img src="<?php echo $this->url () ?>/images/progress.gif" width="50" height="16" alt="Progress"/>';
	var wp_dh_url           = '<?php echo $this->url () ?>/charts/';
	var wp_dh_deletehole    = '<?php _e ('Are you sure you want to delete this Drain Hole and all files?', 'drain-hole') ?>';
	var wp_dh_deleteversion = '<?php _e ('Are you sure you want to delete this version?', 'drain-hole') ?>';
	var wp_dh_deletefile    = '<?php _e ('Are you sure you want to delete this file?', 'drain-hole') ?>';
</script>
<script type="text/javascript" charset="utf-8" src="<?php echo $this->url () ?>/js/drainhole.js?version=<?php echo $this->version () ?>"></script>
<link rel="stylesheet" href="<?php echo $this->url () ?>/admin.css?version=<?php echo $this->version () ?>" type="text/css"/>