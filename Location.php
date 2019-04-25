<?php
$db_connection = pg_connect("host=localhost port=5432 dbname=pokedabe user=postgres password=12345678");
if(!$db_connection)
{
	echo "Error: Unable to open database\n".pg_last_error();
	exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>PokeBase</title>
<style type="text/css">img{
  background-image: url(pokemonback.png);
  background-size: cover;
}
  </style>

</head>
<body bgcolor="#292826">
  <div style="background-color: #F9D342;top:0px;left:0px;height:100%;width:300px;position: fixed;text-align: center;font-family: georgia;font-size: 30px;font-weight: bold;">
   <img src="download.png" height="100px" width="300px">
<a href="/main.php" style="text-decoration: none;color:#292826;"><div style="">Pokemon</div></a>
<a href="/Item.php" style="text-decoration: none;color:#292826"><div style="">Items</div></a>
<a href="/Type.php" style="text-decoration: none;color:#292826"><div style="">Types</div></a>
<a href="/Trainer.php" style="text-decoration: none;color:#292826"><div style="">Trainer</div></a>
<a href="/Attacks.php" style="color:#292826;text-decoration: none"><div>Attacks</div></a>
<a href="/Region.php" style="color:#292826;text-decoration: none"><div>Region</div></a>
<a href="/PokeGym.php" style="color:#292826;text-decoration: none"><div>Pokemon Gym</div></a>
<a href="/Location.php" style="text-decoration: none"><div style="background-color: #292826;font-size:35px;color:#F9D342;">Pokemon Found In</div></a>
<br/>
<img src="Ash_SM.png" height="375px" width="300px">
</div>
<div style="top:0px;left:400px;height:100%;width: 1100px;position: absolute;">
<div style="background-color: #F9D342;top:0px;left:400px;height:40px;width: 1040px;"><center><h1>Location In The Kanto</h1></center></div>
<br />
<div style="background-color: #F9D342;top:0px;left:400px;height:40px;width: 1040px;"><center><h1>Towns</h1></center></div>
</br>
<?php
  $query = "select Distinct town_name from pokemon_found_in_town;";
  $result = pg_query($db_connection, $query);
  if(!$result)
  {
    echo pg_last_error($db_connection);
    exit();
  }
  $i = 0;
  echo '<table style = "top:20px;left:400px;">';
   while($row = pg_fetch_row($result))
   {
      if($i==10)
      {
        echo '</tr>';
        echo '<tr>';
        $i=0;
      }
      echo '<td><a href = "Towninfo.php?name='.$row[0].'" style = "text-decoration: none;color:#292826"><div style="background-color:#F9D342;height:60px;width:100px;"><b><center><br/>'.$row[0].'</div></center></b></a></td>';
      $i = $i+1;
   }
   echo '</tr>';
   echo '</table>';
   
?>
<div style="background-color: #F9D342;top:10px;left:400px;height:40px;width: 1040px;"><center><h1>Route</h1></center></div>
<br />
<?php 
  $query = "SELECT name FROM routes;";
  $result = pg_query($db_connection, $query);
  if(!$result)
  {
    echo pg_last_error($db_connection);
    exit();
  }
  $i = 0;
  echo '<table style = "top:20px;left:400px;">';
   while($row = pg_fetch_row($result))
   {
      if($i==10)
      {
        echo '</tr>';
        echo '<tr>';
        $i=0;
      }
      echo '<td><a href = "Routeinfo.php?num='.$row[0].'" style = "text-decoration: none;color:#292826"><div style="background-color:#F9D342;height:60px;width:100px;"><b><center><br/>Route '.$row[0].'</div></center></b></a></td>';
      $i = $i+1;
   }
   echo '</tr>';
   echo '</table>';
?>
</div>
<?php pg_close($db_connection);?>
</body>
</html>
