<?php
/*
Plugin Name: WDO Members List
Plugin URI: http://www.webdevsonline.com
Description: Displays a full list of members in alphabetical order using [WDO-memberlist]. Alternatively use a memberlist widget. You can also now use [WDO-memberlistsearch] to include a search for your memberlist, the function uses usernames to find a specific user. You can edit the look through the CSS file. Supports Multi-site. For more information, or if you need help with the plugin, or to request an update, email us at contact@webdevsonline.com.
Version: 1.2.4
Author: Web Devs Online
Author URI: http://www.webdevsonline.com

For more information, email us at contact@webdevsonline.com.

Copyright 2012 Web Devs Online

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as
published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.
*/

function WDOmembersstyle()
{
	$pluginurl = WP_PLUGIN_URL.'/'.str_replace(basename( __FILE__),"",plugin_basename(__FILE__));
 	//echo '<link rel="stylesheet" type="text/css" href="'.$pluginurl.'WDOmembersstyle.css">';
}
add_action( 'wp_head', 'WDOmembersstyle' );

function list_members() {

	global $wpdb;
	
	$prefix = $wpdb->prefix;
	
	$result =  mysql_query('
			SELECT 
				ID
			
			FROM 
				'.$prefix.'users
			
			ORDER 
				BY RAND()
		');
	
	$out = '
			<div class="memberlist">';
	//$out =  "<table id='memberstable'><tr>\n";
	//$out .= "<td id='memberstitle'>Name</td><td id='memberstitle'>Rank</td><td id='memberstitle'>Joined</td></tr>\n";
	$first = true;
	while ($m = mysql_fetch_array($result)) {
		//include('userlevel.php');
		
		$m = get_user_meta($m['ID']);
		
		
		if(isset($m['description']) && $m['description'][0] != '')
		{
			$last = '';
				
			if(!$first)
			{
				$last = ' last';
			}
			
			$img = '';
			if(isset($m['simple_local_avatar']) && $m['simple_local_avatar'][0] != '')
			{
				$i = unserialize($m['simple_local_avatar'][0]);
				$img = '<div class="image"><img src="'.$i['full'].'" alt="'.$m['first_name'][0].'" /></div>';
			}
				
			$out .= '
				<div class="grid one-half'.$last.'">
					<h3>'.$m['first_name'][0].'</h3>
					'.$img.'
					<p>'.$m['description'][0].'</p>
				</div>';
				
			if($first)
			{
				$first = false;
			}
			else
			{
				$first = true;
			}
		}

		//$out .=  "<tr><td id='membersname'>" .$memberlist['user_login'] . "</td><td id='membersrank'>" . $userlevel . "</td><td id='membersjoined'>" . $memberlist['user_registered'] . "</td></tr>\n";
	}
	$out .= '
			</div>';
	
	return $out;

}
 function memberlist_shortcode($atts) 
{ 
	  return list_members();
}
add_shortcode("WDO-memberlist","memberlist_shortcode");

add_action( 'wp_head', 'WDOmembersstyle' );

function list_members_search() {

	global $wpdb;
	
	$prefix = $wpdb->prefix;
	
	$result =  mysql_query("SELECT ".$prefix."users.ID, ".$prefix."users.user_login, ".$prefix."users.user_registered, ".$prefix."usermeta.user_id, ".$prefix."usermeta.meta_key, ".$prefix."usermeta.meta_value FROM ".$prefix."users, ".$prefix."usermeta WHERE ".$prefix."usermeta.user_id = ".$prefix."users.ID AND ".$prefix."usermeta.meta_key = '".$prefix."user_level' ORDER BY user_login ");
	
	include('WDOsearch.php');
	echo search_members();
	echo '<br />';
	echo "<table id='memberstable'><tr>\n";
	echo "<td id='memberstitle'>Name</td><td id='memberstitle'>Rank</td><td id='memberstitle'>Joined</td></tr>\n";
	while ($memberlist = mysql_fetch_array($result)) {
	include('userlevel.php');
	echo  "<tr><td id='membersname'>" .$memberlist['user_login'] . "</td><td id='membersrank'>" . $userlevel . "</td><td id='membersjoined'>" . $memberlist['user_registered'] . "</td></tr>\n";
	}
	echo "</table>";

}
 function memberlistsearch_shortcode($atts) 
{ 
	  echo list_members_search();
}
add_shortcode("WDO-memberlistsearch","memberlistsearch_shortcode");

function list_members_widget() {

	global $wpdb;
	
	$prefix = $wpdb->prefix;
	$resultw =  mysql_query("SELECT ".$prefix."users.ID, ".$prefix."users.user_login FROM ".$prefix."users ORDER BY user_login ");
	while ($memberlistw = mysql_fetch_array($resultw)) {
	echo  $memberlistw['user_login'] . "<br />";
	}
	echo "<br />";

}
function widget_mymemberlist($args) {
    extract($args);

echo $before_widget; 
echo $before_title . 'Members' . $after_title; 
echo list_members_widget();
echo $after_widget; 

}
register_sidebar_widget('Members List',
    'widget_mymemberlist');
?>