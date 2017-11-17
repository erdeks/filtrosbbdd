<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Continentes</title>
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
    try {
          $hostname = "localhost";
          $dbname = "world";
          $username = "root";
          $pw = "root";
          $pdo = new PDO ("mysql:host=$hostname;dbname=$dbname","$username","$pw");
      }catch (PDOException $e){
            echo "Failed to get DB handle: ".$e->getMessage()."\n";
            exit;
      }

      $sql = "SELECT DISTINCT(Continent) FROM country";
      $query = $pdo -> prepare($sql);
      $query -> execute();
      if(isset($_SERVER["REQUEST_METHOD"])=="POST" && isset($_POST["cc"])){
        $cc=$_POST["cc"];
        $sql = "SELECT Name, Population FROM country WHERE Continent='".$cc."'";
        $query = $pdo -> prepare($sql);
        $query -> execute();
        $sql = "SELECT SUM(Population) FROM country WHERE Continent='".$cc."'";
        $queryPob = $pdo -> prepare($sql);
        $queryPob -> execute();
        $row = $queryPob->fetch();
      ?>
      <table>
      <?php
     	echo "<thead><td colspan='4' align='center' bgcolor='cyan'>Countries from ".$cc."<br>Population: ".$row['SUM(Population)']."</td></thead>";

     		while( $registre = $query->fetch()){
     			echo "\t<tr>\n";
     			echo "\t\t<td>".$registre["Name"]."</td>\n";
     			echo "\t\t<td>".$registre['Population']."</td>\n";
     			echo "\t</tr>\n";
     		}
     	?>
     	</table>
      <?php }else{ ?>
        <form action="continentes.php" method="post">
          <select name="cc">
            <?php while( $registre = $query->fetch() ){
              echo "<option value='".$registre['Continent']."'>".$registre['Continent']."</option>";

            }?>
          </select>
          <input type="submit" value="Send">

        </form>
      <?php }
  ?>
</body>
</html>
