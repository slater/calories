<?
require 'db.php';
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>calories</title>
<style type="text/css">
* {border:0; margin:0; padding:0; font-family: sans-serif; list-style-type: none; box-sizing:border-box; border-collapse: collapse; outline:0; color:#555; text-align:left;}

main {margin:2rem auto; width:60%;}
main article {padding:0 0 1rem 0; margin:0 0 3rem 0;}

h2 {margin:0 0 0.5rem 0; color:#333;}

table {width:100%; border-left:2rem solid #fff;}
td, th {vertical-align: top; border-bottom:1px solid #eee; padding:10px 3px;}
tr th:first-of-type, tr td:first-of-type  {padding-left:0;}
tr:hover td {background-color:lightyellow; color:#000;}
td:last-of-type {padding-right:0;}
tr:last-of-type td{border:0; border-top:2px solid #aaa; font-weight: bold; color:#222;}
.tr {text-align: right; padding-right:0;}
th {font-size:small;}


form {margin:0 0 2rem 0; padding:0 0 1rem 0; border-bottom:2px solid #eee; text-align: center;}
input[type=text], input[type=date] {padding:5px 7px 4px 10px; border:1px solid #ccc; border-radius: 3px 3px; height:30px; width:20%;}
input[type=text]:focus, input[type=date]:focus {background-color:lightyellow; border:1px solid #aaa;}
input[type=submit] {height:30px; padding:5px 20px; border-radius: 3px 3px; cursor: pointer; color:#222;}
input[type=submit]:hover {color:#fff; background-color:#333;}
small, small * {font-size:x-small;}
@media only screen and (max-width: 700px) {
    main {width:auto; margin:1rem 10%;}
}

</style>
</head>
<body>
<main>
<form action="post.php" method="post">
<input type="text" placeholder="#" style="width:9%" name="amt"/>
<input type="text" placeholder="Description" name="description"/>
<input type="text" placeholder="Calories per serving" name="calories"/>
<input type="date" name="date" id="datetime" value="<?echo date('Y-m-d');?>"/>
<input type="submit" value="+ Add">
<br/>
<small>Ex.: Entering <i>3</i>, <i>Beer</i>, and <i>400</i> will result in an entry of 3 beers &agrave; 400 calories, and a calculated total of 1,200 calories for that entry.<br/>
Find items on <a href="http://www.calorieking.com/foods/" target="_blank">CalorieKing</a> if the calories aren&rsquo;t listed on the packaging.</small>
</form>

<?

// Spaghetti code ahead. Sorry :(

$q = "select *,date_format(date,'%a, %M %D %Y') as thedate from entries order by date desc";
$result = $dbh->query($q);
while($row = $result->fetch_assoc())
	{
	$numres = $result->num_rows;
	$e++;
	extract($row);

	// If there's a date mismatch, we close the old article, reset the variables, and start a new article.
	if($olddate !== $date) {
		
		if(isset($olddate)) {echo "\n<tr><td>Total</td><td colspan=\"2\" class=\"tr\">".number_format($dailyamount)." calories</td></tr>\n</table>\n</article>\n";}
		$dailyamount = 0;
		$olddate = $date;
		$itemamount = $amount * $calories;		
		$dailyamount = $dailyamount + $itemamount;
		$displaydate;
		echo "\n\n<article>\n<h2>$thedate</h2>\n<table>\n<tr><th>Description</th><th class=\"tr\">Cal. per serving</th><th class=\"tr\">Total</th>";
		echo "\n<tr><td>".$amount."x $description</td><td class=\"tr\">".number_format($calories)."</td><td class=\"tr\">".number_format($itemamount)."</td></tr>";


	}
	else
		{
		$itemamount = $amount * $calories;
		$dailyamount = $dailyamount + $itemamount;
		echo "\n<tr><td>".$amount."x $description</td><td class=\"tr\">".number_format($calories)."</td><td class=\"tr\">".number_format($itemamount)."</td></tr>";
		}
	if($e == $numres) {echo "\n<tr><td>Total</td><td colspan=\"2\" class=\"tr\">".number_format($dailyamount)." calories</td></tr>";}
	}
	echo "\n</table>\n</article>\n";
?>
</main>
</body>
</html>