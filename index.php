<?php
/**
 * Index page (index.php)
 * @package WordPress
 * @subpackage new-clean-template-3
 * @author DHL
 */
get_header(); ?>

	<section>
		<div class="container">
			<h1><?php the_title(); ?></h1>
			<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
				<?php the_content(); ?>
			<?php endwhile; ?>
		</div>
	</section>

<?php get_footer(); ?>