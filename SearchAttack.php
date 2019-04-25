<?php
$db_connection = pg_connect("host=localhost port=5432 dbname=pokedabe user=postgres password=12345678");
if(!$db_connection)
{
	echo "Error: Unable to open database\n".pg_last_error();
	exit();
}
if($_SERVER['REQUEST_METHOD']=="POST")
  {
    $attack=$_POST["name"];
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
  padding: 5px;
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
<a href="/Item.php" style="color:#292826;text-decoration: none"><div>Item</div></a>
<a href="/Type.php" style="text-decoration: none;color:#292826"><div style="">Types</div></a>
<a href="/Trainer.php" style="text-decoration: none;color:#292826"><div style="">Trainer</div></a>
<a href="/Attacks.php" style="text-decoration: none"><div style="background-color: #292826;font-size:35px;color:#F9D342;">Attacks</div></a>
<a href="/Region.php" style="color:#292826;text-decoration: none"><div>Region</div></a>
<a href="/PokeGym.php" style="color:#292826;text-decoration: none"><div>Pokemon Gym</div></a>
<a href="/Location.php" style="color:#292826;text-decoration: none"><div>Pokemon Found In</div></a>
<br/><br/>
<img src="5Pikachu.png" height="325px" width="300px">
</div>
<div style="background-color: #F9D342;top:0px;left:400px;height: 250px;width: 1000px;position:relative;color: #292826">
<center><H1>ATTACKS</H1>
<p>A move or attack or technique is the skill Pokémon primarily use in battle. In battle, a Pokémon uses one move each turn. Some moves (including those learned by Hidden Machine) can be used outside of battle as well, usually for the purpose of removing obstacles or exploring new areas. The moves are categorized on the basis of types.</p>
<?php 
$query = "SELECT Count(*) FROM Attacks WHERE name LIKE '".$attack."%';";
   $result = pg_query($db_connection, $query);
   if(!$result)
   {
      echo pg_last_error($db_connection);
      exit();
   }
   echo 'Total Number of Attacks:';
   while($row = pg_fetch_row($result))
   {
      echo $row[0];
   }
?>
<br />
<br />
<form action= 'SearchAttack.php' method="post">
  <input type="text" name="name" placeholder="Attack Name" style="width: 150px;box-sizing: border-box;border: 1px solid #ccc;border-radius: 5px;font-size: 13px;">
  <input type="submit" value = "Search" style = "cursor:pointer;border: 1px solid #ccc;border-radius: 5px;font-size: 10px;">
  </form>
  <form action = 'AttackType.php' method="get">
    <select name = 'Type' style="width: 150px;box-sizing: border-box;border: 1px solid #ccc;border-radius: 5px;font-size: 13px;">
    <?php 
      $query = "SELECT Distinct Type FROM Attacks;";
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
<div style="background-color: #F9D342;top:10px;left:400px;height: 150px;width: 1000px;position:relative;color: #292826">
  <center><h2>Attacks Statistics</h2></center>
<table>
  <tr style="font-size:10px;"><th>Max PP</th><th>Max Accuracy</th><th>Max Power</th><th>Min Power</th><th>Min Accuracy</th><th>Min PP</th><th>Average PP</th><th>Average Accuracy</th><th>Average Power</th></tr>
  <tr><?php 
  $query = "SELECT Max(PP),Max(Accuracy),Max(Power),Min(Power),Min(Accuracy),Min(PP),round(cast(Avg(PP) as numeric),2),round(cast(Avg(Accuracy) as numeric),2),round(cast(Avg(Power) as numeric),2) FROM Attacks where name LIKE '".$attack."%';";
      $result = pg_query($db_connection, $query);
      if(!$result)
      {
        echo pg_last_error($db_connection);
        exit();
      }
      while($row = pg_fetch_row($result))
      {
        $i = 0;
          while ($i<9){
          echo '<td>'.$row[$i].'</td>';
          $i = $i +1;
        }
   }
  ?></tr>
</table>
</div>
<div style="top:30px;left:375px;width:1050px;position: relative;">
<div style="color:#F9D342;width:1050px"> <center><h2>Attacks List</h2></center></div>
<?php
   $query = "SELECT * FROM Attacks WHERE name Like '".$attack."%';";
   $result = pg_query($db_connection, $query);
   if(!$result)
   {
      echo pg_last_error($db_connection);
      exit();
   } 
   echo '<table><tr><th>Attack Name</th><th>PP</th><th>Accuracy</th><th>Power</th><th>Effect</th><th>Type</th></tr>';
   while($row = pg_fetch_row($result))
   {
   		echo '<tr><td>'.$row[0].'</td><td>'.$row[1].'</td><td>'.$row[2].'</td><td>'.$row[3].'</td><td>'.$row[4].'</td><td>'.$row[5].'</td></tr>';
   }
   echo '</table>';
   pg_close($db_connection);
?>
</div>
</body>
</html>