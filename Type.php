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
  <style type="text/css">
.normal{background-color: #A8A77A;color:#e5e5e5;text-align: center;font-family: georgia;}
.fire{background-color: #EE8130;color:#e5e5e5;text-align: center;font-family: georgia;}
.water{background-color: #6390F0;color:#e5e5e5;text-align: center;font-family: georgia;}
.electric{background-color: #F7D02C;color:#e5e5e5;text-align: center;font-family: georgia;}
.grass{background-color: #7AC74C;color:#e5e5e5;text-align: center;font-family: georgia;}
.ice{background-color: #96D9D6;color:#e5e5e5;text-align: center;font-family: georgia;}
.fighting{background-color: #C22E28;color:#e5e5e5;text-align: center;font-family: georgia;}
.poison{background-color: #A33EA1;color:#e5e5e5;text-align: center;font-family: georgia;}
.ground{background-color: #E2BF65;color:#e5e5e5;text-align: center;font-family: georgia;}
.flying{background-color: #A98FF3;color:#e5e5e5;text-align: center;font-family: georgia;}
.psychic{background-color: #F95587;color:#e5e5e5;text-align: center;font-family: georgia;}
.bug{background-color: #A6B91A;color:#e5e5e5;text-align: center;font-family: georgia;}
.rock{background-color: #B6A136;color:#e5e5e5;text-align: center;font-family: georgia;}
.ghost{background-color: #735797;color:#e5e5e5;text-align: center;font-family: georgia;}
.dragon{background-color: #6F35FC;color:#e5e5e5;text-align: center;font-family: georgia;}
.dark{background-color: #705746;color:#e5e5e5;text-align: center;font-family: georgia;}
.steel{background-color: #B7B7CE;color:#e5e5e5;text-align: center;font-family: georgia;}
.fairy{background-color: #D685AD;color:#e5e5e5;text-align: center;font-family: georgia;}
}
  </style>
</head>
<body bgcolor="#292826">
  <div style="background-color: #F9D342;top:0px;left:0px;height:100%;width:300px;position: fixed;text-align: center;font-family: georgia;font-size: 30px;font-weight: bold;">
   <img src="download.png" height="100px" width="300px">
<a href="/main.php" style="color:#292826;text-decoration: none"><div>Pokemon</div></a>
<a href="/Item.php" style="text-decoration: none;color:#292826"><div>Items</div></a>
<a href="/Type.php" style="text-decoration: none"><div style="background-color: #292826;font-size:35px;color:#F9D342;">Types</div></a>
<a href="/Trainer.php" style="text-decoration: none;color:#292826"><div style="">Trainer</div></a>
<a href="/Attacks.php" style="color:#292826;text-decoration: none"><div>Attacks</div></a>
<a href="/Region.php" style="color:#292826;text-decoration: none"><div>Region</div></a>
<a href="/PokeGym.php" style="color:#292826;text-decoration: none"><div>Pokemon Gym</div></a>
<a href="/Location.php" style="color:#292826;text-decoration: none"><div>Pokemon Found In</div></a>
<br/><br/>
<img src="5Pikachu.png" height="325px" width="300px">
</div>
<div style="top:0px;left:300px;height:750px;width: 1000px;position: absolute;">
<div style="background-color: #F9D342;top:0px;left:0px;height:40px;width:1230px;position: relative;text-align: center;"><center><h1>POKEMON TYPES</h1></center></div>
<br />
<div style="top:60px;left:150px;position:relative;">
  <table cellspacing="5px">
<?php
   $query = "SELECT name FROM Type;";
   $result = pg_query($db_connection, $query);
   if(!$result)
   {
      echo pg_last_error($db_connection);
      exit();
   }
   echo '<tr>';
   $i = 0;
   while($row = pg_fetch_row($result))
   {
      if($i==9)
      {
        echo '</tr>';
        echo '<tr>';
        $i=0;
      }
      echo '<td><a href = "Typeinfo.php?type='.$row[0].'" style = "text-decoration: none;" ><div class="'.strtolower($row[0]).'" style="height:60px;width:100px;"><br/>'.$row[0].'</div></a></td>';
      $i = $i+1;
   }
   echo '</tr>';
   pg_close($db_connection);
?>
</table>
</div>
</div>
</body>
</html>
