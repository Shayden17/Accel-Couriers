<?php 
    session_start();
	if (file_exists("systemfiles/databasename.txt")){
		if ($_SESSION['fname']){
			if ((isset($_SESSION['acctype']))&&($_SESSION['acctype']!='non admin'))
				header('location:pages/setup.php');
			else
				header('location:pages/userhome.php');
		}else
			header ('location:pages/home.php');
	}else
		header('location:pages/setup.php');
?>