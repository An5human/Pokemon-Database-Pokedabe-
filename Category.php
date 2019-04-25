<?php
$db_connection = pg_connect("host=localhost port=5432 dbname=pokedabe user=postgres password=12345678");
if(!$db_connection)
{
	echo "Error: Unable to open database\n".pg_last_error();
	exit();
}
if($_SERVER['REQUEST_METHOD']=="POST")
  {
    $C=$_POST["Category"];
  }

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>PokeBase</title>
  <style type="text/css">
  	table {
  border-collapse: collapse;
  top:0px;
  left:500px; 
  width:1000px;
  table-layout: fixed;word-wrap: break-word;
}

th, td {
  text-align: left;
  padding: 8px;
  text-align: center;font-family: georgia;font-size: 15px;font-weight: bold;
  color:#0b6623;	
}

tr:nth-child(even){background-color: #F9D342;}

th {
  color: #F9D342;
  background-color: #292826;
  text-align: center;font-family: georgia;font-size: 18px;font-weight: bold;
}
  </style>
</head>
<body bgcolor="#292826">
  <div style="background-color: #F9D342;top:0px;left:0px;height:100%;width:300px;position: fixed;text-align: center;font-family: georgia;font-size: 30px;font-weight: bold;">
   <img src="download.png" height="100px" width="300px">
<a href="/main.php" style="color:#292826;text-decoration: none"><div>Pokemon</div></a>
<a href="/Item.php" style="text-decoration: none"><div style="background-color: #292826;font-size:35px;color:#F9D342;">Items</div></a>
<a href="/Type.php" style="text-decoration: none;color:#292826"><div style="">Types</div></a>
<a href="/Trainer.php" style="text-decoration: none;color:#292826"><div style="">Trainer</div></a>
<a href="/Attacks.php" style="color:#292826;text-decoration: none"><div>Attacks</div></a>
<a href="/Region.php" style="color:#292826;text-decoration: none"><div>Region</div></a>
<a href="/PokeGym.php" style="color:#292826;text-decoration: none"><div>Pokemon Gym</div></a>
<a href="/Location.php" style="color:#292826;text-decoration: none"><div>Pokemon Found In</div></a>
<br/><br/>
<img src="5Pikachu.png" height="325px" width="300px">
</div>
<div style="background-color: #F9D342;top:0px;left:400px;height: 250px;width: 1000px;position:relative;color: #292826">
<center><H1>ITEMS</H1>
<p>An Item is an object in the Pokemon Games which the player can pick up,keep in their Bag, and use in some manner. They have various uses, including healing, powering Up, helping one catch Pokemon, or to access a new area. Items are Obtained in several ways. They can be given to the player by characters within the game, be brought at a PokeMart with money, or found by the player throughout the pokeworld. The Items Are classified as:
<?php 
$query = "SELECT Distinct Category FROM Items;";
   $result = pg_query($db_connection, $query);
   if(!$result)
   {
      echo pg_last_error($db_connection);
      exit();
   }
   while($row = pg_fetch_row($result))
   {
    if($row[0]!=''){
      echo $row[0].', ';
    }
   }
?></p>
<?php 
$query = "SELECT Count(*) FROM Items WHERE Category = '".$C."';";
   $result = pg_query($db_connection, $query);
   if(!$result)
   {
      echo pg_last_error($db_connection);
      exit();
   }
   echo 'Total Number of Items:';
   while($row = pg_fetch_row($result))
   {
      echo $row[0];
   }
?>
<br />
<br />
<form action= 'SearchItem.php' method="post">
  <input type="text" name="name" placeholder="Item Name" style="width: 150px;box-sizing: border-box;border: 1px solid #ccc;border-radius: 5px;font-size: 13px;">
  <input type="submit" value = "Search" style = "cursor:pointer;border: 1px solid #ccc;border-radius: 5px;font-size: 10px;">
  </form>
  <form action = 'Category.php' method="post">
    <select name = 'Category' style="width: 150px;box-sizing: border-box;border: 1px solid #ccc;border-radius: 5px;font-size: 13px;">
    <?php 
      $query = "SELECT Distinct Category FROM Items;";
      $result = pg_query($db_connection, $query);
      if(!$result)
      {
        echo pg_last_error($db_connection);
        exit();
      }
      while($row = pg_fetch_row($result))
      {
        if($row[0]!=''){
          echo '<option value = "'.$row[0].'"">'.$row[0].'</option>';
        }
   }
?>
    </select>
      <input type="submit" value = "   Sort   " style = "cursor:pointer;border: 1px solid #ccc;border-radius: 5px;font-size: 10px;">
    </form>
</center>
</div>
<div style="top:30px;left:400px;position: relative;">
<?php
   $query = "SELECT * FROM Items WHERE Category = '".$C."';";
   $result = pg_query($db_connection, $query);
   if(!$result)
   {
      echo pg_last_error($db_connection);
      exit();
   } 
   echo '<table><tr><th>Item Name</th><th>Category</th><th>Description</th></tr>';
   while($row = pg_fetch_row($result))
   {
   		echo '<tr><td>'.$row[0].'</td><td>'.$row[1].'</td><td>'.$row[2].'</td></tr>';
   }
   echo '</table>';
   pg_close($db_connection);
?>
</div>
</body>
</html>
