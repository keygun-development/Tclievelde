<?php

/**
 * Handles callbacks from comment functions.
 *
 * @param WP_Comment $comment The comment itself.
 * @param array      $args    An array of arguments.
 * @param int        $depth
 *
 * @see https://codex.wordpress.org/Function_Reference/wp_list_comments
 */
function proa_comments( WP_Comment $comment, array $args, int $depth ) {
	$GLOBALS['comment'] = $comment;
	$comment_style      = $args['style'];

	if ( $comment_style === 'div' ) {
		$tag       = 'div';
		$add_below = 'comment';
	} else {
		$tag       = 'li';
		$add_below = 'div-comment';
	}

	echo sprintf( '<%s %s id="comment-%s">',
		esc_html( $tag ),
		implode( ' ', get_comment_class( empty( $args['has_children'] ) ? '' : 'parent' ) ),
		get_comment_ID()
	);
	?>
	<?php if ( $comment_style !== 'div' ) { ?>
        <div id="div-comment-<?php comment_ID(); ?>" class="comment-body">
	<?php } ?>

    <div class="comment-author vcard">
		<?php if ( $args['avatar_size'] !== 0 ) {
			echo get_avatar( $comment, $args['avatar_size'] );
		} ?>
		<?php echo sprintf( '<cite class="fn">%s</cite> <span class="says">zegt</span>', get_comment_author_link() ); ?>
        op
        <a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>">
			<?php echo sprintf( esc_html( '%1$s - %2$s' ), get_comment_date(), get_comment_time() ) ?>
        </a>
        :
    </div>

	<?php if ( $comment->comment_approved == '0' ) { ?>
        <em class="comment-awaiting-moderation"><?php esc_html_e( 'Je reactie wacht op goedkeuring.', 'nppl' ) ?></em>
        <br/>
	<?php }
;
	comment_text();
	?>

    <div class="reply">
		<?php comment_reply_link( array_merge( $args,
			array( 'add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ) ?>
    </div>

	<?php
	if ( $comment_style !== 'div' ) {
		echo '</div>';
	};
}