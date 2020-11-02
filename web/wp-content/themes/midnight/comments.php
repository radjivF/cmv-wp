<?php
/**
 * The template for displaying Comments.
 * The area of the page that contains both current comments
 * and the comment form.
 */

/**
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="comments-area<?php echo ! have_comments() ? ' bw-no-comments' : ''; ?>">

	<?php // You can start editing here -- including this comment! ?>

	<?php if ( have_comments() ) : ?>
		<h2 class="comments-title bw-title-inner">
			<?php
                $comment_number = get_comments_number();
                echo esc_html__('Comments', 'midnight');
                echo ' (' . sprintf( '%02d', $comment_number ) . ')';
			?>
		</h2>

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
		<nav id="comment-nav-above" class="comment-navigation" role="navigation">
			<h1 class="screen-reader-text"><?php esc_html_e( 'Comment navigation', 'midnight' ); ?></h1>
			<div class="nav-previous"><?php previous_comments_link( esc_html__( '&larr; Older Comments', 'midnight' ) ); ?></div>
			<div class="nav-next"><?php next_comments_link( esc_html__( 'Newer Comments &rarr;', 'midnight' ) ); ?></div>
		</nav><!-- #comment-nav-above -->
		<?php endif; // check for comment navigation ?>

		<ol class="comment-list">
			<?php
				wp_list_comments( array(
					'style'      => 'ol',
					'short_ping' => true,
					'avatar_size'=> 64
				) );
			?>
		</ol><!-- .comment-list -->

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
		<nav id="comment-nav-below" class="comment-navigation" role="navigation">
			<h1 class="screen-reader-text"><?php esc_html_e( 'Comment navigation', 'midnight' ); ?></h1>
			<div class="nav-previous"><?php previous_comments_link( esc_html__( '&larr; Older Comments', 'midnight' ) ); ?></div>
			<div class="nav-next"><?php next_comments_link( esc_html__( 'Newer Comments &rarr;', 'midnight' ) ); ?></div>
		</nav><!-- #comment-nav-below -->
		<?php endif; // check for comment navigation ?>

	<?php endif; // have_comments() ?>

	<?php
		// If comments are closed and there are comments, let's leave a little note, shall we?
		if ( ! comments_open() && '0' != get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
	?>
		<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'midnight' ); ?></p>
	<?php endif; ?>

	<?php 
	
	$commenter = wp_get_current_commenter();
	$req = get_option( 'require_name_email' );
	$aria_req = ( $req ? " aria-required='true'" : '' );
	
	$comment_args = array(
		'<p class="comment-form-comment"><label for="comment">' . esc_html__( 'Comment', 'midnight' ) . '</label><textarea id="comment" name="comment" cols="45" rows="8" aria-required="true"></textarea></p>',
		'title_reply'=>'Post a new comment',
		'fields' => apply_filters( 'comment_form_default_fields', 
			array(
				'author' => '<p class="comment-form-author"><input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . ' placeholder="' . esc_html__( 'Name', 'midnight' ) . ( $req ? ' *' : '' ) . '"></p>',   
				'email'  => '<p class="comment-form-email"><input id="email" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30"' . $aria_req . ' placeholder="' . esc_html__( 'Email', 'midnight' ) . ( $req ? ' *' : '' ) . '"></p>',
				'url'    => '<p class="comment-form-url"><input id="url" name="url" type="text" value="' . esc_attr(  $commenter['comment_author_url'] ) . '" size="30"' . $aria_req . ' placeholder="' . esc_html__( 'Website', 'midnight' ) . '"></p>'
			)
		),
		'comment_field' => '<p><textarea id="comment" name="comment" cols="45" rows="8" aria-required="true" placeholder="' . esc_html__( 'Message', 'midnight' ) . '"></textarea></p>',
		'comment_notes_before' => '',
		'comment_notes_after' => '',
		'label_submit' => esc_html__( 'Post Comment', 'midnight' ),
		'title_reply_to' => esc_html__( 'Leave a reply', 'midnight' ),
		'cancel_reply_link' => esc_html__( 'Cancel', 'midnight' ),
	);
	
	comment_form($comment_args); ?>

</div><!-- #comments -->
