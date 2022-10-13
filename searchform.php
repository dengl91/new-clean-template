<?php
/**
 * Search form template (searchform.php)
 * @package WordPress
 * @subpackage new-clean-template-3
 * @author: DHL
 */
?>
<form role="search" method="get" class="form" action="<?php echo home_url( '/' ); ?>">
	<div class="form__group">
		<label for="search-field">Search</label>
		<input type="search" id="searchfield" placeholder="Search..." value="<?php echo get_search_query() ?>" name="s">
	</div>
	<button type="submit" class="btn">Search</button>
</form>