<!DOCTYPE html>
<html>
    <head>
      <title> Database Connection </title> 
    </head>
  <body> 
	   <?php 
        $host = "localhost";
        $user = "root";
        $pass = "";
        if (file_exists("../systemfiles/databasename.txt")){
          $database = file_get_contents("../systemfiles/databasename.txt");

          //creating connection to database
          $con = mysqli_connect($host, $user, $pass, $database);
        }else{
          $con = mysqli_connect($host, $user, $pass);
        }		
		  ?>
  
</body>


</html>