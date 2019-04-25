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
<div style="top:0px;left:350px;height:100%;width: 60%;position:sticky;">

<?php
  if($_SERVER['REQUEST_METHOD']=="GET")
  {
    $Pokemon_name=$_GET["name"];
  }
  $query = " SELECT * FROM pokemon natural join base_stats where pokemon.name = '".$Pokemon_name."';";
  $query2 = "SELECT * FROM attacks_learnt WHERE pokemon_name = '".$Pokemon_name."';";
  $query3 = "SELECT * FROM Pokemon_Found_In_Town WHERE Pokemon_name = '".$Pokemon_name."';";
  $query4 = "SELECT * FROM Pokemon_Belongs_In_Route WHERE Pokemon_name = '".$Pokemon_name."';";
  $result = pg_query($db_connection, $query);
  if(!$result)
  {
    echo pg_last_error($db_connection);
    exit();
  }
  if(pg_num_rows($result)==0)
  {
     echo '<div style="color:#F9D342;font-size:50px;top:10px;text-align:center;">POKEMON NOT FOUND</div>';
  }
   while($row = pg_fetch_row($result))
   {
      
		  echo '<div style="background-color:#F9D342;border-radius:10%;positon:absolute;top:200px;left:350px;height:1000px;width:600px;font-family:georgia;font-size:25px;text-align:center;color:#292826;margin:0;">';
      echo '<br /><b>ID NUMBER:</b> '.$row[1];
      echo '<br /><b>Type:</b> '.$row[4];
      if($row[5]!='')
      {
          echo '|'.$row[5];
      }      
      echo '<br /><br /><b>Weight:</b> '.$row[2].' kg';
      echo '<br /><b>Height:</b> '.$row[3].' meters';
      echo '<br /><b>Abilities:</b> '.$row[7];
      echo '<br /><br /><b>Base Stats:</b>';
      echo '<pre>';
      echo '<b>HP</b>     :'.$row[8];
      echo '<b><br />Attacks:</b>'.$row[9];
      echo '<b><br />Defense:</b>'.$row[10];
      echo '<b><br />Speed  :</b>'.$row[11];
      echo '</pre>';
      echo '<pre>';
      echo '<b>Attacks Learnt:</b></br>';
      $result2 = pg_query($db_connection, $query2);
      if(!$result2)
      {
        echo pg_last_error($db_connection);
        exit();
      }
      while($row2 = pg_fetch_row($result2))
      {
        echo $row2[1].'|Lv.'.$row2[2].'<br />';
      }
      echo '<br />';
       echo '<b>Pokemon Can be Found In:</b></br>';
      $result3 = pg_query($db_connection, $query3);
      if(!$result3)
      {
        echo pg_last_error($db_connection);
        exit();
      }
      $i=0;
      echo "Towns:  ";
      while($row3 = pg_fetch_row($result3))
      {
        echo $row3[1].", ";
        if($i > 1)
          {echo '<br />';$i=0;}
        $i = $i +1;
      }
      echo '<br />';
      $result4 = pg_query($db_connection, $query4);
      if(!$result4)
      {
        echo pg_last_error($db_connection);
        exit();
      }
      $i=0;
      echo "Routes:  ";
      while($row4 = pg_fetch_row($result4))
      {
        echo $row4[1].", ";
        if($i > 7)
          {echo '<br />';$i=0;}
        $i = $i +1;
      }
      echo '<br />';
      echo '</pre>';
      echo '<center><a href="StrongAP.php?name='.$Pokemon_name.'" style = "text-decoration:none;">Which Trainers can Defeat it?</a></center>';
      echo '<center><a href="WeakAP.php?name='.$Pokemon_name.'" style = "text-decoration:none;">Which Trainers can\'t Defeat it?</a></center>';
      echo '<center><a href="WeakPP.php?name='.$Pokemon_name.'" style = "text-decoration:none;">Which Pokemon can\'t Defeat it?</a></center>';
      echo '<center><a href="StrongPP.php?name='.$Pokemon_name.'" style = "text-decoration:none;">Which Pokemon can Defeat it?</a></center>';
      echo '</div>';
      echo '<div style="background-image:url(pokemonback.png);background-size:cover;top:100px;left:1000px;width:500px;height:500px;position: fixed;text-align: center;font-family: georgia;font-size: 40px;font-weight: bold;border-radius:20%;">';
      echo '<img src = "'.$row[6].'.png" height = "500" width = "500" style="border-radius:20%;" >'.'<br />';
      echo '<div style="color:#F9D342;">'.'Name:'.$row[0].'</div></div>';
   }
   ?>
 </div>
<?php pg_close($db_connection);?>
</body>
</html>