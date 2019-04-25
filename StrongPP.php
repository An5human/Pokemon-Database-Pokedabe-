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
  width: 16.67%;
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
<a href="/main.php" style="text-decoration: none;color:#292826"><div style="background-color: #292826;font-size:35px;color:#F9D342;">Pokemon</div></a>
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
<div style="top:0px;left:400px;height:100%;width: 100%;position: relative;">
<?php
if($_SERVER['REQUEST_METHOD']=="GET")
  {
    $name=$_GET["name"];
  }
   $query = "SELECT name,description
FROM Pokemon
WHERE type1 IN (SELECT Weak_Against
            FROM Type_Weakness
            WHERE Name = (SELECT type1 
                          FROM pokemon
                          WHERE name='".$name."'));";
   $result = pg_query($db_connection, $query);
   if(!$result)
   {
      echo pg_last_error($db_connection);
      exit();
   }
   $conuter = 0;
   $i = 0;
   while(($row = pg_fetch_row($result)) && $i<16)
   {
      if($conuter%4 == 0){
         echo '<div class="row">';
      }
      echo '<div style="font-family: georgia;font-size: 14px;font-weight: bold;color:#F9D342;"><a href="pokemon.php?name='.$row[0].'" style="text-decoration: none;color:#F9D342;">';
    echo '<div class= "column" >'.'<br />'.'<img src = "./'.$row[1].'.png" height = "200" width = "200" style="border-radius:10%;" >'.'<br /><center>'.strtoupper($row[0]).'</center></div>'."\n";
echo '</a></div>';
    $conuter=$conuter+1;
    if($conuter%4==0){
      echo '</div>';
   }
   $i= $i+1;
   }
   pg_close($db_connection);
?>
</div>
</body>
</html>