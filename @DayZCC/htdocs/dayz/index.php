<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<?php

session_start();
include ('config.php');
$exe_server = str_replace('.exe', "_".$serverinstance.".exe", $exe_server);
$path_server = str_replace('.exe', "_".$serverinstance.".exe", $path_server);
$exe_bec = str_replace('.exe', "_".$serverinstance.".exe", $exe_server);
$path_bec = str_replace('.exe', "_".$serverinstance.".exe", $path_server);

mysql_connect($database_host, $database_user, $database_password) or die (mysql_error());
mysql_select_db($database_name) or die (mysql_error());

if (isset($_GET['logout']))
{
	$query = "INSERT INTO `log_tool`(`action`, `user`, `timestamp`) VALUES ('LOGOUT','{$_SESSION['login']}',NOW())";
	$sql2 = mysql_query($query) or die(mysql_error());
	
	if (isset($_SESSION['user_id']))
		unset($_SESSION['user_id']);
		
	setcookie('login', '', 0, "/");
	setcookie('password', '', 0, "/");
	header('Location: index.php');
	exit;
}

if (isset($_SESSION['user_id']))
{
	include ('modules/rcon.php');
	include ('modules/tables/rows.php');
	function slashes(&$el)
	{
		if (is_array($el))
			foreach($el as $k=>$v)
				slashes($el[$k]);
		else $el = stripslashes($el); 
	}

	if (ini_get('magic_quotes_gpc'))
	{
		slashes($_GET);
		slashes($_POST);    
		slashes($_COOKIE);
	}

	if (isset($_GET["show"])){
		$show = $_GET["show"];
	}else{
		$show = 0;
	}

	// Start: page-header 
	include ('modules/header.php');
	// End page-header

	if (isset($_GET['view'])){
		include ('modules/'.$_GET["view"].'.php');
	} else {
		include ('modules/dashboard.php');
	}

	// Start: page-footer 
	include ('modules/footer.php');
	// End page-footer
?>
</div>
<!--  end content -->
</div>
<!--  end content-outer........................................................END -->

<div class="clear">&nbsp;</div>
 
</body>
</html>
<?php
}
else
{
	include ($path.'modules/login.php');
}
?>