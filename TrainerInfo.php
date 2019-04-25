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
    img
  {
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
<a href="/Type.php" style="text-decoration: none;color:#292826"><div style="">Types</div></a>
<a href="/Trainer.php" style="text-decoration: none"><div style="background-color: #292826;font-size:35px;color:#F9D342;">Trainer</div></a>
<a href="/Attacks.php" style="color:#292826;text-decoration: none"><div>Attacks</div></a>
<a href="/Region.php" style="color:#292826;text-decoration: none"><div>Region</div></a>
<a href="/PokeGym.php" style="color:#292826;text-decoration: none"><div>Pokemon Gym</div></a>
<a href="/Location.php" style="color:#292826;text-decoration: none"><div>Pokemon Found In</div></a>
<br/>
<img src="Ash_SM.png" height="375px" width="300px">
</div>
<div style="top:0px;left:350px;height:100%;width: 60%;position:sticky;">

<div style="background-color:#F9D342;border-radius:10%;positon:absolute;top:200px;left:350px;width:600px;font-family:georgia;font-size:25px;text-align:center;color:#292826;margin:0;">
<?php
  if($_SERVER['REQUEST_METHOD']=="GET")
  {
    $TID=$_GET["id"];
  }
  $query = " SELECT * FROM trainer where Trainer_ID='".$TID."';";
  $result = pg_query($db_connection, $query);
  if(!$result)
  {
    echo pg_last_error($db_connection);
    exit();
  }
   while($row = pg_fetch_row($result))
   {
      
      echo '<br /><b>Trainer_ID:</b> '.$row[0];
      echo '<br /><b>Lives In:</b> '.$row[2];
      echo '<br /><b>Level:</b> '.$row[3];
   }
   ?>
   <?php
  if($_SERVER['REQUEST_METHOD']=="GET")
  {
    $TID=$_GET["id"];
  }
  $query = " SELECT Pt.Pokemon_name,Pt.Level,p.description FROM pokemon_trainer_owns pt,pokemon p where Trainer_ID='".$TID."' and p.name = pt.Pokemon_Name;";
  $result = pg_query($db_connection, $query);
  if(!$result)
  {
    echo pg_last_error($db_connection);
    exit();
  }
  echo '<pre>';
  echo '<b>Pokemon Owned</br></b>';
   while($row = pg_fetch_row($result))
   {
     echo '<a href = "pokemon.php?name='.$row[0].'" style = "text-decoration:none;color:#292826"><img src = "./'.$row[2].'.png" height = "150" width = "150" style="border-radius:20%;" >'.'<br /><center>'.$row[0].'|Lv.'.$row[1].'</center></a>';
   }
   echo '</pre>';
   echo '<center><a href="StrongAT.php?id='.$TID.'" style = "text-decoration:none;">Which Trainers can Defeat him?</a></center>';
   echo '<center><a href="WeakAT.php?id='.$TID.'" style = "text-decoration:none;">Which Trainers can\'t Defeat him?</a></center>';
   echo '<center><a href="StrongPTP.php?id='.$TID.'" style = "text-decoration:none;">Which Pokemon can Defeat him?</a></center>';
   echo '<center><a href="WeakPTP.php?id='.$TID.'" style = "text-decoration:none;">Which Pokemon can\'t Defeat him?</a></center>';
   ?>
   </div>
   <?php
  $query = " SELECT name,level FROM trainer where Trainer_ID=".$TID.";";
  $result = pg_query($db_connection, $query);
  if(!$result)
  {
    echo pg_last_error($db_connection);
    exit();
  }
   while($row = pg_fetch_row($result))
   {
      
		  echo '<div style="background-image:url(pokemonback.png);background-size:cover;top:100px;left:1000px;width:500px;height:500px;position: fixed;text-align: center;font-family: georgia;font-size: 40px;font-weight: bold;border-radius:20%;">';
      echo '<img src = "./Trainer/'.$row[0].'.png" height = "500" width = "500" style="border-radius:20%;" >'.'<br />';
      echo '<div style="color:#F9D342;">'.'Name:'.$row[0].'</div></div>';
   }
   ?>
 </div>
<?php pg_close($db_connection);?>
</body>
</html>
