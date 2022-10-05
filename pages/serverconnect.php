<!doctype html>
<html>
  <head>
     <title>Database Connection </title>
  </head>
  <body>

	 <?php
       $host = "localhost";
       $user = "root";
       $pass = "";

          //creating connection to server 
       $con = mysqli_connect($host, $user, $pass)
          or die ("Unable to connect to server!");

      ?>
     


  </body>

</html>