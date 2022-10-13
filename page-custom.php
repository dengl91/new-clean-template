<?php
/**
 * Custom page template
 * @package WordPress
 * @subpackage new-clean-template-3
 * @author: DHL
 * Template Name: Custom page
 */
get_header(); ?>

	<section>
		<div class="container">
			<div class="row">
				<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
					<?php the_content(); ?>
				<?php endwhile; ?>
			</div>
		</div>
	</section>

<?php get_footer(); ?>