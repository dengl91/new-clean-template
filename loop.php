<?php
/**
 * Loop template (loop.php)
 * @package WordPress
 * @subpackage new-clean-template-3
 * @author: DHL
 */ 
?>

<article class="post" id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
	<div class="post__meta">
		<p>Published: <?php the_time(get_option('date_format')." in ".get_option('time_format')); ?></p>
		<p>Author:  <?php the_author_posts_link(); ?></p>
		<p>Categories: <?php the_category(',') ?></p>
		<?php the_tags('<p>Tags: ', ',', '</p>'); ?>
	</div>
	<div class="row">
		<?php if ( has_post_thumbnail() ) { ?>
			<div class="post__img">
				<a href="<?php the_permalink(); ?>" class="post__thumbnail">
					<?php the_post_thumbnail(); ?>
				</a>
			</div>
		<?php } ?>
		<div class="post__intro">
			<!-- add content before --more-- or other logic -->
			<?php the_content(''); ?>
		</div>
	</div>
</article>
