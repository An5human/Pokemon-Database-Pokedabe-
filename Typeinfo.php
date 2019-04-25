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
<a href="/Type.php" style="text-decoration: none"><div style="background-color: #292826;font-size:35px;color:#F9D342;">Types</div></a>
<a href="/Trainer.php" style="text-decoration: none;color:#292826"><div style="">Trainer</div></a>
<a href="/Attacks.php" style="color:#292826;text-decoration: none"><div>Attacks</div></a>
<a href="/Region.php" style="color:#292826;text-decoration: none"><div>Region</div></a>
<a href="/PokeGym.php" style="color:#292826;text-decoration: none"><div>Pokemon Gym</div></a>
<a href="/Location.php" style="color:#292826;text-decoration: none"><div>Pokemon Found In</div></a>
<br/>
<img src="Ash_SM.png" height="375px" width="300px">
</div>
<div style="top:0px;left:350px;height:100%;width: 60%;position:sticky;">
<div style="background-color:#F9D342;font-size:17px;color:#292826;left:50px;top:50px;position:absolute;width:1050px;font-family: georgia">
<center>
<?php
  if($_SERVER['REQUEST_METHOD']=="GET")
  {
    $Type=$_GET["type"];
    $Type=strtoupper($Type);
  }
  $query = "SELECT * FROM Type where name='".$Type."';";
  $result = pg_query($db_connection, $query);
  if(!$result)
  {
    echo pg_last_error($db_connection);
    exit();
  }


  if(pg_num_rows($result)==0)
  {
     echo '<div style="color:#292826;font-size:50px;top:10px;text-align:center;">NO SUCH TYPE FOUND</div>';
     exit();
  }

   while($row = pg_fetch_row($result))
   {
      echo '<h1><b>'.$row[0].'</b></h1><p>'.$row[1].'</p><br />';
   }
   ?>

   <br />
   <?php 
   $query = "SELECT Dominant_Over FROM Type_Strength WHERE Name = '".$Type."';";
   $result = pg_query($db_connection, $query);
   if(!$result)
   {
      echo pg_last_error($db_connection);
      exit();
   }
   if(pg_num_rows($result)!=0)
   {
   		echo "<b>This Type is Strong Against(Double Damage):<br /></b>";
        echo '|';
   }
   while($row = pg_fetch_row($result))
   {
      echo '<a href="Typeinfo.php?type='.$row[0].'" style="text-decoration:none;color:#292826">'.$row[0].'</a>|';
   }
   ?>
   <br />
   <?php 
   $query = "SELECT Weak_Against FROM Type_Weakness WHERE Name = '".$Type."';";
   $result = pg_query($db_connection, $query);
   if(!$result)
   {
      echo pg_last_error($db_connection);
      exit();
   }
   if(pg_num_rows($result)!=0)
   {
   		echo "<b>This Type is Weak Against Against(Half Damage):<br /></b>";
   		echo '|';      
   }
   while($row = pg_fetch_row($result))
   {
      echo '<a href="Typeinfo.php?type='.$row[0].'" style="text-decoration:none;color:#292826">'.$row[0].'</a>|';
   }
   ?>
   <br />
   <br />
   <?php
  	$query = "SELECT COUNT(*) FROM pokemon WHERE Type1 = '".$Type."' or Type2 = '".$Type."';";
   $result = pg_query($db_connection, $query);
   if(!$result)
   {
      echo pg_last_error($db_connection);
      exit();
   }
   $row = pg_fetch_row($result);
   echo '<b>';
   echo 'No of Pokemon of '.$Type.' Type are '.$row[0];
   echo '</b>';
   echo '<br /><br />';
   echo '<a href="AttackType.php?Type='.$Type.'" style="text-decoration:none;color:#292826">ATTACKS OF '.$Type.'.</a>';
   ?>
   <br />
   <br />
 </center>
 </div>
   <div style="background-color:#F9D342;position:absolute;top:450px;left:75px;width:1000px">
<center><b><h1>Pokemon of This Type:</h1></b></center>
    <br />
<?php
  $query = "SELECT name,type1,type2,description FROM pokemon WHERE Type1 = '".$Type."' or Type2 = '".$Type."';";
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
      echo '<div style="font-family: georgia;font-size: 14px;font-weight: bold;color:#292826;"><a href="pokemon.php?name='.$row[0].'" style="text-decoration: none;color:#292826;">';
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