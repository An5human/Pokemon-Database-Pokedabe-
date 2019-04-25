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
    .column {
    
  float: left;
  width: 22.67%;
  padding: 5px;
}

/* Clear floats after image containers */
.row::after {
  content: "";
  clear: both;
  display: table;
}
img{
  background-image: url(pokemonback.png);
  background-size: cover;
}
  </style>

</head>
<body bgcolor="#292826">
  <div style="background-color: #F9D342;top:0px;left:0px;height:100%;width:300px;position: fixed;text-align: center;font-family: georgia;font-size: 30px;font-weight: bold;">
   <img src="download.png" height="100px" width="300px">
<a href="/main.php" style="text-decoration: none"><div style="background-color: #292826;font-size:35px;color:#F9D342;">Pokemon</div></a>
<a href="/Item.php" style="text-decoration: none;color:#292826"><div style="">Items</div></a>
<a href="/Type.php" style="text-decoration: none;color:#292826"><div style="">Types</div></a>
<a href="/Trainer.php" style="text-decoration: none;color:#292826"><div style="">Trainer</div></a>
<a href="/Attacks.php" style="color:#292826;text-decoration: none"><div>Attacks</div></a>
<a href="/Region.php" style="color:#292826;text-decoration: none"><div>Region</div></a>
<a href="/PokeGym.php" style="color:#292826;text-decoration: none"><div>Pokemon Gym</div></a>
<a href="/Location.php" style="color:#292826;text-decoration: none"><div>Pokemon Found In</div></a>
<br/>
<img src="Ash_SM.png" height="375px" width="300px">
</div>
<div style="background-color: #F9D342;top:0px;left:302px;height:300px;width:1200px;position:absolute;text-align: center;">
<center><h1>POKEMON<h1></h1></center>
<p>Pokémon, electronic game series from Nintendo that debuted in Japan in 1995 and later became wildly popular around the world. In the games, players assume the role of Pokémon trainers, obtaining cartoon monsters and developing them to battle other Pokémon.The original Pokémon is a role-playing game based around building a small team of monsters to battle other monsters in a quest to become the best. Pokémon are divided into types, such as water and fire, each with different strengths. Battles between them can be likened to the simple hand game rock-paper-scissors. For example, to gain an advantage over a Pokémon that cannot beat an opponent’s Charizard character because of a weakness to fire, a player might substitute a water-based Pokémon. With experience, Pokémon grow stronger, gaining new abilities. By defeating Gym Leaders and obtaining Gym Badges, trainers garner acclaim.</p>
<br/>
 <?php
   $query = "SELECT COUNT(*) FROM pokemon;";
   $result = pg_query($db_connection, $query);
   if(!$result)
   {
      echo pg_last_error($db_connection);
      exit();
   }
   $row = pg_fetch_row($result);
   echo '<b>';
   echo 'Number of Pokemon:'.$row[0];
   echo '</b>';
   ?>
  </div>
<br />
<div style="background-color: #F9D342;top:350px;left:550px;height:35px;width:300px;position:absolute;text-align: center;">
  <form action = "PokemonSearch.php" method="get">
  <input type="text" name="name" placeholder="Pokemon Name" style="width: 200px;box-sizing: border-box;border: 1px solid #ccc;border-radius: 5px;font-size: 25px;">
  <input type="submit" value = "Search" style = "cursor:pointer;border: 1px solid #ccc;border-radius: 5px;font-size: 25px;">
</form>
</div>
<div style="background-color: #F9D342;top:350px;left:900px;height:35px;width:300px;position:absolute;text-align: center;">
  <form action = "typeinfo.php" method="get">
  <input type="text" name="type" placeholder="Type" style="width: 200px;box-sizing: border-box;border: 1px solid #ccc;border-radius: 5px;font-size: 25px;">
  <input type="submit" value = "Search" style = "cursor:pointer;border: 1px solid #ccc;border-radius: 5px;font-size: 25px;">
</form>
</div>
<div style="top:400px;left:400px;height:100%;width: 1100px;position: absolute;">
<?php
   $query = "SELECT name,type1,type2,description FROM pokemon;";
   $result = pg_query($db_connection, $query);
   if(!$result)
   {
      echo pg_last_error($db_connection);
      exit();
   }
   $conuter = 0;
   while($row = pg_fetch_row($result))
   {
      if($conuter%4 == 0){
         echo '<div class="row">';
      }
      echo '<div style="font-family: georgia;font-size: 14px;font-weight: bold;color:#F9D342;"><a href="pokemon.php?name='.$row[0].'" style="text-decoration: none;color:#F9D342;">';
		echo '<div class= "column" >'.'<br />'.'<img src = "'.$row[3].'.png" height = "200" width = "200" style="border-radius:10%;" >'.'<center><br />'.strtoupper($row[0]).'<br/>.'.$row[1].'.'.$row[2].'</center></div>';
echo '</a></div>';
    $conuter=$conuter+1;
    if($conuter%4==0){
      echo '</div>';
   }
   }
   pg_close($db_connection);
?>
</div>
</body>
</html>
