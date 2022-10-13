<?php
/**
 * Comments template (comments.php)
 * @package WordPress
 * @subpackage new-clean-template-3
 * @author: DHL
 * Author URI: telegram @dhljob
 */
?>
<div id="comments">
	<?php if (have_comments()) : ?>
		<h2>Total comments: <?php echo get_comments_number(); ?></h2>
		<ul class="comment-list media-list">
			<?php
				$args = array(
					'walker' => new clean_comments_constructor,
				);
				wp_list_comments($args);
			?>
		</ul>
		<?php if (get_comment_pages_count() > 1 && get_option( 'page_comments')) : ?>
		<?php $args = array(
				'prev_text' => '«',
				'next_text' => '»',
				'type'      => 'array',
				'echo'      => false
			); 
			$page_links = paginate_comments_links($args);
			if( is_array( $page_links ) ) {
			    echo '<ul class="pagination comments-pagination">';
			    foreach ( $page_links as $link ) {
			    	if ( strpos( $link, 'current' ) !== false ) echo "<li class='active'>$link</li>";
			        else echo "<li>$link</li>"; 
			    }
			   	echo '</ul>';
		 	}
		?>
		<?php else echo 'Comments not found.'; ?>
	<?php endif; ?>
	<?php if (comments_open()) {
		/* Comment form */
		$fields =  array(
			'author' => '<div class="form-group"><label for="author">Name</label><input class="form-control" id="author" name="author" type="text" value="' . esc_attr($commenter['comment_author']) . '" size="30" required></div>',
			'email'  => '<div class="form-group"><label for="email">Email</label><input class="form-control" id="email" name="email" type="email" value="' . esc_attr($commenter['comment_author_email']) . '" size="30" required></div>',
		);
		$args = array(
			'fields' => apply_filters('comment_form_default_fields', $fields),
			'comment_field' => '<div class="form-group"><label for="comment">Comment:</label><textarea class="form-control" id="comment" name="comment" cols="45" rows="8" required></textarea></div>',
			'must_log_in' => '<p class="must-log-in">You must be logged in! ' . wp_login_url(apply_filters('the_permalink', get_permalink())).'</p>',
			'logged_in_as' => '<p class="logged-in-as">' . sprintf(__( 'Your are logged in as <a href="%1$s">%2$s</a>. <a href="%3$s">Logout?</a>'), admin_url('profile.php'), $user_identity, wp_logout_url(apply_filters('the_permalink', get_permalink()))) . '</p>',
			'comment_notes_before' => '<p class="comment-notes">Your email will be hidden.</p>',
			'comment_notes_after' => '<p class="help-block form-allowed-tags">' . sprintf(__( 'You can use the following <abbr>HTML</abbr> tags: %s'), '<code>' . allowed_tags() . '</code>') . '</p>',
			'id_form' => 'commentform',
			'id_submit' => 'submit',
			'title_reply' => 'Post a new comment',
			'title_reply_to' => 'Ответить %s',
			'cancel_reply_link' => 'Cancel',
			'label_submit' => 'Submit',
			'class_submit' => 'btn'
		);
	    comment_form($args);
	} ?>
</div>