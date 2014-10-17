<?php

function search_members() {

	global $wpdb;
	
	$prefix = $wpdb->prefix;
	$url = (!empty($_SERVER['HTTPS'])) ? "https://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'] : "http://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
	$action = mysql_real_escape_string($url);
	
	$search = $_POST['search'];
	
	if (empty($search)){
	
	?>

<form name="searchmembers" action="<?php echo $action ?>" id="searchmem" method="post" >
Search for a member: <input type="text" name="search" id="search" size="20" />
<input type="submit" id="go" value="Search"  />
</form>
<?php
}
if (!empty($search)){

$sqls = mysql_query("SELECT ".$prefix."users.ID, ".$prefix."users.user_login, ".$prefix."users.user_registered, ".$prefix."usermeta.user_id, ".$prefix."usermeta.meta_key, ".$prefix."usermeta.meta_value FROM ".$prefix."users, ".$prefix."usermeta WHERE ".$prefix."usermeta.user_id = ".$prefix."users.ID AND ".$prefix."usermeta.meta_key = '".$prefix."user_level' AND ".$prefix."users.user_nicename LIKE '%".$search."%' ORDER BY ID");


?>
<form name="searchmembers" action="<?php echo $action ?>" id="searchmem" method="post" >
Search for a member: <input type="text" name="search" id="search" size="20" />
<input type="submit" id="go" value="Search"  />
</form>
<br />
<?php
echo "Search results for " . $search . " <br />";
echo "<table>";
	while($searchres = mysql_fetch_array($sqls)){
	include('userlevel.php');
	echo "<tr><td id='membersname'>" .$searchres['user_login'] . "</td><td id='membersrank'>" . $userlevel2 . "</td><td id='membersjoined'>" . $searchres['user_registered'] . "</td></tr>";
}
echo "</table>";
}
}
?>