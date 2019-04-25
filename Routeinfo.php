<?php
$db_connection = pg_connect("host=localhost port=5432 dbname=pokedabe user=postgres password=12345678");
if(!$db_connection)
{
  echo "Error: Unable to open database\n".pg_last_error();
  exit();
}
if($_SERVER['REQUEST_METHOD']=="GET")
  {
    $num=$_GET["num"];
  }

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>PokeBase</title>
  <style type="text/css">
    .column {
    
  float: left;
  width: 23.6%;
  padding: 7px;
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
<a href="/main.php" style="text-decoration: none;color:#292826"><div style="">Pokemon</div></a>
<a href="/Item.php" style="text-decoration: none;color:#292826"><div style="">Items</div></a>
<a href="/Type.php" style="text-decoration: none;color:#292826;"><div style="">Types</div></a>
<a href="/Trainer.php" style="text-decoration: none;color:#292826"><div style="">Trainer</div></a>
<a href="/Attacks.php" style="color:#292826;text-decoration: none"><div>Attacks</div></a>
<a href="/Region.php" style="color:#292826;text-decoration: none"><div>Region</div></a>
<a href="/PokeGym.php" style="color:#292826;text-decoration: none"><div>Pokemon Gym</div></a>
<a href="/Location.php" style="color:#292826;text-decoration: none"><div style="background-color: #292826;font-size:35px;color:#F9D342;">Pokemon Found In</div></a>
<br/>
<img src="Ash_SM.png" height="375px" width="300px">
</div>
<div style="top:0px;left:350px;height:100%;width: 60%;position:sticky;">
<div style="background-color:#F9D342;font-size:17px;color:#292826;left:50px;top:50px;position:absolute;width:1050px;font-family: georgia">
<center><H1>Pokemon Found In Route <?php echo $num;?></H1>
   <?php
    $query = "SELECT COUNT(*) FROM pokemon_belongs_in_route WHERE route =".$num.";";
   $result = pg_query($db_connection, $query);
   if(!$result)
   {
      echo pg_last_error($db_connection);
      exit();
   }
   $row = pg_fetch_row($result);
   echo '<b>';
   echo 'No of Pokemon are '.$row[0];
   echo '</b>';
   echo '<br /><br /  >';
     ?>
</center>
<br />
</div>

   <div style="color:#F9D342;position:absolute;top:250px;left:50px;width:1050px">
<center><b><h1>Pokemon Found Here:</h1></b></center>
    <br />
<?php
  $query = "SELECT name,type1,type2,description FROM pokemon join pokemon_belongs_in_route on pokemon_name = name where route = ".$num.";";
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
    echo '<div class= "column" >'.'<br />'.'<img src = "'.$row[3].'.png" height = "200" width = "200" style="border-radius:10%;" >'.'<br />'.strtoupper($row[0]).'<br/>.'.$row[1].'.'.$row[2].'</div>'."\n";
echo '</a></div>';
    $conuter=$conuter+1;
    if($conuter%4==0){
      echo '</div>';
   }
 }
   ?>
 </div>
</div>
<?php pg_close($db_connection);?>
</body>
</html>