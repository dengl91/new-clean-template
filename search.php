<?php
/**
 * Search template (search.php)
 * @package WordPress
 * @subpackage new-clean-template-3
 * @author: DHL
 */
get_header(); ?>

	<section>
		<div class="container">
			<div class="row">
				<div class="col-75">
					<h1><?php printf( 'Search by query: %s', get_search_query() ); ?></h1>
					<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
						<?php get_template_part('loop'); ?>
					<?php endwhile;
					else: echo '<p>Posts by search query not found.</p>'; endif; ?>	 
					<?php pagination(); ?>
				</div>
				<div class="col-25">
					<?php get_sidebar(); ?>
				</div>
			</div>
		</div>
	</section>

<?php get_footer(); ?>