<?php 
/**
 * Plugin Name: AA Live Your Site
 * Plugin URI: https://wordpress.org/plugins/aalivesite/
 * Description: A plugin to change urls after a migration from localhost to live or to a new domain. 
 * Version: 1.0
 * Author: aaextention
 * Author URI: http://webdesigncr3ator.com
 * Support Email : contact2us.aa@gmail.com
 * License: GPL2
 **/

	
function aa_create_menu(){
add_menu_page('Url Changer', 'Url Changer', 'administrator', __FILE__, 'aa_url_setting');
}

add_action('admin_menu', 'aa_create_menu');




function aa_url_setting(){

	if(isset($_POST['fromurl'],$_POST['tourl'])){
		//action
	
		global $wpdb;

		/*
		* We'll set the default character set and collation for this table.
		* If we don't do this, some characters could end up being converted 
		* to just ?'s when saved in our table.
		*/
		
		

		$prefix  = $wpdb->prefix; ; 
		
		  $sql = "
		
  UPDATE ".$prefix."options SET option_value = replace(option_value, '{$_POST['fromurl']}', '{$_POST['tourl']}') WHERE option_name = 'home' OR option_name = 'siteurl';

  
UPDATE ".$prefix."posts SET guid = replace(guid, '{$_POST['fromurl']}','{$_POST['tourl']}');

UPDATE ".$prefix."posts SET post_content = replace(post_content, '{$_POST['fromurl']}', '{$_POST['tourl']}');

UPDATE ".$prefix."postmeta SET meta_value = replace(meta_value,'{$_POST['fromurl']}','{$_POST['tourl']}');
		 
		 ";
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );
		
		
	
		echo "Task Done";
		
		
	}


	echo "
	<form method='post' action=''>
		From Url <br>
		<input name='fromurl' type='text'/><br>
		To Url <br>
		<input name='tourl' type='text'/><br>
		<input type='submit' class='btn btn-submit' value='Submit' />
	</form>
	
	";



}
