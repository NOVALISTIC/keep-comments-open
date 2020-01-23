<?php

/*
Plugin Name: Keep Comments Open
Description: Overrides "Automatically close comments" for specific posts if it's enabled, thereby keeping comments open on them indefinitely.
Version: 1.0.0-dev
Author: NOVALISTIC
Author URI: https://NOVALISTIC.com
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
*/

function nv_kco_uninstall() {
	delete_post_meta_by_key( '_nv_kco_override' );
}

function nv_kco_classic_meta_box_additions( $post ) {
	echo "<br />\n";
	
?>
	<label for="nv_kco_override" class="selectit"><input name="nv_kco_override" type="checkbox" id="nv_kco_override" value="1"<?php checked( get_post_meta( $post->ID, '_nv_kco_override', true ) ); ?> /> <?php _e( 'Do not automatically close comments', 'keep-comments-open' ); ?></label>
<?php
	
}

function nv_kco_block_script() {
	wp_enqueue_script( 'keep-comments-open', plugins_url( 'keep-comments-open.js', __FILE__ ) );
}

function nv_kco_save( $post_id ) {
	if ( array_key_exists( 'nv_kco_override', $_POST ) ) {
		update_post_meta( $post_id, '_nv_kco_override', true );
	} else {
		delete_post_meta( $post_id, '_nv_kco_override' );
	}
}

function nv_kco_query_override( $posts, $query ) {
	if ( empty( $posts ) || ! $query->is_singular() ) {
		return $posts;
	}
	
	if ( get_post_meta( $posts[0]->ID, '_nv_kco_override', true ) ) {
		remove_filter( 'the_posts', '_close_comments_for_old_posts' );
	}
	
	return $posts;
}

function nv_kco_comments_override( $open, $post_id ) {
	if ( get_post_meta( $post_id, '_nv_kco_override', true ) ) {
		$post = get_post( $post_id );
		return 'open' == $post->comment_status;
	}
	
	return $open;
}

function nv_kco_pings_override( $open, $post_id ) {
	if ( get_post_meta( $post_id, '_nv_kco_override', true ) ) {
		$post = get_post( $post_id );
		return 'open' == $post->ping_status;
	}
	
	return $open;
}

register_uninstall_hook( __FILE__, 'nv_kco_uninstall' );

add_action( 'post_comment_status_meta_box-options', 'nv_kco_classic_meta_box_additions' );
add_action( 'enqueue_block_editor_assets', 'nv_kco_block_script' );

add_action( 'save_post', 'nv_kco_save' );

if ( get_option( 'close_comments_for_old_posts' ) && (int) get_option( 'close_comments_days_old' ) ) {
	add_filter( 'the_posts', 'nv_kco_query_override', 9, 2 );
	add_filter( 'comments_open', 'nv_kco_comments_override', 11, 2 );
	add_filter( 'pings_open', 'nv_kco_pings_override', 11, 2 );
}

?>