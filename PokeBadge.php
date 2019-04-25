<?php
$db_connection = pg_connect("host=localhost port=5432 dbname=pokedabe user=postgres password=12345678");
if(!$db_connection)
{
	echo "Error: Unable to open database\n".pg_last_error();
	exit();
}
if($_SERVER['REQUEST_METHOD']=="GET")
  {
    $BN=$_GET["name"];
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
<a href="/Type.php" style="text-decoration: none;color:#292826;"><div style="">Types</div></a>
<a href="/Trainer.php" style="text-decoration: none;color:#292826;"><div style="">Trainer</div></a>
<a href="/Attacks.php" style="color:#292826;text-decoration: none"><div>Attacks</div></a>
<a href="/Region.php" style="color:#292826;text-decoration: none"><div>Region</div></a>
<a href="/PokeGym.php" style="color:#292826;text-decoration: none"><div style="background-color: #292826;font-size:35px;color:#F9D342;">Pokemon Gym</div></a>
<a href="/Location.php" style="color:#292826;text-decoration: none"><div>Pokemon Found In</div></a>
<br/>
<img src="Ash_SM.png" height="375px" width="300px">
</div>
<div style="top:0px;left:350px;height:100%;width: 60%;position:sticky;">

<div style="background-color:#F9D342;border-radius:10%;positon:absolute;top:200px;left:350px;width:600px;font-family:georgia;font-size:25px;text-align:center;color:#292826;margin:0;">
<?php
  $query = "SELECT Badge_name,region,name,lives_in,gym_leader,level FROM Pokemon_gym,Trainer WHERE gym_leader = Trainer_id and Badge_name='".$BN."';";
  $result = pg_query($db_connection, $query);
  if(!$result)
  {
    echo pg_last_error($db_connection);
    exit();
  }
  while($row = pg_fetch_row($result)){
   echo '<br /><b>Badge Name:</b> '.$row[0];
   echo '<br /><b>GYM Located At:</b> '.$row[3];
   echo '<br /><b>Region:</b> '.$row[1];
   echo '<br /><b>Gym Leader:</b> '.$row[2];
   echo '<br />';
   echo '<a href = "TrainerInfo.php?id='.$row[4].'" style = "text-decoration:none;color:#292826"><img src = "Trainer/'.$row[2].'.png" height = "350" width = "250" style="border-radius:20%;" >'.'<br /><center>'.$row[2].'|Lv.'.$row[5].'</center></a>';
   
   echo '</pre>';
   echo '<br />';
   echo '<center><a href="StrongAT.php?id='.$row[4].'" style = "text-decoration:none;color:#292826;">Which Trainers have the badge?</a></center>';
   echo '<center><a href="WeakAT.php?id='.$row[4].'" style = "text-decoration:none;color:#292826;">Which Trainers don\'t have the badge?</a></center>';
   echo '<center><a href="StrongPTP.php?id='.$row[4].'" style = "text-decoration:none;color:#292826;">Which Pokemon can help in getting the badge?</a></center>';
   echo '<center><a href="WeakPTP.php?id='.$row[4].'" style = "text-decoration:none;color:#292826;">Which Pokemon won\'t get you the badge?</a></center>';
   }
   ?>
   </div>
   <?php
  $query = "SELECT Badge_name,region,name FROM Pokemon_gym,Trainer WHERE gym_leader = Trainer_id and Badge_name='".$BN."';";
  $result = pg_query($db_connection, $query);
  if(!$result)
  {
    echo pg_last_error($db_connection);
    exit();
  }
   while($row = pg_fetch_row($result))
   {      
		  echo '<div style="top:90px;left:1000px;width:500px;height:500px;position: fixed;text-align: center;font-family: georgia;font-size: 40px;font-weight: bold;border-radius:20%;">';
      echo '<img src = "./Badges/'.$row[0].'.png" height = "450" width = "350" style="border-radius:2%;" >'.'<br />';
      echo '<div style="color:#F9D342;">'.'Badge:'.$row[0].'</div></div>';
   }
   ?>
 </div>
<?php pg_close($db_connection);?>
</body>
</html>
