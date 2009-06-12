<?php
/*
 *  This file is part of Bobby Heartrate's Mafia Tools.
 *
 *  Bobby Heartrate's Mafia Tools is free software: you can
 *  redistribute it and/or modify it under the terms of the GNU Affero
 *  General Public License as published by the Free Software
 *  Foundation, either version 3 of the License, or (at your option)
 *  any later version.
 *
 *  Bobby Heartrate's Mafia Tools is distributed in the hope that it
 *  will be useful, but WITHOUT ANY WARRANTY; without even the implied
 *  warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *  See the GNU Affero General Public License for more details.
 *
 *  You should have received a copy of the GNU Affero General Public
 *  License along with Bobby Heartrate's Mafia Tools.  If not, see
 *  <http://www.gnu.org/licenses/>.
 */

require_once "localsettings.php";

$_dbcon = null;
function db_get_con() {
	global $_dbcon;
	if (!$_dbcon) 
		$_dbcon = db_connect();
	return $_dbcon;
}

function my_sprintf($format, $arg1) {
	// like a sprintf, but all argument strings are escaped
	$args = func_get_args();
	$args = array_slice($args, 0, 1, true) + 
			array_map("mysql_real_escape_string", array_slice($args, 1, count($args) - 1, true));
    return call_user_func_array('sprintf', $args);
}

function run_sql($sql, $con) {
	$result = mysql_query($sql, $con);
	if (!$result) {
		die('<p>Failed query:</p><blockquote>'.htmlspecialchars($sql).'</blockquote><p>Error: '.mysql_error().'</p>');
	}
	return $result;
}

function db_connect() {
	$settings = get_local_settings();
	$con = mysql_connect($settings['server'], $settings['user'], $settings['password']);
	if (!$con) 
		die('Could not connect: ' . mysql_error());
	if (!mysql_select_db($settings['database']))
		die('Could not use database: ' . mysql_error());
	return $con;
}

function db_create_user($id, $con) {
	// Returns TRUE if it created it, FALSE if the user already existed. Dies on other errors.
	$sql = my_sprintf("INSERT INTO users (`fbid`) VALUES ('%s');", $id);
	$result = mysql_query($sql, $con);
	if (mysql_errno() == 1062)  // ER_DUP_ENTRY
		return FALSE;
	else if (mysql_errno() != 0) 
		die('Could not create user: ' . mysql_error());
	return TRUE;
}

function db_delete_user($id, $con) {
	$sql = my_sprintf("DELETE FROM users WHERE fbid='%s'",
					  $id);
	return mysql_query($sql);
}

function db_set_alias($id, $alias, $con) {
	// Returns TRUE if OK, FALSE if the alias already existed. Dies on other errors.
	// TODO: VERIFY ALIAS
	$sql = my_sprintf("UPDATE users SET alias='%s' WHERE fbid='%s'",
					  $alias, $id);
    $result = mysql_query($sql, $con);
	if (!$result) {
		if (mysql_errno() == 1062) { // ER_DUP_ENTRY
			return FALSE;
		}
		die ("Could not set alias '$alias' on id '$id': " . mysql_error());
	}
	return TRUE;
}

function db_get_alias($id, $con = null) {
	if(is_null($con)) $con = db_get_con();
	
	// Returns the alias, or null if it doesn't exist
	$sql = my_sprintf("SELECT alias FROM users WHERE fbid='%s'",
					  $id);
	$result = mysql_query($sql, $con);
	if($row = mysql_fetch_array($result)) 
		return $row['alias'];
	return null;
}

function db_get_id_by_alias($alias, $con) {
	// Return the ID, or null if there is no user by that alias
	$sql = my_sprintf("SELECT fbid FROM users WHERE alias='%s'", 
					  $alias);
	$result = mysql_query($sql, $con);
	if($row = mysql_fetch_array($result)) 
		return $row['fbid'];
	return null;
}

function db_get_users($con) {
	$sql = "SELECT * FROM users";
	$result = run_sql($sql, $con);
	return $result;
}

function db_dump_xml($con) {
	$result = db_get_users($con);
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	echo "<bhmt_users>\n";
	while ($row = mysql_fetch_array($result)) {
		echo "\t<user id=\"$row[fbid]\">\n";
		echo "\t\t<alias>$row[alias]</alias>\n";
		echo "\t</user>\n";
	}
	echo "</bhmt_users>\n";
}


?>