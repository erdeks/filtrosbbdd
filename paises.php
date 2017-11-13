<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Arrays</title>
  <style>
  body{
  }
  table,td {
    border: 1px solid black;
    border-spacing: 0px;
  }
  </style>
</head>
<body>
  <?php
    $host = "localhost";
    $user = "root";
    $pass = "root";
    $bbdd = "world";
    $conexion = mysqli_connect($host,$user,$pass);
    mysqli_select_db($conexion, $bbdd);
    $conexion -> set_charset("utf8");
    $query = "SELECT DISTINCT(Name), Code FROM country;";
    $query = mysqli_query($conexion, $query);
    if (!$query) {
     			$message  = 'Consulta invàlida: ' . mysqli_error() . "\n";
     			$message .= 'Consulta realitzada: ' . $query;
     			die($message);
 		}
    if(isset($_SERVER["REQUEST_METHOD"])=="POST" && isset($_POST["cp"])){
      $cp=$_POST["cp"];
      $query = "SELECT * FROM city WHERE CountryCode='".$cp."'";
      $query = mysqli_query($conexion, $query);
      if (!$query) {
       			$message  = 'Consulta invàlida: ' . mysqli_error() . "\n";
       			$message .= 'Consulta realitzada: ' . $query;
       			die($message);
   		}

      $query2 = "SELECT DISTINCT(Name) FROM country WHERE Code='".$cp."'";
      $query2 = mysqli_query($conexion, $query2);
      $query2 = mysqli_fetch_assoc($query2);

      /*echo "<h1>Ciudades de ".$query2["Name"]."</h1>";

      echo "<ul>";
      while( $registre = mysqli_fetch_assoc($query) ){
        echo "<li>".$registre['Name']."</li>";
      }
      echo "</ul>";*/
    ?>
    <table>
    <?php
   	echo "<thead><td colspan='4' align='center' bgcolor='cyan'>Citys from ".$query2['Name']."</td></thead>";

   		while( $registre = mysqli_fetch_assoc($query) ){
   			echo "\t<tr>\n";
   			echo "\t\t<td>".$registre["Name"]."</td>\n";
   			echo "\t\t<td>".$registre["District"]."</td>\n";
   			echo "\t\t<td>".$registre['Population']."</td>\n";
   			echo "\t</tr>\n";
   		}
   	?>
   	</table>
    <?php }else{ ?>
      <form action="paises.php" method="post">
        <select name="cp">
          <?php while( $registre = mysqli_fetch_assoc($query) ){
            echo "<option value='".$registre['Code']."'>".$registre['Name']."</option>";

          }?>
        </select>
        <input type="submit" value="Send">

      </form>
    <?php } ?>
</body>
</html>
