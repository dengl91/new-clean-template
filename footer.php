<?php
/**
 * Footer template (footer.php)
 * @package WordPress
 * @subpackage new-clean-template-3
 * @author: DHL
 * Author URI: telegram @dhljob
 */
?>
	<footer class="footer">
		<div class="container">
			<div class="row">
				<?php
                if( have_rows('footer_columns', 'options') ) :
                    while( have_rows('footer_columns', 'options') ) : the_row();
                ?>
				<div class="col-grow">
					<div class="footer__title"><?php the_sub_field('column_title') ?></div>
					<?php
					if( have_rows('column_links') ) :
						while( have_rows('column_links') ) : the_row();
					?>
						<a href="<?php the_sub_field('link_url') ?>" class="footer__link"><?php the_sub_field('link_title') ?></a>
					<?php
						endwhile;
					endif;
					?>
				</div>
				<?php
                    endwhile;
                endif;
                ?>
			</div>
			<div class="row">
				<div class="col">
					<div class="footer__copyright"><?php the_field('copyright', 'options') ?></div>
				</div>
			</div>
		</div>
	</footer>
	
	<?php wp_footer(); ?>
	
</body>
</html>