<?php
/*
Plugin Name: Require thumbnail
Plugin URI: http://www.webfish.se/wp/plugins/require-thumbnails
Description: Prevents an user to publish a post without a thumbnail. 
Version: 0.1.0
Author: Tobias Nyholm
Author URI: http://www.tnyholm.se

Copyright: Tobias Nyholm 2010
License: GPL3
*/

add_action ( 'publish_post', 'rt_checkForThumbnail',1 );

function rt_checkForThumbnail($postID){
	if(!has_post_thumbnail($postID)){
		//re-save as draft
		global $wpdb;
		$wpdb->query("
			UPDATE $wpdb->posts SET post_status = 'draft'
			WHERE ID = $postID");	
		
		//prevent other hooks to publish_post
		redirect_post($postID);
		exit;
	}
}