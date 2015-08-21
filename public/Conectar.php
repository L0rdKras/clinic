<?php
 $dbhost = "localhost";  
 $dbuser = "root";  
 $dbpassword = "MataReyes";  
 $dbname = "lubricentro"; 
 

  $db = mysql_connect($dbhost, $dbuser, $dbpassword) or die("Connection Error: " . mysql_error()); mysql_select_db($dbname) or die("Error al conectar a la base de datos.");  

?>
