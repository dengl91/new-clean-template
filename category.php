<?php
/**
 * Category template (category.php)
 * @package WordPress
 * @subpackage new-clean-template-3
 * @author: DHL
 * Author URI: telegram @dhljob
 */
get_header(); ?>

	<section>
		<div class="container">
			<div class="row">
				<div class="col-75">
					<h1><?php single_cat_title(); ?></h1>
					<?php if (have_posts()) : ?>
						<div class="row">
							<?php while (have_posts()) : the_post(); ?>
								<?php get_template_part('loop'); ?>
							<?php endwhile; ?>
						</div>
						<?php pagination(); ?>
					<?php else: echo '<p>Posts not found.</p>'; endif; ?>
				</div>
			</div>
			<div class="col-25">
				<?php get_sidebar(); ?>
			</div>
			</div>
		</div>
	</section>

<?php get_footer(); ?>