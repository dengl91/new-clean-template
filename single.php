<?php
/**
 * Single post (single.php)
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
			<?php previous_post_link('%link', '<- Previous post: %title', TRUE); ?>
			<?php next_post_link('%link', 'Next post: %title ->', TRUE); ?>
			<?php if (comments_open() || get_comments_number()) comments_template('', true); ?>
		</div>
	</section>

<?php get_footer(); ?>
