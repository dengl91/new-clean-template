<?php
/**
 * Author page (author.php)
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
					<?php $curauth = (isset($_GET['author_name'])) ? get_user_by('slug', $author_name) : get_userdata(intval($author)); ?>
					<h1><?php echo $curauth->nickname; ?> posts</h1>
					<div class="media">
						<div class="media__left">
							<?php echo get_avatar($curauth->ID, 64, '', $curauth->nickname, array('class' => 'media-object')); ?>
						</div>
					<div class="media__body">
						<h4 class="media__heading"><?php echo $curauth->display_name; ?></h4>
						<?php if ($curauth->user_url) echo '<a href="'.$curauth->user_url.'">'.$curauth->user_url.'</a>'; ?>
						<?php if ($curauth->description) echo '<p>'.$curauth->description.'</p>'; ?>
					</div>
					</div>

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