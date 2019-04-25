<!DOCTYPE html>
<html>
<head>
	<title>PokeBASE - The Pokemon - Guide</title>
	<style type="text/css">
		html{ 
			background: url(FirstPage.jpg); 
			height:100%;
			width:100%;
			background-color: #000;			
		}		
	</style>
</head>
<body>
	<form action="main.php" style="left:775px;top:590px;position:fixed;">
    <button style="background-color: #4CAF50;border: none;padding: 15px 0px;font-size: 16px;margin: 4px 2px;cursor: pointer;color:black;"><font type="">Continue</font></button>
</form>
<div style="left:1075px;top:325px;position:fixed;color:white;">
<?php
$db_connection = pg_connect("host=localhost port=5432 dbname=pokedabe user=postgres password=12345678");
if(!$db_connection)
{
	echo "Error: Unable to open database\n";
	exit();
}
echo "Database Accessed!";
?>
</div>
</body>
</html>