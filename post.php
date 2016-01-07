<?
require 'db.php';

if($_POST)
	{
	foreach($_POST as $k=>$v)
		{
			// Poor man's injection protection...
			$_POST[$k] = str_replace("'", "&rsquo;", $_POST[$k]);
			$_POST[$k] = str_replace("<", "&lt;", $_POST[$k]);
			$_POST[$k] = str_replace("\"", "&quot;", $_POST[$k]);
		}
	extract($_POST);
	$q = "insert into entries(date,amount,calories,description) values('$date','$amt','$calories','$description')";
	$step1 = $dbh->prepare($q);
	$step1 -> execute();
	header("Location: index.php");
	}

?>
