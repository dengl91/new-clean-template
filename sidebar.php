<?php
/**
 * Sidebar template (sidebar.php)
 * @package WordPress
 * @subpackage new-clean-template-3
 * @author: DHL
 */
?>
<?php if( is_active_sidebar('sidebar') ) { ?>
	<aside>
		<?php dynamic_sidebar('sidebar'); ?>
	</aside>
<?php } ?>