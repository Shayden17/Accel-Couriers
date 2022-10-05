<!doctype html> 
<html>
	<head> 
        <title> </title>
        <link href ="../css/style.css" rel="stylesheet" type="text/css"/>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <?php 
			session_start();include 'serverconnect.php';include 'functions.php'; 
			error_reporting(E_ERROR | E_WARNING | E_PARSE);
			
		?>
    </head>
    <body>
		<main>
			<header class= 'scrolled fadeIn'>
				<?php echo header_('','user');?>
			</header>
			<page class ='animated FadeInRight'> <!--MAIN CONTENT ON PAGE (MINUS HEADER)-->
				<br>
				<form id = 'request' method = 'post'></form>
				<?php	
					if (databasecheck()==0){ 	//If database (And admin account) are not yet set up then Use 'system protection' for Setup //~~ First Time Login-->  
						systemprotection();
					}elseif ((datasecheck()==1)&&(!isset($_SESSION['acctype']))){ 		//Check to see if Tables in database have been created (By default an admin account is created with employee table)
						header('location:employeelogin.php');	//Therefor if 'check()' Returns (1) and the SESSION account type is not set it would send back to employee login (Admin Must Then Log in Firstly)
					}elseif ($_SESSION['acctype']=='non admin'){		// If Session account type is set but not manager or admin would simply go back to last URL (basically preventing access).
						header("location:".$_SERVER['HTTP_REFERER']."");
					}
					else{  	//Otherwise Regular Operations    
						?>
							<div class = 'row' ><!--~~ Page Title-->
								<?php
									if($_SESSION['acctype']!='admin')
									echo 
										"<h1>Welcome Back ".$_SESSION['fname']."</h1><br>";	
									else
									echo
										"<h1>Admin Options</h1>";
								?>
							</div>
						<?php
						if (($_SESSION['acctype'] == 'admin')||($_SESSION['acctype']=='first')){
							?>
							</div class = 'row'><!--~~ database-->
								<h2 class = 'database'>Database</h2>
								<div class ='s-row' id ='database'>
									<?php
										$count = 0;				// Initialize $count variable to be used later
										if (file_exists("../systemfiles/databasename.txt")){	//Check To see if dataase name file (databasename.txt) is already created
											$databasename = file_get_contents("../systemfiles/databasename.txt");	//If it is get contents and store in $databasename
											$fp = fopen("../systemfiles/databasename.txt","r");			//Open file to read
											while(!feof($fp)){
												$character = fgetc($fp);
												$count++;						//For each character present in the file increase count by one
											}
										}

										if (isset($_POST['deletedatabase'])){								//If database needs to be deleted for some reason 
											$sql = "drop database $databasename;";							//SQl code to delete database 
											echo $sql;
											$result = mysqli_query($con,$sql);		
											if ($result){

												fclose($fp);
												
												if(unlink("databasename.txt")){
													session_destroy();
													echo '<script type="text/javascript">';
													echo 'alert("Database was successfully Deleted!");';	//If code executes succesfully then display success alert
													echo 'window.location.href = "setup.php"';
													echo '</script>';
												}
											}
										}else{
											echo mysqli_error($con);
										}

										if (isset ($_GET['dbnamesubmit'])){		//If New Database is being created
											$databasename = mysqli_real_escape_string(strtolower($_GET['databasename']));					//Get Database name from user through username
											$sql = "CREATE DATABASE `$databasename` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci" ; 	// Create database
											if ($con->query($sql) === TRUE) {	//if Database is created successfully 
												$myfile = fopen("../systemfiles/databasename.txt","w") or die("Unable to open file!");	//Create new file called databasename.txt 
												fwrite($myfile,$databasename);											//Write database name in the file
												fclose($myfile);														//Close file
												echo '<script type="text/javascript">';
												echo 'alert("Database was successfully Created!");';					//Display Sucess Alert
												echo 'window.location.href = "setup.php"';								//Reload Page
												echo '</script>';	
												
												exit;
											}else{	//Else Display Error Message on why database couldnt be created
												echo '<script type="text/javascript">';
												echo 'alert("' .$databasename.':', $con->error . '");';
												echo 'window.location.href = "setup.php";';
												echo '</script>';
											}
											
										}

										if ($count > 1){ //If Count Variable > 1 then a functional database exist and its name can be displayed
											echo "</br></br>Database: <b>'$databasename'</b> Is already created and in use. &emsp;&emsp;<button type='submit' form='request' name='deletedatabase'>Delete Database</button>";?><?php
										}else{		//Else display form and button for creating the database
											if (isset($_POST['createdatabase'])){
												echo"
													</br></br>
													<form method ='get'>
														<table>
															<tr>
															<th><label for = 'databasename'>Database Name</label></th> 
															<td><input type = 'text' name='databasename' value=''/></td>
															<td><input type = 'submit' value = 'Create'name = 'dbnamesubmit' >
															</tr>
														</table>
													</form>
													</br>";
											}
											echo "<input type = 'submit' form = 'request' value = 'Create Database' name = 'createdatabase'>";
										}
									?>
								</div>
							</div>


							<div class = 'row'><!--~~ tables-->
								<h2 class = 'tables'>Tables</h2>
								<div class ='s-row' id ='tables'>
									<?php
										$result = getinfo('all');		//Get table info for on all tables in database
										if ($result != '0'){			//If Result is not 0
											echo "<h3>Tables in Database:</h3>";	
											$check = 0;
											while($rows = mysqli_fetch_array($result,MYSQLI_ASSOC)){;
												foreach ($rows as $row){
													echo '&nbsp;&nbsp;&nbsp;&nbsp;'.$row. "<br>";
													$check++;	//For each table in the database $check is inremented by one
												}
											}

											if ($check == 7){		//If check = 7 then all tables have been created
												echo '<br><br><b>All necessary tables created and usable.</b>';
											}else{			//else display the amount of tables missing
												$amt = 7 - $check;	
												echo "<br><br> <b>'$amt'<b> Neccesary table(s) are missing. <input type = 'submit' form = 'request' value = 'Create remaining tables' id = 'createtables' name = '2'>";
			
											}
										}else{		//However if $Result is 0 then tables need to be created
											if (isset($_POST['createtables'])){				//If 'Create Tables Button is Pressed
												include 'dbconnect.php';					//Include Database Connection file 
												$sql=file_get_contents("../systemfiles/delete.txt");		//Get contents from delete.txt (Used to wipe the database clean of any existing tables so new tables can be created without any errors)
												$result = mysqli_query($con,$sql);
												$sql=file_get_contents("../systemfiles/databasesetup.txt");//Get contents from databasesetup.txt (create statements for tables in database)
												$result = mysqli_multi_query($con,$sql);
												
												if ($result){	//If execusion is successful kill the session and redirect to employee login (As admin can now login and 'system protection' is no longer needed)
													session_destroy();
													echo '<script type="text/javascript">alert("All Tables Created Succesfully.\n\n You will now be redirected to login page. \n Please Log in using default admin credentials.");window.location.href = "employeelogin.php";</script>;';
												}else{	//Otherwise Display connection error and then reload page 
													echo '<script type="text/javascript">alert("'.mysqli_error($con).'");window.location.href = "setup.php.";</script>;';
												}
											}
											echo "<input type = 'submit' form ='request' value = 'Create All tables' name = 'createtables'>";		//'Create Tables button 
										}
									?>
								</div>
							</div>

			
							<div class = 'row'><!--~~ sql-->
								<h2>Manipulate Database</h2>
								<div class ='s-row' id ='edit'>
									<?php
										if (isset ($_POST['sqlcodesubmit'])){	//If code is submitted execute code on database and display and alert saying if it was sucessful or if not (and why)
											
											$sql = $_POST['sqlcode'];
											
											if (mysqli_query($con,$sql)===TRUE){
												echo '<script type="text/javascript">alert("Query:  '.$sql.'   was succesfully completed"); window.location.href = "setup.php";</script>;';
											}elseif (mysqli_query($con,$sql)===FALSE){
												echo '<script type="text/javascript">alert("'.mysqli_error($con).'");window.location.href = "setup.php";</script>;';
											}
											
										}
											
										echo"
											<table>
												<tr>
													<th><label>SQL Code: </label></th> 
													<td><input type = 'text' form='request'  name='sqlcode'/></td>
													<td><input type = 'submit' form='request' value = 'Insert' name = 'sqlcodesubmit' >
												</tr>
											</table>
											</br>";
									
									?>
								</div>
							</div>	


							<div class ='row'><!--~~ Admin/Manager Accounts-->
								<h2> Admin/Manager Accounts </h2>
								<a href='#signupbox'><button onclick='show()' class='dropbtn'>Add Manager</button></a>
								<div class ='s-row' id='adminaccounts'> 
									<?php
										echo 
											"<table>
												<tr>
													<th align = 'left'><h4>Employee ID&emsp;&emsp;</h4></th> 
													<th align = 'left'><h4>First Name&emsp;&emsp;</h4></th>
													<th align = 'left'><h4>Last Name&emsp;&emsp;</h4></th>
													<th align = 'left'><h4>Account Type&emsp;&emsp;</h4></th>
													<th align = 'left'><h4>Telephone Contact&emsp;&emsp;</h4></th> 
													<th align = 'left'><h4>Address&emsp;&emsp;</h4></th>
												</tr>
												<tr>";
										
													$table = 'employees';
													$result = getinfo($table);
													$table = 'manager';
													$check = printrecords($result,$table); 

													if ($check == 0){
														printf('<td colspan ="7" align = "center"> No Records Available</td>');
													}
										echo
											"	</tr>
											</table>
											<br></br>";
											
									?> 
								</div>
								<div class="dropdown">	<!--Hidden Dropdown content box for 'register employee' form -->
									<div id="myDropdown" class="dropdown-content">
										<div class = 'box' id = 'signupbox'>
											<?php register('employee'); ?>
										</div>
									</div>
								</div>
							</div>
							
							<?php
						}elseif ($_SESSION['acctype']=='manager'){
							?>

							<div class ='row'> <!--~~ Manager Options-->
								<br><br>
								&emsp; <button onclick = 'location.href="orders.php?filter=all"' class = 'userhomebutton'><i class="fa fa-clipboard" aria-hidden="true"></i> Customer Orders</button>
								&emsp;&emsp; <button onclick = 'location.href="packagdelieveries.php?filter=all"' class = 'userhomebutton'><i class="fa fa-clipboard" aria-hidden="true"></i> Packacage Deliveries</button>
								&emsp;&emsp; <button onclick = 'location.href="payments.php"' class = 'userhomebutton'><i class="fa fa-credit-card-alt" aria-hidden="true"></i> Payments</button>
								<br><br><br><br><br><br><br><br>
							</div>
					
							<div class = 'row' ><!--~~ Employees-->
								<h2 class = 'employees'>Employees Accounts</h2>
								<div class ='s-row' id= 'employees'>
									<?php
										echo '
											<table>
												<tr>
													<th align = "left"><h4>Employee ID&emsp;&emsp;</h4></th> 
													<th align = "left"><h4>First Name&emsp;&emsp;</h4></th>
													<th align = "left"><h4>Last Name&emsp;&emsp;</h4></th>
													<th align = "left"><h4>Telephone Contact&emsp;&emsp;</h4></th> 
													<th align = "left"><h4>Email Address&emsp;&emsp;</h4></th>
												</tr>
												<tr>';
													$table = 'employees';
													$result = getinfo($table);
													$check = printrecords($result,$table); 

													if ($check == 0){
														printf('<td colspan ="7" align = "center"> No Records Available</td>');
													}
										echo'
												</tr>
											</table>
											<br></br>';
									?>
								</div>
								<div class="dropdown">
									<div id="myDropdown" class="dropdown-content">	<!--Hidden Dropdown content box for 'register employee' form -->
									<a href="#signupbox"><button onclick="show()" class="dropbtn">Go back</button></a><br><br>
										<div class ='box' id ='signupbox'>
											<?php register('employee'); ?>
										</div>
									</div>
								</div>
								<a href="#signupbox"><button onclick="show()" id = "Add" class="dropbtn">Add Employee</button></a>
								<br><br><br><br>
							</div>
							<?php
						}
					}
						
				?>
				
				<script type='text/javascript'>	//Script to show/hide dropdown menu
					function show() {
						document.getElementById("myDropdown").classList.toggle("show");
						document.getElementById("Add").classList.toggle("hide");
					}
				</script>
			</page>
		</main>
		<!--~ Footer-->
		<footer>    <!--FOOTER-->
            <?php footer_(''); ?>
        </footer>
		<!--!~-->
	</body>
    
  </html> 


  	    
