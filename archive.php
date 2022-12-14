<?php
/**
 * Post archive (archive.php)
 * @package WordPress
 * @subpackage new-clean-template-3
 */
get_header(); ?>

	<section>
		<div class="container">
			<div class="row">
				<div class="col-75">
					<h1><?php
						if (is_day()) : printf('Daily Archives: %s', get_the_date());
						elseif (is_month()) : printf('Monthly Archives: %s', get_the_date('F Y'));
						elseif (is_year()) : printf('Yearly Archives: %s', get_the_date('Y'));
						else : 'Archives';
					endif; ?></h1>
					<?php if (have_posts()) : ?>
						<div class="row">
							<?php while (have_posts()) : the_post(); ?>
								<?php get_template_part('loop'); ?>
							<?php endwhile; ?>
						</div>
						<?php pagination(); ?>
					<?php else: echo '<p>Posts not found.</p>'; endif; ?>
				</div>
				<div class="col-25">
					<?php get_sidebar(); ?>
				</div>
			</div>
		</div>
	</section>

<?php get_footer(); ?>