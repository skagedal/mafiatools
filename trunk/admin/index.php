<?php 
require_once '../bhmt.php';
require_once '../db.php';
require_once '../sweet.php';

disable_magic_quotes();

$con = db_connect();

function head() {
?>
<html><head><title>BHMT Admin</title></head>
<body>
<?php
}

function create_tables($con) {
	echo('<p>Let\'s create some tables...</p>');
	// run_sql('DROP TABLE users', $con);
	// Unik ID
	$sql = "
		CREATE TABLE users
		(
			fbid  			BIGINT NOT NULL,
			alias			VARCHAR(40),
			gamename		VARCHAR(80),
			comment			TEXT,
			want_hitlist	TINYINT NOT NULL DEFAULT '0',
			want_attack		TINYINT NOT NULL DEFAULT '0',
			want_punch		TINYINT NOT NULL DEFAULT '0',
			is_public		TINYINT NOT NULL DEFAULT '1',
			hitlist_amount1	INT NOT NULL DEFAULT '10000',
			hitlist_amount2	INT NOT NULL DEFAULT '100000',
			hitlist_amount3	INT NOT NULL DEFAULT '1000000',
			PRIMARY KEY (fbid),
			UNIQUE (alias)
		) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_bin";

	run_sql($sql, $con);
		
	echo ('<p>Created tables!</p>');
}

function insert_values($con) {
	$example_users = array(
		'bobby'				=> '1463977030',
		'syd'				=> '1528311918',
		'teejay'			=> '1407531116',
		'charlie_the_gull'	=> '584088564',
		'sandy'				=> '504354615',
		'monkey'			=> '1321527445',
		'giancarlo'			=> '1485356529',	
		'cara'				=> '1429336216',	
		'faye'				=> '1331318782',
		'aj'				=> '1469989937',
		'robberbaron'		=> '1438002032',
		'bigarte'			=> '804735014',
		'charles'			=> '507175190',
		'slick_vick'		=> '1127760338',
		'luna'				=> '1308519916',
		'sanderson'			=> '691812887',
		'cossazezza'		=> '1491386241',
		'p2saint'			=> '1176739002',
		'pigro'				=> '1567811929',
		'sbg_bigmama'		=> '665775684',
		'big_sis'			=> '619226135',
		'syrmo'				=> '18904554',
		'steve_rigatoni'	=> '1422953248',
		'danashawnmccord'	=> '769672578',
		'rambo'				=> '1287510349',
		'flea'				=> '1377710245',
		'shana'				=> '1469416271',
		'toyharley23'		=> '1622754587',
		'ashley'			=> '1132305323',
		'grande_cajones'	=> '1369969968',
		'the_shank'			=> '1605030002',
		'hacksaw'			=> '583242658'
	);
	echo('<p>Let\'s insert some example values...</p>');
	foreach ($example_users as $alias => $fbid) {
		if(db_create_user($fbid, $con)) {
			if(!db_set_alias($fbid, $alias, $con))
				echo ("Alias $alias already existed.<br />");
		} else {
			echo ("User $fbid already existed; not setting alias.<br />");
		}
	}	
}

if (array_key_exists('cmd', $_GET)) {
	$cmd = $_GET['cmd'];
	switch ($cmd) {
		case 'create_tables':
			head();
			create_tables($con);
			break;
		case 'insert_values':
			head();
			insert_values($con);
			break;
		case 'create_user':
			head();
			if (!db_create_user($_GET['id'], $con)) 
				echo ("<p>User with id $_GET[id] already existed</p>");
			if (!db_set_alias($_GET['id'], $_GET['alias'], $con))
				echo ("<p>The alias $_GET[alias] already existed</p>");
			break;
		case 'delete_user':
			head();
			db_delete_user($_GET['id'], $con);
			break;
		case 'set_alias':
			head();
			echo 'We will set the alias which is '.$_GET['alias'].'<br />';
			if (!db_set_alias($_GET['id'], $_GET['alias'], $con))
				echo "<p>The alias $_GET[alias] already existed</p>";
			break;
		case 'show_alias':
			head();
			if($alias = db_get_alias($_GET['id'], $con))
				echo "<p>$_GET[id] has alias $alias.</p>";
			else
				echo "<p>$_GET[id] is not in the database.</p>";
			break;
		case 'show_fbid':
			head();
			if ($id = db_get_id_by_alias($_GET['alias'], $con))
				echo "<p>$_GET[alias] has ID $id.</p>";
			else
				echo "<p>$_GET[alias] is not in teh database.</p>";
			break;
		case 'dump_xml':
			header("Content-type: text/xml");
			db_dump_xml($con);
			die();
			break;
		case 'view_log':
			head();
			echo str_replace("\n", "<br />", file_get_contents(bhmt_get_log_filename()));
		default:
			head();
			break;
	}
}
?>
<ul>
<li><a href="/admin/">Start</li>
<li><a href="javascript:location.href='/admin/?cmd=create_user&id='+document.getElementById('idval').value+'&alias='+document.getElementById('alias').value">Create user</a>
<li><a href="javascript:location.href='/admin/?cmd=show_alias&id='+document.getElementById('idval').value">Show alias</a></li>
<li><a href="javascript:location.href='/admin/?cmd=show_fbid&alias='+document.getElementById('alias').value">Show ID from alias</a></li>
<li><a href="/admin/?cmd=create_tables">Create tables</a></li>
<li><a href="/admin/?cmd=insert_values">Insert example values</a></li>
<li><a href="/admin/?cmd=dump_xml">Dump database as XML</a></li>
<li><a href="/admin/?cmd=view_log">View log file</a></li>
</ul>
<p>Date is <?php echo date("c"); ?>.</p>
<table border="0">
<tr><td>ID:</td><td><input type="text" id="idval"></td></tr>
<tr><td>Alias:</td><td><input type="text" id="alias"></td></tr>
</table>
<?php 
$result = db_get_users($con);
?> <table border="1" style="border-collapse: collapse"> 
<tr><th>ID</th><th>alias</th><th>actions</th></tr>
<?php
while ($row = mysql_fetch_array($result)) {
	echo "<tr>
		<td><a href=\"/user/$row[fbid]/\">$row[fbid]</a></td>
		<td>$row[alias]</td>
		<td>
			<a href=\"/admin/?cmd=delete_user&id=$row[fbid]\">delete</a>
			<a href=\"javascript:location.href='/admin/?cmd=set_alias&id=$row[fbid]&alias='+document.getElementById('alias').value\">set_alias</a>
		</td>
	</tr>"	;
}
?>
</table>

</body>
</html>
