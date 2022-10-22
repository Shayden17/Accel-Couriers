<?php
    //~ Delete Account
    function deleteaccount($account){         //takes employee id as a passed variable           
        include 'dbconnect.php';
        $sql= "delete from employees where employeeid = '$account';";                   //SQL for deleting employee account from database 
        $result = mysqli_query($con,$sql);
        if ($result){
            echo '<script type="text/javascript">alert("Employee (ID: '.$account.') sucessfully deleted");window.location.href="setup.php"; </script>;';
        }else  
            echo '<script type="text/javascript">alert("'.mysqli_error($con).'"); </script>;';
    }
    /*!~*/
    

    //~ logout 
    function logout(){              
        if (isset($_SESSION['acctype'])){       //Use SESSION to determine if it is an employee or customer account
            $acc='employee';
        }
        session_destroy();                  //destroy session 
        if ($acc=='employee')               //depending on account type redirect to the appropriate login screen
            header("location: employeelogin.php");
        else
            header("Location: login.php");
    }
    /*!~*/


    //~ System Protection 
    function systemprotection(){            //Used to protect the website setup page if the database and account security protocols are set in place 
        if (!isset($_POST['fpassword'])){   //If the user has not submits a password promt the user for the system password
            echo"                           
                <div class ='row'>
                    <h1> Enter system password: </h1>
                    
                        <input id ='syspass' form='request' class = 'password' type = 'password' name = 'fpassword'/> <br><br>
                        <input type = 'submit' class ='submitbutton' value = 'Login' form = 'request'/>
                    
                </div>";
        }else{		                        //Otherwise check to see if the password they entered is correct (this is a default passsword set up beforehand)
            $syspass = file_get_contents("../systemfiles/syspass.txt");     //Location of system password file REVIEW - TRY DOING IT WITH HASHED PASSWORD
            $pass = mysqli_real_escape_string($con,$_POST['fpassword']);    //Accepting the user's password and cleaning it from any possible SQL injection 
            if(password_verify($pass,$syspass)){            //If system password is correct set SESSION acctype to first to signify a first time user (system admin)
                $_SESSION['acctype']='first';
                header('location:setup.php');               //refresh the page
            }else{      //Else reload the page after alerting the user they entered the wrong password
                echo'<script type="text/javascript">alert("Wrong password");window.location.href="setup.php" </script>;';
            }
        }
    }
    /*!~*/

    //~ Footer 
    function footer_($contact){            //$footer function where depending on the setting of $contact to detemine if to show that part of the footer
        if (!isset($_SESSION['acctype'])){ //If SESSION acctype is not set (meaning it is an customer account) Display the company logo and footer message in footer
            ?>
            <br>
            <div class="row"> <!--~~ WELCOME MESSAGE WITH LOGO TO CUSTOMERS -->
                
                <img onclick ='location.href="home.php"' class= 'logo' id='footerlogo' src = "../images/logo.png" alt = "Company Logo" />
                <p id='footerlogomessage'><b>AccelCouriers</b> is dedicated towards innovating the way courier companies do business in Trinidad and Tobago by making
                Online Shopping and remote package delivery in Trinidad and Tobago accessible, to all persons who have internet access and a bank account.<br> 
                We believe that all persons who have internet access should be able to enjoy the luxuries and comforts that come 
                from onine E-commerce, even if they do not have access to an online form of payment.</p><br>
                <div class ='divider'></div>
            </div>
            <?php
        }
        if ($contact=='contact'){   //If $contact variable is set to 'contact' then display the following row
            ?>
            <br>
                <div class ='row'> <!--~~ $Contact-->
                    <div class = 'col_width_33 f-col'>   <!--~~ Email and Telephone-->
                        <h1>Contact Us </h1><br>
                        <p>Telephone: 1-868-638-8624<br><br>
                         Email: querys@accelcouriers.com</p>
                    </div>

                    <div class = 'col_width_33 f-col'>   <!--~~ Social Media-->
                        <h1>Follow Us on Social Media</h1><br> 
                        <p>Follow our social media accounts to get news and updates on our different promotions.</p>                
                        <ul class= "social-icon">
                            <a href="https://facebook.com" class="social"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                            <a href="https://twitter.com" class="social"><i class="fa fa-twitter" aria-hidden="true"></i></a>
                            <a href="https://instagram.com" class="social"><i class="fa fa-instagram" aria-hidden="true"></i></a>
                        </ul>
                    </div>

                    <div class = 'col_width_33 f-col'> <!--~~ Account-->
                        <h1>Account</h1><br>
                        <?php 
                            if(isset($_SESSION['fname'])){      //If an account is signed in (as this entire row is only displayed if a customer is signed in or no on is signed in at all)
                                                                //Therefore SESSION 'fname' is good enough to tell if someone is signed in 
                                echo'                   
                                <ul class = "account" >  
                                    <a href="account.php?tab=acount&window=acc"><i class="fa fa-user" aria-hidden="true"></i> MyAcccount</a>
                                    <a href="account.php?tab=security&window=sec"><i class="fa fa-lock" aria-hidden="true"></i> Security</a>
                                    <a href="functions.php?check=logout"><i class="fa fa-fw fa-power-off"></i> Logout </a>
                                </ul>';
                            }else{      //If No account is signed in use this space to display employeelogin link
                                echo"
                                <ul class = 'account'>
                                    <a  href = 'employeelogin.php'><i class='fa fa-fw fa-user'></i> Employee Login </a>
                                </ul>";
                            }
                        ?>
                    </div>
                </div>
            <?php               
        }
        ?>
        <div class="row"><!--~~ Navigation-->
            <div class = 'col_width_60' id = 'footer'>
                <h1>Navigation</h1><br>
                <ul class='navlink'>
                    <a href="#top"> Back to Top</a>
                    <a href="../index.php">Home </a>
                    <?php

                        if (!isset($_SESSION['acctype'])){  //If account signed in is not an employee account display the following
                            echo'
                            <a href="placeorder.php?tab=order&window=neworder">Place Order</a>
                            <a href="delivery.php?tab=pack&window=package">Package Delivery</a>
                            <a href="contactus.php">Contact Us</a>
                            <a href="services.php">Our Services </a>
                            <a href="about.php">About Us </a>';

                        }else{ 
                            if ($_SESSION['acctype']!='non admin'){ //if account type is an employee and a manager or admin then  display the following
                                echo"
                                <a href='setup.php'><i class='fa fa-fw fa-gear'></i> Manager Page</a>
                                <a href='orders.php'>Customer Orders</a>";

                            }else //If employee account is non admin then display the following 
                                echo'<a href="orders.php">Customer Orders</a>';
                        }
                        if (!isset($_SESSION['fname'])){ //If there is no account signed in then display the following 
                            echo"
                            <a  href = 'register.php'> Signup </a>
                            <a  href = 'login.php'> Login </a>";

                        }else //Otherwise
                            echo "<a  href = 'register.php'> Logout </a>";
                    ?>

                </ul>
            </div>
        </div>
        <p id=copyright>Created by Javier Antoine &copy; 2022. All Rights Reserved. Tel: 1-868-783-4431 </p> 
        <?php
    }
    /*!~*/             

    //~ Header 
    function header_($nav,$user){    //This function is the entire header. $nav and $user are used to determine if to display navigation options/user options in the header aside from the logo depending on the page 
  
        $page= basename($_SERVER['PHP_SELF']); /* Returns The Current PHP File Name */
        ?>
        
            <div class='logo'>      <!--~~ Logo -->
                <img id ='headerlogo' onclick ='location.href="../index.php"' class= 'logo' src = "../images/logo.png" alt = "Company Logo" />
                &nbsp;&nbsp;<a id='compname' href="../index.php">Accel Couriers</a>
            </div>
            <div class="navbar">    <!--~~ Main Navigation -->
                <?php
                if ($nav=='nav'){           //Display Navigation Options 
                    if (!isset($_SESSION['acctype'])){          //If employee account not signed in 
                        echo'<a id="home" href="../index.php">Home</a>';
                        if(isset($_SESSION['fname'])){          //If customer account is signed in then display...
                            echo'
                            <a id="placeorder" href="placeorder.php?tab=order&window=neworder">New Order/Delivery</a>
                            <div class ="dropdownnav">
                                <a id="customerorders">History</a>
                                <div class = "dropdownnav-content">
                                    <a id="pacakge" href="orders.php">Package Delivieries</a>
                                    <a id="product" href="orders.php">Product Orders</a>
                                </div>
                            </div>
                            <div class ="dropdownnav">
                                <a id="about" href="about.php">About Us</a> 
                                <div class = "dropdownnav-content">
                                    <a id="contactus" href="contactus.php">Contact US</a>
                                    <a id="queries" href="queries.php">Queries</a>
                                </div>
                            </div>';
                        }else{              //If no account is signed in then display...
                            echo '
                            <a id = "ourservices" href="servrices.php">Our Services</a>
                            <a id="placeorder" href="placeorder.php?tab=order&window=neworder">New Order/Delivery</a>
                            <div class ="dropdownnav">
                                <a id="about" href="about.php">About Us</a> 
                                <div class = "dropdownnav-content">
                                    <a id="contactus" href="contactus.php">Contact US</a>
                                    <a id="queries" href="queries.php">Queries</a>
                                </div>
                            </div>';
                        }
                    }elseif($_SESSION['acctype']){      //If employee account is signed in however display...
                        echo "<a id='customerorders' href='orders.php'>Customer Orders</a>";
                    }
                }
                ?>   
            </div>
            <?php
                if ($user=='user'){     //Display Account Options 
            ?>
                    <div class='user'>   <!--~~ Account Options -->
                        <?php
                            if (!isset($_SESSION['fname'])){        //If no account signed in display...
                                echo"
                                <a  id ='register' href = 'register.php'><i class='fa fa-fw fa-user'></i> Signup </a>
                                <a  href = 'login.php'><i class='fa fa-fw fa-user'></i> Login </a>";
                            }else{  
                                if (isset($_GET['logout']))     //If logout button is pressed call logout function 
                                        logout();
                                if ((isset($_SESSION['acctype']))&&($_SESSION['acctype']=='admin')){    //If admin is in system setup then dsiplay
                                    echo "<a href='?logout'><i class='fa fa-fw fa-power-off'></i> Logout and Close System Setup </a>";
                                }else{              //Otherwise Display...
                                    echo"
                                    <a id = 'myaccount' href = 'account.php?tab=account&window=acc'> Hello ".$_SESSION['fname']." <i class='fa fa-fw fa-user'></i></a>
                                    <a href='?logout'><i class='fa fa-fw fa-power-off'></i> Logout </a>";
                                }
                            }
                        ?>
                    </div>
            <?php
                }
        echo 
        '<script type="text/javascript">
            function activeheaderlink(){
                var page = "'.$page.'";
                var link;
                if (page == "home.php"){
                        link = document.querySelector("#home");
                }else if (page == "register.php"){
                        link = document.querySelector("#register");
                }else if (page == "account.php"){ 
                    link = document.querySelector("#myaccount");
                }else if (page == "placeorder.php"){ 
                    link = document.querySelector("#placeorder");
                }else if ((page == "orders.php")||(page=="queryorder.php")){ 
                    link = document.querySelector("#customerorders");
                }
                link.classList.add("active");
            }
            activeheaderlink();
        </script>';
    }
    /*!~*/   


    //~ LOGIN 
    function login($logintype){
        include 'dbconnect.php';
        if (isset($_POST['login'])){        //If Login credentials are submitted
            $username = mysqli_real_escape_string ($con, $_POST['username']);           //Accept Username
            $password = mysqli_real_escape_string ($con, $_POST['password']);           //Accept Password 
            if (empty($username)){                              //If username is empty them tell user to enter username and refresh the page to avoid errors
               
                echo '<script type = "text/javascript"> alert("Please enter your username");</script>'; //checks to determine if the textfield entry is empty
            }elseif (empty($password)){                     //If usename is not empty but password field is empty then tell user to enter password and refresh page to avoid errors
                
                echo '<script type = "text/javascript"> alert("Please enter your password");</script>'; 
            }else{      //otherwise 
                if ($logintype=='customer'){            //If it is a customer trying to login check to see if username or email is in database
                    $sql = "select * from customers
                            where cusername = '$username' or custemail = '$username';";
                }else{                                  //If it is an employee trying to login check to see if username or email is in database
                    $sql = "select * from employees
                            where epusername = '$username' OR epemail = '$username';";
                }
                $result = mysqli_query ($con,$sql);     
                $check = mysqli_num_rows($result);      //Get number of rows returned from query 
                if ($check == 1){               //If a row is returned 
                    $result = mysqli_query ($con,$sql); //Run the code again since the result has already been used (with num_rows)
                    $row = mysqli_fetch_assoc($result);
                    if ($logintype=='customer')     
                        $hashed_password = $row['cpassword'];
                    else 
                        $hashed_password = $row['epassword'];
                    if (password_verify($password, $hashed_password)){          //Check to see if password is correct the set SESSION values
                        $_SESSION['username'] = $username;
                        $_SESSION['password']= $hashed_password;
                        if ($logintype=='customer'){        //If customer is login in the set the SESSION values as follows= 
                            $_SESSION['id'] = $row['custid'];
                            $_SESSION['fname'] = $row['cfname'];
                            $_SESSION['lname'] = $row['clname'];
                            $_SESSION['accaddress']= $row['accaddress'];
                            $_SESSION['acctown']= $row['acctown'];
                            $_SESSION['acccountry']= $row['acccountry'];
                            $_SESSION['deladdress']= $row['deladdress'];
                            $_SESSION['deltown']= $row['deltown'];
                            $_SESSION['delcountry']= $row['delcountry'];
                            $_SESSION['telnum'] = $row['custelnum'];
                            $_SESSION['email'] = $row['custemail'];
                            $_SESSION['security'] = $row['securequestion'];
                            $_SESSION['answer'] = $row['answer'];
                        }else{             //Otherwise Set SESSION values for employees
                            $_SESSION['id'] = $row['employeeid'];
                            $_SESSION['fname'] = $row['epfname'];
                            $_SESSION['lname'] = $row['eplname'];
                            $_SESSION['acctype'] =  $row['acctype'];
                            $_SESSION['telnum'] = $row['eptelnum'];
                            $_SESSION['email'] = $row['epemail'];
                            $_SESSION['security'] = $row['epsecurequestion'];
                            $_SESSION['answer'] = $row['epanswer'];

                        }
                        header('location:../index.php');        //redirect to index 
                    }else{  //If password cannot be verified then redirect to the appropreate lgoin screen based on $logintype and alert user of incorect password
                        if ($logintype=='customer')
                            header("Refresh: 0; url=login.php");
                        else
                            header("Refresh: 0; url=employeelogin.php");
                    
                        echo '<script type = "text/javascript"> alert("Inccorect Password");</script>'; 
                    }
                }else{  //If no row is returned then alert the user that they have an incorrect username or password and reload to appropriate login screen.
                    if ($logintype=='customer')
                        echo '<script type = "text/javascript"> alert("Incorrect Username or Password");window.location.href="login.php";</script>'; 
                    else
                        echo '<script type = "text/javascript"> alert("Incorrect Username or Password");window.location.href="employeelogin.php";</script>'; 
                }   
            }
        }
        echo'
        <img src ="../images/logo.png" id = "loginlogo"/>
        <br>
        <form  method = "post" >
            <br>
            <input type = "text" placeholder="Email or Username" name = "username" class = "username"/>
            </br>
            <input type = "password" placeholder="Password" name = "password" class = "password"/> 
            <br>
            <input id = "login" name = "login" type = "submit" class = "submitbutton" value = "Login" >    
            </br><br>
            <a id = forgotpassword href = "pwreset.php?'.$logintype.'"> Forgot Your Password?</a><br><br>
        </form>';
        if ($logintype!='employees') 
            echo '<a href = "register.php" class ="submitbutton">Create an Account</a><br><br';
    }
    /*!~*/ 


    //~ REGISTER (Signup)
    function register($type){               //This function registers account for a user depending on the $type variable (for employee or customer).
        include 'dbconnect.php';
        if (isset($_POST['register'])){                 //If The Registration form is submitted 
            $sql = array("select * from employees where epemail = '".mysqli_real_escape_string($con, $_POST['email'])."';",
                "select * from customers where custemail = '".mysqli_real_escape_string($con, $_POST['email'])."';",
                "select * from employees where epusername = '".mysqli_real_escape_string($con, $_POST['username'])."';",
                "select * from customers where cusername = '".mysqli_real_escape_string($con, $_POST['username'])."';");
            $i=0;
            $check =0;
            while ($check<1){       //While Check is less than 1
                $result = mysqli_query($con,$sql[$i]);      //Check the SQL statement to see if there is an account who already has the same username or email address
                if (mysqli_num_rows($result)){              //If the result returns a row 
                    if ($i<2)                               //If $i is less than 2 then it means that the email is already registered
                        $error= "<p>This email address is already registered. Please use another email address.";
                    else                                    //$i greater than two means that the username is already in use
                        $error= "This Username is already in use. Please create another Username";
                    $check=1;                               //Set $check to 1 to exit while loop
                }else{          //Otherwise if no row is returned 
                    if ($i>2)   //If $i is greater than two (meaning it is on the last sql statement in the array) then set $  
                        $check=2; //Set $check to two to be able to exit loop
                    else        //Otherwise increment $i by one 
                        $i++;
                }
            }
            if (!empty($error)){        // If there is a username or email tha has been used ready then display the error and send the user back to that specific input for them to correct it
                echo '<script type = "text/javascript"> alert("'.$error.'");</script>'; 
                if ($i<2)
                    echo '<script type = "text/javascript">window.location.href="#email</script>'; 
                else
                    echo '<script type = "text/javascript">window.location.href="#username</script>'; 
            }
            if ($check==2){     //Otherwise if the username and email have not been used 
                if ($type=='employee'){     //If thte type of account registration is employee then set the account type based on the form (otherwise $acctype is not used)
                    if (!isset($_POST['acctype']))
                        $acctype = 'non admin';
                    else
                        $acctype = $_POST['acctype'];
                }
                if ((mysqli_real_escape_string($con,$_POST['password']))==(mysqli_real_escape_string($con,$_POST['confirmpassword']))){      //If the passwords entered are the same...
                    $password= mysqli_real_escape_string($con, $_POST['password']);
                    $info= array($gender= $_POST['gender'],           //Initialize the array with the main account fields 
                                mysqli_real_escape_string($con, $_POST['firstname']), 
                                mysqli_real_escape_string($con, $_POST['lastname']),
                                strtolower(mysqli_real_escape_string($con, $_POST['username'])),
                                (password_hash($password, PASSWORD_DEFAULT)),
                                mysqli_real_escape_string($con, $_POST['telnumber']),
                                mysqli_real_escape_string($con, $_POST['email']),
                                strtolower(mysqli_real_escape_string($con, $_POST['security'])),
                                mysqli_real_escape_string($con, $_POST['answer'])
                                );
                    if ($type == 'customer'){       //If customer account is being registered then create address info array
                        $addressinfo=array(mysqli_real_escape_string ($con, $_POST['accaddress']),
                                    mysqli_real_escape_string ($con, $_POST['acctown']),
                                    mysqli_real_escape_string ($con, $_POST['acccountry']), 
                                    mysqli_real_escape_string ($con, $_POST['deladdress']),
                                    mysqli_real_escape_string ($con, $_POST['deltown']),
                                    mysqli_real_escape_string ($con, $_POST['delcountry']),
                                    mysqli_real_escape_string ($con, $_POST['dob']));
                        $info = array_merge($info,$addressinfo);        //and merge the both arrays
                        insertinfo($info,$table='customers');           //Create the customer account 
                    }else           //If employee account is being created then simply add $acctype as the last variable in the array
                        $info[9]=$acctype;

                    insertinfo($info,$table='employees');       //Create employee account 
                }else{          //If passwords entered are not the same 
                    echo '<script type = "text/javascript">alert("Your passwords do not match")window.location.href="#password</script>'; 
                }
            }
        }
        ?>
        <form id = "signupform" method = "post">
            <h2> Your Information: </h2>
            <label for= "gender">  Select a Gender:<span>*</span></label>   
            <select id = "gender" name = "gender" required>
                <option value ="">---</option>
                <option value = "Male"> Male</option>
                <option value = "Female"> Female</option>
                <option value = "Other"> Other</option>
            </select>
            <br><br><br>
            <div class='registername'> 
                <label for = "firstname" >First name:<span>*</span></label>
                <input id = "firstname" type = "text"  name = "firstname"  required/>
            </div>
            <div class='registername'> 
                <label for = "lastname" >Last name:<span>*</span></label>
                <input id = "lastname" type = "text" name = "lastname"  required/> 
            </div>
            <?php 
                if ($type=='customer'){
                    ?>
                <br><br><br><br>
                <label for = "dob"> Date of Birth:<span>*</span></label>
                <input id = "dob" type = "date" name = "dob" required/>
                <br><br>
                <?php
                }
                ?> 
            <br>
        
            <h2> Account Information: </h2>
            
            <label for = "emailaddress">Email Address:<span>*</span> </label><br>
            <input type = "email" placeholder="emailaddress@email.com" name = "email" class = "emailaddress" required/> 
            <br><br>
            <label for = "username">Username:<span>*</span></label><br>
            <input type = "text" name = "username"required/> 
            </br></br>
            <label for = "password">Password:<span>*</span></label><br>
            <input type = "password" name = "password"  required/> 
            </br></br>
            <label for = "password">Confirm Password:<span>*</span></label><br>
            <input type = "password" name = "confirmpassword" required/> 
            </br></br>
            <label for= "security">Security Question:<span>*</span></label> <br>    
            <select class = "security" name = "security" required>
                <option value ="">-- To be used when restting password --</option>
                <option value = "dog">What was the name of your first dog?</option>
                <option value = "street">What street did you grow up on?</option>
                <option value = "so">What was the name of your first boyfriend/girfriend?</option>
            </select>
            </br></br>
            <label for= "answer">Answer:<span>*</span></label> <br> 
            <input type = "text" name = "answer" class = "answer" required/></label>
            </br><br>
            <label for = "telnumber">Telephone Number (868):<span>*</span> </label><br>
            <input type = "text" name = "telnumber" class = "telnumber" required/> 
            <?php
                if ($type=='customer'){
            ?>
                    <h2>Account Address:</h2>
                    <label for = "accaddress">Street Line:<span>*</span></label><br>
                    <input type = "text" name = "accaddress" class = "accaddress"/>
                    </br></br>
                    <label for = "town">Town:<span>*</span></label><br>
                    <input type = "text" name = "acctown" class = "town"/>
                    </br></br>
                    <label for="country">Country: <span>*</span></label><br>
                    <select class="country" name="acccountry" required/>
                        <option value="Trinidad">Trinidad</option>
                        <option value="Tobago">Tobago</option>
                    </select>
                    </br></br>
                    <table><tr><td><h2>Delivery Address:</h2></td><td>&nbsp;&nbsp;(If different from account address)</td></tr></table>
                    <label for = "deladdress">Street Line:</label><br>
                    <input type = "text" name = "deladdress" class = "delddress"/>
                    </br></br>
                    <label for = "town">Town:</label><br>
                    <input type = "text" name = "deltown" class = "town"/>
                    </br></br>
                    <label for="country">Country: </label><br>
                    <select class="country" name="delcountry" />
                        <option value ="">---</option>
                        <option value="Trinidad">Trinidad</option>
                        <option value="Tobago">Tobago</option>
                    </select>
            <?php
                }
            ?>
            <?php
                if ((isset($_SESSION['acctype']))&&($_SESSION['acctype']=='admin')){
            ?>
                    <br><br>
                    <label for = "acctype">Admin Account:&emsp;(Manager accounts are created by Default)</label>
                    <input type = "checkbox" value = "manager" id ="check" name = "acctype"/>
                    <br><br><br><br>
            <?php 
                }else
                    echo '<br><br><br><br>';
            ?>
            <input type = "submit" value = "Create Account" id='createaccount' name = "register"/> 
        </form>
        <?php
    }

    /*!~*/ 

    //~ UPLOAD PAYMENT RECEIPT 
    function uploadpaymentreceipt($transaction){            //Used to upload payment reciepts for either package deliveries or product orders
        if(isset($_POST["submit"])) {                       //If the user submits a picture 
            $target_dir = "../payment_receipt_uploads/";             //Set target directory for upload 
            $folderName = $target_dir.$_SESSION['id']; //Initialize folder name that is to be used to store the file (Named bassed on customerID)
            $target_file = $folderName."/" .basename($_FILES["fileToUpload"]["name"]);  //This is the file to be uploaded (with its directory address)
            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));             //This stores the image file type 
            $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);             //Check to see if file being uploaded is an image by checking for its image size
            if($check !== false) {      //if Check is true then $uploadOK is set to one meaning the file is an image 
                $uploadOk = 1;
            } else {        //Otherwise set $uploadOK to 0 
                $uploadOk = 0;
            }

            if ($uploadOk == 1) {   //If file is confirmed to be an image      
                if(!is_dir($folderName)){   // Check to see if the folder already exist, if it does not then proceed to create the folder.
                    $folder2Create = $target_dir . $folderName;  
                    $folderCreated = mkdir($folder2Create, 0777);
                    if(!$folderCreated){            //If folder could not be created then alert user 
                        echo '<script type = "text/javascript"> alert("Folder Could Not Be Created.");</script>'; 
                        $check=0;           //Check is set to zero as to not continue with rest of file upload 
                    }else
                        $check=1;           //If the folder is successully created then set $check to 1 to continue with rest of file upload 
                }else
                    $check=1;       //If folder already exist then set $check to 1 to continue with rest of file upload 
                
                if ($check==1){     //Once folder exist 
                    if ($_FILES["fileToUpload"]["size"] > 500000) {   // Check file size to make sure it is not greater than 5KB
                    echo '<script type = "text/javascript"> alert("Sorry, your file is too large. Please Choose a file Under 500KB");</script>'; 
                    }else{  //Once it is smaller than 500KB
                        // Allow certain file formats
                        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "pdf" ) {
                            echo '<script type = "text/javascript"> alert("Sorry, only JPG, JPEG, PNG & PDF files are allowed.");</script>'; 
                        }else{
                            //Check To See if File upload already exist for order
                            $filename= array($target_dir."/".$_SESSION['id']."/".$_SESSION['id']."_".$transaction."id".$_GET[$transaction.'id'].".jpg",
                                            $target_dir."/".$_SESSION['id']."/".$_SESSION['id']."_".$transaction."id".$_GET[$transaction.'id'].".png",
                                            $target_dir."/".$_SESSION['id']."/".$_SESSION['id']."_".$transaction."id".$_GET[$transaction.'id'].".jpeg",
                                            $target_dir."/".$_SESSION['id']."/".$_SESSION['id']."_".$transaction."id".$_GET[$transaction.'id'].".pdf");
                            for($i=0;$i<4;$i++){
                                $existing_file = $filename[$i]; //Check the filepaths in the array to see if the file exist (with variable extension types)
                                if (file_exists($existing_file)){      //If the file already exist take note of file path by saving the current position of the array. 
                                    $type=$i;
                                }
                            }
                            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {        //If the file upload is successful then alert the user of the success 
                                echo '<script type = "text/javascript"> alert("Your File: '. htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])).' \nHas Been Uploaded Successfully.");window.location.href="queryorder.php?orderid='.$_GET['orderid'].'";</script>'; 
                                if (isset($type))       //If the file has already been submitted for this order then overwrite the previous file with the new one
                                    rename($target_file,$filename[$type]);
                                else                    //If no receipt has been uploaded for this specific order then 
                                    rename($target_file,$folderName."/".$_SESSION['id']."_".$transaction."id".$_GET[$transaction.'id'].".".$imageFileType);
                                $rows = mysqli_fetch_assoc($getinfo($_GET['orderid']));     //Get order information 
                                $info=array($rows['customerorders.orderid'],        //Set info to be sent to payment table in array
                                            $rows['customerorders.totalprice'],
                                            $folderName."/".$_SESSION['id']."_".$transaction."id".$_GET[$transaction.'id'].".".$imageFileType);
                                $table='payments';
                                $result=insertinfo($info,$table);       //Insert Transaction 
                            }else{          //If file upload was not successful for some reason then alert user and refresh the page 
                                echo '<script type = "text/javascript"> alert("Sorry, there was an error uploading your file.");window.location.href=queryorder.php?orderid='.$_GET['orderid'].';</script>'; 
                            }
                        }
                    }
                }
            }else{      //If file is not an image or pdf
                echo '<script type = "text/javascript"> alert("File Is Not an Image or PDF.");</script>'; 
            }
        }//Otherwise check to see if a receipt is already uploaded and give the user the option to view the uploaded file 
        $filepath = "../payment_receipt_uploads/".$_SESSION['id']."/".$_SESSION['id']."_".$transaction."id".$_GET[$transaction.'id'];       //Filepath of file that would exist
        $extension= array('jpg','jpeg','png','pdf');        //Different Extension types 
        $i=0;
        $check=0;
        while($check < 1){          
            $uploadedfile = $filepath.".".$extension[$i];              //full filepath of file that would be uploaded (could change based on extension type)
            if (file_exists($uploadedfile)){                        //If the file exist allow the user the view the file through a new window
                echo 'Payment Receipt Already Uploaded. <a onclick="viewreceipt(`'.$uploadedfile.'`)" >View photo</a><br><br><a onclick="<?php $check=2;?>">Re-Upload</a> Receipt';
                $check=1;   //Set $check to 1 to end the loop and also not continue with rest of function 
            }else 
                $check=2;  //If no file exist the set $check to 2 
        }
        if ($check == 2){   //If $check is set to 2 then allow the user to upload a file 
        ?>
            <button onclick="show()" class="submitbutton">Upload Receipt</button>
            
            <div id="myDropdown" class="dropdown-content">
                <br><br>
                <form method="post" enctype="multipart/form-data">
                    <table>
                        <tr>
                            <td><input type="file" name="fileToUpload" id="fileToUpload"></td>
                            <td><input class ='submitbutton' type="submit" value="Confirm" name="submit"></td>
                        </tr>
                    </table>
                </form>
            </div>
            <script type='text/javascript'>
                function show() {
                    document.getElementById("myDropdown").classList.toggle("show");
                    document.getElementById("Add").classList.toggle("hide");
                }
            </script>
            
        <?php
        }
        ?>
        <script>
            function viewreceipt(filepath){
                var file= filepath;
                window.open( file,
                            '_blank',
                            'menubar=no, width=800 , height=600');
            }
        </script>
        <?php
    }
    /*!~*/ 

    //~ PASSWORD RESET
    function passwordreset(){           //Used to reset an account password 
        include "dbconnect.php";
        if(isset($_GET['employees'])){   //If employee is in the URL then it is an employee account otherwise a customer account
            $type='employees';
        }else{
            $type='customers';
        }
        if ((!isset($_POST['account']))&&(!isset($_GET['account']))){       //If the email or username has not been submitted then promt the user for it      ~~ Promt User for account info
            echo '
            <br>Enter your username or email: &emsp;
            <form method="post">
                <input type="text" placeholder="Email or Username" name = "account"/>
                <br><br>
                <input type="submit" class = "submitbutton"/>
            </form>';
        }elseif ((empty($_POST['account']))&&(!isset($_GET['account']))){   //If the customer tries to submit a blank form 
            echo '<script type="text/javascript">alert("Please enter your email or username");window.location.href="pwreset.php?'.$type.'";</script>';
        }elseif ((!empty($_POST['account']))||(isset($_GET['account']))){  //Otherwise if the username/email is submitted
            if (isset($_GET['account']))
                $account = $_GET['account'];
            else
                $account = mysqli_real_escape_string($con,$_POST['account']);   //acept user email/usrname from the form 
            $sql = array("select * from employees where epemail = '$account' OR epusername ='$account';", 
                        "select * from customers where custemail = '$account' OR cusername = '$account';");
            $check=0;
            if ($type == 'employees')
                $result = mysqli_query($con,$sql[0]);
            else
                $result = mysqli_query($con,$sql[1]);
            if (mysqli_num_rows($result)){      //If the account exist 
                $rows = mysqli_fetch_array($result,MYSQLI_ASSOC);   //Store its calues in $rows 
                $check = 1; //Set $check to 1 ($to be used in continuing function and to stop loop)
            }
            if ($check == 1){   //If account is found display account email and name ask them to confirm it is their account        ~~ Confirm Account 
                if (isset($_POST['no'])){
                    header("location:pwreset.php?$type");
                }
                if ((!isset($_POST['yes']))&&(!isset($_GET['yes']))){   //If account has not been yet confirmed 
                    echo'
                    <table>
                        <tr>
                            <td>Is This Your Account?:&emsp;&emsp;</td>
                            <td>
                                <br> Email: &emsp;';
                                if ($type=='employees')
                                    echo $rows['epemail'];
                                else
                                    echo $rows['custemail'];
                                echo'
                                <br> Name: &nbsp;&nbsp;';
                                if ($type =='employees')
                                    echo $rows['epfname'].'&nbsp;'.$rows['eplname'];
                                else
                                    echo $rows['cfname'].'&nbsp;'.$rows['clname'];
                                echo'
                            </td>
                        </tr>
                    </table>
                    <br>
                    <form method = "post">
                        <input type="submit" value = "Yes" name ="yes" class = "submitbutton"/><br>
                        <input type="submit" value = "No" name ="no" class = "submitbutton"/><br>
                        <input type="hidden" value= "'.$account.'" name = "account"/>
                    </form>';
               
                }else{      //If account is confirmed then store account information into easier to use variables 
                    if ($type=='employees'){
                        $id= $rows['employeeid'];
                        $value = $rows['epsecurequestion'];
                        $email = $rows['epemail'];  
                        $correctanswer= $rows['epanswer'];
                    }else{
                        $id= $rows['custid'];
                        $value = $rows['securequestion'];
                        $email = $rows['custemail'];  
                        $correctanswer= $rows['answer'];
                    }
                    if (!isset($_POST['answer'])){     //After Account has been confirmed the security question must be answered. 
                                                       //If it is not yet submitted then display the question and the from  //~~ Security Question
                        echo '<b>Account: &emsp;'.$email.'</b><br><br>';
                        if ($value =='dog')
                            echo "What was the name of your first dog?";
                        elseif ($value =='street')
                            echo "What street did you grow up on?";
                        elseif ($value =='so')
                            echo "What was the name of your first boyfriend/girfriend?";
                        else
                            echo "Error: No security question found for account recovery";
                        echo '<br>
                            <form method="post">
                                <input type="hidden" name = "yes"/>
                                <input type="text" name = "answer"/>
                                <input type="hidden" value= "'.$account.'" name = "account"/>
                                <br><br>
                                <input type="submit" class = "submitbutton"/>
                            </form>';
                    }else{      //If security question answer has been submitted
                        if ($_POST['answer']==$correctanswer){  //If answer is correct then promt user to create new password       ~~ New Password
                            echo '<b>Account: &emsp;'.$email.'</b><br><br><br> Set New Password:<br><br> ';
                            if (isset($_POST['pwsubmit'])){     //If New password is submitted 
                                $password=array($id,                            //Create array with password values and account ID 
                                            mysqli_real_escape_string($con,$_POST['new']),
                                            mysqli_real_escape_string($con,$_POST['confirm']));
                               
                                $result = changepassword($password,$type,'reset');  //Attempt to change password 
                                if ($result==3){    //If a value is returned and it is 3 then passwords do not match 
                                    echo '<script type="text/javascript">alert("Your passwords do not match!");</script>';
                                }
                            }
                            echo"
                            <form method ='post'>
                                    <input type ='password' name ='new' placeholder='Enter New Password'/>
                                    <br><br>
                                    <input type ='password' name ='confirm' placeholder='Confirm Password'/>
                                    <br><br>
                                    <input type='hidden' value= '".$_POST['answer']."' name = 'answer'/>
                                    <input type='hidden' name = 'yes'/>
                                    <input type='hidden' value= '".$account."' name = 'account'/>
                                    <input type ='submit' name ='pwsubmit' class ='submitbutton' value ='Confirm'/>
                            </form>";
                        }else{  //If answer is wrong then alert user that the security question is incorrect and reload the page
                            echo '<script type="text/javascript">alert("Incorrect Answer");</script>';
                            echo '<script type ="text/javascript">window.location.href="pwreset.php?'.$type.'&yes&account='.$account.'";</script>';
                        }
                    }
                }
            }else{
                echo '<script type="text/javascript">alert("No account found: Incorrect Email or Username");window.location.href="pwreset.php?'.$type.'";</script>';
            }
        }
    }
    /*!~*/ 
 
    //~ CHANGE PASSWORD 
    function changepassword($password,$table,$option){
        include 'dbconnect.php';
        if ($table=='employees')
            $field=array('epassword','employeeid');
        else
            $field=array('cpassword','custid');
       
        if ($option=='change'){     //If it is simply a password change (from account menu)
            if (password_verify($password[0],$_SESSION['password'])){   //Verify that the 'current password' entered is correct  
                if ($password[1]==$password[2]){                //Verify that new passwords match 
                    $password= (password_hash($password[1], PASSWORD_DEFAULT)); //Hash password
                    $id = $_SESSION['id'];  //Store user ID
                }else{
                    return 3;       //If passwords do not match return 3
                }
            }else 
                return 4;
        }else{                  //If it is a password reset 
            if ($password[1]==$password[2]){    //If new passwords match 
                $id = $password[0];             //account user id 
                $password= (password_hash($password[1], PASSWORD_DEFAULT)); //Has password 
            }else 
                return 3;   //If passwords do not match return 3
        }
        $sql = "UPDATE $table SET $field[0] = '$password' WHERE $field[1] = $id ";  //Update statement for database 
        $result = mysqli_query($con,$sql);  //Update Password 
        if ($result){   //If update is successul 
            if($option=='change'){      //If it was a password change store the new password in $_SESSION and redirect user to account window 
                $_SESSION['password']=$password;
                echo '<script type="text/javascript">alert("Password Changed Successfully");window.location.href="account.php?window=sec&tab=security"</script>;';
            }else{  //Otherwise alert user of password reset success and redirect tot login page.
                if ($table=='employees')
                    echo '<script type="text/javascript">alert("Password Changed Successfully");window.location.href="employeelogin.php"</script>;';
                else   
                    echo '<script type="text/javascript">alert("Password Changed Successfully");window.location.href="login.php"</script>;';
            }
        }else //If the update could not be executed for some reason then display the error
            echo '<script type="text/javascript">alert("'.mysqli_error($con).'"); </script>;';         
    }
     /*!~*/ 

    //~ DATABASE CHECK 
    function databasecheck(){       //Checks if database is setup completely by looking for employee table (the database tables are created with a default admin employee account).
        include 'dbconnect.php';
        $sql = "select * from employees";
        $result = mysqli_query($con,$sql);
        if ($result){       //If there is a result return a 1 otherwise a 0
            return 1;
        }else
            return 0;
    }
    /*!~*/ 

    //~ GET INFORMATION FROM DATABASE 
    function getinfo($table){   //This function gets info from the database depending on the $table variable (used to determine what table and what records to retrieve)
        if ($table == 'all'){  //~~ All tables
                               //Used to see how many tables (and their names) are in the database
            include 'dbconnect.php';
            if (file_exists("databasename.txt")){
                $query= "SHOW TABLES FROM $database";
                $result=mysqli_query($con,$query);
                if ($result)
                    $rows = mysqli_num_rows($result);
                if ($rows>0){
                    return $result;
                }else 
                    return 0;
            }else{
                return 0;
            }
        }

        elseif ($table == 'employees'){     //~~ Employees 
            include 'dbconnect.php';
            $sql = "select * from employees; ";
            $result = mysqli_query($con,$sql);
            if (!$result)
                echo '<script type="text/javascript">alert("Somethign went wrong: "'.mysqli_error($con).'");</script>';
            else 
                return $result;
        }

        elseif ($table == 'allorders'){     //~~ All Orders 
            include "dbconnect.php";
            $sql = "SELECT * FROM CUSTOMERORDERS, ITEMS WHERE CUSTOMERORDERS.ORDERID = ITEMS.ORDERID ORDER BY CUSTOMERORDERS.ORDERDATE ASC;";
            $result = mysqli_query($con,$sql);
            if (!$result)
                echo '<script type="text/javascript">alert("Somethign went wrong: "'.mysqli_error($con).'");</script>';
            else 
                return $result;
        }

        elseif (isset($table)){         //~~ Specific customer order 
            include "dbconnect.php";
            $sql = "SELECT * FROM CUSTOMERS, CUSTOMERORDERS, ITEMS WHERE CUSTOMERS.CUSTID = CUSTOMERORDERS.CUSTID AND CUSTOMERORDERS.ORDERID = ITEMS.ORDERID AND CUSTOMERORDERS.ORDERID = '$table'";
            $result = mysqli_query($con,$sql);
            if (!$result)
                echo '<script type="text/javascript">alert("Somethign went wrong: "'.mysqli_error($con).'");</script>';
            else 
                return $result;
        }
    }
    /*!~*/ 


    //~ EDIT ACCOUNT INFORMATION 
    function accountedit($type,$info){          //Depending on the type of account and the information being edited (account details or security information)
        include 'dbconnect.php';
        if ($info=='details'){   //If account details are being edited  ~~ Account Information
            echo '<h1>Account Details</h1>';
            if(isset($_POST['cancel']))          //if user cancels the process then return 3 
                return 3;
            if(isset($_POST['submit'])){        //If user submis the form save the information in an array (depending on the type of account) 
                if ($type=='custedit'){             //Customer accounts
                    $info = array(mysqli_real_escape_string ($con, $_POST['deladdress']),
                        mysqli_real_escape_string ($con, $_POST['deltown']),
                        mysqli_real_escape_string ($con, $_POST['delcountry']), 
                        mysqli_real_escape_string ($con, $_POST['firstname']),
                        mysqli_real_escape_string ($con, $_POST['lastname']),
                        mysqli_real_escape_string ($con, $_POST['custelnum']));
                }else{  //Emplloyees are only allowed to update their telephone numbers 
                    $info = mysqli_real_escape_string ($con, $_POST['custelnum']);
                }
                $result = insertinfo($info,$type);      //Update account information 
                if ($result == '2'){    //If the function returns a two alert the user of the success of the update and reload the page 
                    echo '<script type = "text/javascript"> alert("Account Edit Successful");window.location.href="account.php?tab=account&window=acc";</script>'; 
                }else{      //Otherwise alert the user that something went wrong and eload the page to the eiting page 
                    echo '<script type = "text/javascript"> alert("Something went wrong");window.location.href="account.php?tab=account&window=acc&edit";</script>'; 
                }
            }
            echo"   
            <form method = 'post'>";        //The form for editing account details 
                if ($type=='custedit'){     //for customers 
                    echo
                    "<table id ='custedit'>
                        <tr>
                            <td><label for = 'firstname'><b>First name:</b></label><br>
                            <input type = 'text' name = 'firstname' value = '".$_SESSION['fname']."'/></td>
                        </tr>
                        <tr>
                            <td><label for = 'lastname'><b>Last name:</b></label><br>
                            <input type = 'text' name = 'lastname' value='".$_SESSION['lname']."'/><br></br></td>
                        </tr>
                        <tr>
                            <td ><label for = 'username'><b>Username:</b></label>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;".
                            $_SESSION['username']."<br></td>
                        </tr>
                        <tr>
                            <td ><label for = 'email'><b>Email:</b></label>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
                            ".$_SESSION['email']."</br></td>
                        </tr>
                        <tr>
                            <td ><label for = 'town'><b>Account Address: </b></label>&emsp;&emsp;
                            ".$_SESSION['accaddress'].', '. $_SESSION['acctown'].', '.$_SESSION['acccountry']."<br><br></td>
                        </tr>
                        <tr>
                            <td ><label for = 'town'><b>Delivery Address: </b></label></td>
                        </tr>
                        <tr>
                            <td ><br>Street Line<br><input type = 'text' name = 'deladdress' value = '".$_SESSION['deladdress']."'/><br>Town<br><input type = 'text' name = 'deltown' value ='".$_SESSION['deltown']."'/> Country<br><input type = 'text' name = 'delcountry' value ='".$_SESSION['delcountry']."'/><br></br></td>
                        </tr>
                        <tr>
                            <td ><label for = 'telephone'><b>Telephone: </b></label></td>
                        </tr>
                        <tr>
                            <td ><input type = 'text' name ='custelnum' value ='".$_SESSION['telnum']."' /><br></br></td>
                        </tr>
                        <tr>
                            <td><button type = 'submit' name = 'cancel' class= 'submitbutton'>Cancel<i class ='fa fa-fw fa-ban'></i></button>
                            &emsp;&emsp;<button type = 'submit' name = 'submit' class= 'submitbutton'>Done<i class ='fa fa-fw fa-check'></i></button></td>
                        </tr>
                    </table>
                    <br>";
                }else{          //For employeees, print their account info and allow them to update the telephone number. 
                    viewaccount();
                    echo
                    "<br>
                    <table>
                        <tr>
                            <td colspan =2><label for = 'telephone'><b>Telephone: </b></label></td>
                        </tr>
                        <tr>
                            <td colspan =1><input type = 'text' name ='custelnum' value ='".$_SESSION['telnum']."' /><br></br></td>
                        </tr>
                        <tr>
                            <td><button type = 'submit' name = 'cancel' class= 'submitbutton'>Cancel<i class ='fa fa-fw fa-ban'></i></button></td>
                            <td><button type = 'submit' name = 'submit' class= 'submitbutton'>Done<i class ='fa fa-fw fa-check'></i></button></td>
                        </tr>
                    </table>
                    <br>";
                }echo"
            </form>";
        }else{ //Otheriwse if security information is being edited     //~~ Security Information   
            echo "<h3>Account Recovery Information:</h3>";
            if(isset($_POST['submitrecov'])){           //If they submit the form to change recovery information
                if (empty($_POST['security']))
                    $error= 'Please select a security question';
                elseif (empty($_POST['answer']))
                    $error= 'Please enter your answer to the question';
                if (!empty($error)){
                    echo '<script type = "text/javascript"> alert("'.$error.'");</script>';
                    return;
                }
                $info=array(mysqli_real_escape_string($con,$_POST['security']),     //if not empty Accept the security question and the answer in an array 
                    mysqli_real_escape_string($con,$_POST['answer']));
                $return=insertinfo($info,'secedit');    //update security information 
                if ($return==3){    //If funtion returns a 3 then something went wrong. Alert the user and display the error 
                    echo '<script type = "text/javascript"> alert("Something went wrong: '.mysqli_error($con).'");window.location.href="account.php?tab=security&window=sec&edit";</script>';
                }elseif ($return ==2){  //If function returns a 2 then operation wa successful
                    echo '<script type = "text/javascript"> alert("Operation Successful");window.location.href="account.php?tab=security&window=sec";</script>'; 
                }
            }else{
            echo"
            <table>
                <tr><td><h4>Security Question:&emsp;&emsp;</h4></td></tr>
                <tr>
                    <td>
                        <select form='request' class = 'security' name = 'security' required>
                            <option value =></option>
                            <option value = 'dog'>What was the name of your first dog?</option>
                            <option value = 'street'>What street did you grow up on?</option>
                            <option value = 'so'>What was the name of your first boyfriend/girfriend?</option>
                        </select>
                        </td>
                </tr>
                <tr><td><h4>Answer:&emsp;&emsp;</h4><input type='text' name ='answer' value='' form='request'/><br></td></tr>
                <tr>
                    <td><a href='account.php?tab=security&window=sec'><button type = 'submit' class= 'submitbutton'>Cancel<i class ='fa fa-fw fa-ban'></i></button><a>&emsp;&emsp;
                    <button type = 'submit' form='request' name = 'submitrecov' class= 'submitbutton'>Done<i class ='fa fa-fw fa-check'></i></button></td>
                </tr>
            </table>";
            }
        }
    }
    /*!~*/

    //~ VIEW ACCOUNT INFORMATION 
    function viewaccount(){             //Used to print out all account inforamation stored in $SESSION
        include 'dbconnect.php';
        echo"
        <p><b>First name:</b>&nbsp;&nbsp;".$_SESSION['fname']." 
        </br></br>
        <p><b>Last name:</b>&nbsp;&nbsp;".$_SESSION['lname']."
        </br></br>
        <p><b>Username:</b>&nbsp;&nbsp;".$_SESSION['username']."
        </br></br>
        <p><b>Telephone: </b></label> &nbsp;&nbsp;".$_SESSION['telnum']."
        </br></br>
        <p><b>Email:</b></label> &nbsp;&nbsp;".$_SESSION['email']."
        <br><br>";
        if (!isset($_SESSION['acctype'])){
        echo'
            <p><b>Account Address:</b></label>&emsp;&emsp;'.$_SESSION['accaddress'].', '. $_SESSION['acctown'].', '.$_SESSION['acccountry'];
        }
    }
    /*!~*/

    //~ PRINT RECORDS 
    function printrecords($result,$table){  //This function is used to print records by accepting array info from the database from getinfo() function ($result) and printing in a table (dependent on $table)
        include 'dbconnect.php';
        $check = 0;     //Used to couunt the amount of records printed 
        $rows = 0;
        //~~ Admin and manager accounts
        if ($table == 'manager'){   //To print admin and manager accounts on setup page from employee table
            while ($rows=mysqli_fetch_array($result,MYSQLI_ASSOC)){
            echo 
            "<tr>";
                if (isset($_GET['delete']))  //If user request to delete an account (request sent through header)
                    deleteaccount($_GET['delete']); //delete account 
                if ($rows['acctype'] == 'non admin')  //Exclude non admin accounts from the array
                    $check = $check -1;     //skip over the line but reduce $check by one as this row shouldnt be counted 
                else{  //If account is manager or admin account 
                    foreach ($rows as $key => $record){
                        if(($key != 'epgender')&&($key!='epusername')&&($key!='epassword')&&($key!='epsecurequestion')&&($key!='epanswer'))
                            echo "<td>". $record . "&emsp;&emsp;</td>"; 
                    } 
                    echo "<td><a href='?delete=".$rows['employeeid']."'><i class='fa fa-fw fa-trash'></i></a></td>";    //Delete button 
                }echo 
            "</tr>";
            $check++;   //increase $check by one 
            }
        }
        //~~ Employee accounts (non admin)
        elseif ($table == 'employees'){ //Print employee accounts that are not manager or admin accounts. 
            while ($rows=mysqli_fetch_array($result,MYSQLI_ASSOC)){
                echo
                "<tr>";
                    if (isset($_GET['delete']))  //If user request to delete an account (request sent through header)
                        deleteaccount($_GET['delete']); //delete account 
                    if ($rows['acctype'] != 'non admin')   //If account type is not 'non-admin'
                        $check = $check -1;     //skip over the line but reduce $check by one as this row shouldnt be counted 
                    else{   //If account is 'non-admin'
                        foreach ($rows as $key => $record){
                            if(($key != 'epgender')&&($key!='epusername')&&($key!='epassword')&&($key!='acctype')&&($key!='epsecurequestion')&&($key!='epanswer'))
                                echo "<td>". $record . "&emsp;&emsp;</td>"; 
                        }
                        echo "<td><a href='?delete=".$rows['employeeid']."'><i class='fa fa-fw fa-trash'></i></a></td>";
                    }echo
                "</tr>";
                $check++;   //increase $check by one 
            }
        }
        //~~ All orders 
        elseif ($table[0] == 'allorders'){  //used to print orders (either for a specific customer or all orders)
            while ($rows=mysqli_fetch_array($result,MYSQLI_ASSOC)){
                $print='no';
                $orderid = $rows['orderid'];    // saved as a variable to make writing the rest of ode easier as it is used alot
                if(!isset($_SESSION['acctype'])){   //If customer account request to print orders
                    if ($_SESSION['id']==$rows['custid']){  //If customer ID saved in SESSION matches the cust id on the order
                        if ($table[1]=='all')   //If all records are to be printed $print is always yes 
                            $print='yes';       
                        elseif ($table[1]==$rows['ostatus'])    //If a filter is selected print is only yes when the order status matches the filter 
                            $print='yes';
                    }
                }else{  //If employee account is requesting to print orders 
                    if ($table[1]=='all')   
                        $print='yes';
                    elseif ($table[1]==$rows['ostatus'])
                        $print='yes';
                }
                if ($print=='yes'){     //Print row
                    ?>
                    <tr class = 'tablerow' onclick="location.href='queryorder.php?orderid=<?php echo $orderid;?>'"><?php  //make row clickable and link to query order
                        echo "<td>".$orderid."&emsp;&emsp;&emsp;&emsp;</td>
                        <td>".$rows['orderdate']."&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</td>
                        <td>".$rows['custid']."&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</td>
                        <td>".$rows['storename']."&emsp;&emsp;&emsp;&emsp;</td>
                        <td>".$rows['itemqauntity']."&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</td>
                        <td>".$rows['otype']."&emsp;&emsp;&emsp;&emsp;</td>
                        <td>".$rows['ostatus']."&emsp;&emsp;</td> 
                    </tr>";
                    $check++;   //increase $check by one (to show record has been printed/exist)
                }
            }
        }  
        //~~ Items
        elseif ($table == 'items'){ //Used to print items when querying an order
            while ($rows=mysqli_fetch_assoc($result)){
                echo"
                <tr>
                    <td><b>Product Name:</b> ".$rows['itemname']."</td>
                    <td><b>Product Type:</b> ".$rows['itemtype']." </td>
                    <td><b>Store:</b> ".$rows['storename']."</td>
                </tr>
                <tr>
                    <td colspan=2><br><b>Description:</b> ".$rows['addinfo']."<br></td>
                </tr>
                <tr>
                    <td colspan=1><br><b>Link to Item:</b> <a href='".$rows['itemreference']."'<br><br>".$rows['itemreference']."</a></td>
                </tr>
                <tr>
                    <td><br><b>Weight:</b> ".$rows['weight']."</td>
                    <td><br><b>Dimensions:</b> ".$rows['dimensions']."</td>
                    <td><br><b>Unit Cost:</b>$ ".$rows['unitcost']."</td>
                    <td><br></td>
                </tr>
                <tr>
                    <td><br><h3>Total Cost: $".$rows['totalprice']."</h3></td>
                <tr>";
            }
        }
        return $check;      //If $check is returned as 0 then no records exist for the type of record that is trying to be printed.
    }
    /*!~*/

    //~ EDIT ORDER
    function editorder($orderinfo){        //This function is used to edit the items on an order and accepts the orderinfo as a variable
        include 'dbconnect.php';
        if (isset($_POST['discard']))   //If the user chooses to discard any changes made to the order or cancel edit
            echo "<script type= 'text/javascript'>window.location.href='queryorder.php?orderid=".$_GET['orderid']."';</script>";        //reload to page without edit optino selected
        elseif (isset($_POST['update'])){   //If user submits the editorder form 
            $info = array(mysqli_real_escape_string($con,$_POST['storename']),
                        mysqli_real_escape_string($con,$_POST['itemname']),
                        mysqli_real_escape_string($con,$_POST['itemtype']),
                        mysqli_real_escape_string($con,$_POST['description']),
                        $_GET['orderid']);
            if (isset($_SESSION['acctype'])){  //if employee account is signed in then accept additional info from the form 
                $infoadd = array(mysqli_real_escape_string($con,$_POST['weight']),
                            mysqli_real_escape_string($con,$_POST['unitcost']),
                            mysqli_real_escape_string($con,$_POST['dimensions']),
                            mysqli_real_escape_string($con,$_POST['status']));
                $info = array_merge($info,$infoadd);    //merge all info into one array 
            }
            $process = insertinfo($info,'edititems');   //update order
            if ($process == 2){
                echo '<script type="text/javascript">alert("Item Edit Successful");window.location.href="queryorder.php?orderid='.$_GET['orderid'].'";</script>';
            }else 
                echo '<script type="text/javascript">alert("Operation Unsuccessful");window.location.href="queryorder.php?orderid='.$_GET['orderid'].'&check=edit";</script>';
        }
        while ($rows=mysqli_fetch_assoc($orderinfo)){       //Edit-order form
                echo"
                <form method = 'post'>
                    <tr>
                        <td>Product Name: <input type = 'text' name = 'itemname' value ='".$rows['itemname']."'/> &emsp;&emsp;</td>
                        <td>Product Type: <input type = 'text' name ='itemtype' value ='".$rows['itemtype']."'/> &emsp;&emsp;</td>
                        <td>Store: <input type = 'text' name = 'storename' value ='".$rows['storename']."'/>&emsp;&emsp;</td>
                    </tr>
                    <tr>
                        <td colspan=2 ><br>Description:&emsp;";
                            if (!isset($_SESSION['acctype']))
                                echo "<input id = 'description' type = 'text' name = 'description' value ='".$rows['addinfo']."'/>&emsp;&emsp;</td>";
                            else
                                echo "<input id = 'description' type = 'text' name = 'description' value ='".$rows['description']."'/>&emsp;&emsp;</td>     
                    </tr>
                    <tr>";
                        if (!isset($_SESSION['acctype']))
                            echo"<td><br>Link to Item: <input type = 'text' name = 'link' value = '".$rows['itemreference']."'/></td>";
                        else
                            echo" <td colspan=3><br>Link to Item: <a href='".$rows['itemreference']."'</a>".$rows['itemreference']."<br><br></td>
                    </tr>";
                    if (isset($_SESSION['acctype'])){       //Additional info for order (shown to employees only)
                        echo"
                        <tr>
                            <td><br>Dimensions: <input type = 'text' value = '".$rows['dimensions']."' name ='dimensions'/></td>
                            <td><br>Unit Cost: <input type = 'number' value = '".$rows['unitcost']."' min = '0' max = '100000' step ='0.01' name = 'unitcost'/>&emsp;&emsp;</td>
                            <td>";
                                $weight= $rows['weight'];
                                echo"<br> Weight:
                                <select name='weight'>
                                    <option value ='".$weight."'> ".$weight."</option>
                                    <option value = '< 5 pounds'> < 5 pounds </option>
                                    <option value = '5-10 pounds'> 5-10 pounds </option>
                                    <option value = '> 10 pounds'> > 10 pounds </option>
                                    <option value = '> 20 pounds'> > 20 pounds </option>
                                    <option value = '> 50 pounds'> > 50 pounds </option>
                                    <option value = '> 100 pounds'> > 100 pounds </option>
                                    <option value = '> 500 pounds'> > 500 pounds </option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <br>
                                <h3>Order Status:</h3>
                                <select name= status>
                                    <option value = '".$rows['ostatus']."'>---".$rows['ostatus']."---</option>
                                    <option value = 'Approved'> Approved </option>
                                    <option value = 'Not Approved'> Not approved </option>
                                    <option value = 'In transit'> In Transit </option>
                                    <option value = 'Completed'> Completed </option>
                                </select>
                            </td>
                        </tr>";
                    }
                    echo"
                    <tr>
                        <td><br><br><input type = 'submit' value = 'Cancel' class ='submitbutton' name = 'discard'/><br><br><input type = 'submit' class ='submitbutton' value = 'Confirm' name = 'update'/></td>
                    </tr>
                </form>";
        }
    }
    /*!~*/

    //~ INSERT INFORMATION
   function insertinfo($info,$type){       //This function inserts information into tables. It accepts the information to insert ($info) and the type of insert ($type)
        include 'dbconnect.php';
        if($type  == 'query'){
            $query = sprintf("%s,%s,%s \n",$info[0],$info[1],$info[2]);
            $myfile = fopen("../queries/queries.txt","a") or die("Unable to open file!");
            fwrite($myfile,$query);
            fclose($myfile);
        }

        //~~ Edit account information
        elseif ($type  == 'emaccedit'){     //edit employee account info
            $sql = "UPDATE employees SET eptelnum ='$info' WHERE employeeid = $_SESSION[id];";
            $result = mysqli_query($con,$sql);
            if ($result){
                $_SESSION['telnum']=$info;
                return 2;
            }else
                return 3;
        }

        elseif ($type  == 'custedit'){  //edit customer account info 
            $sql = "UPDATE customers
            SET deladdress = '$info[0]', deltown = '$info[1]', delcountry = '$info[2]', cfname = '$info[3]', clname = '$info[4]', custelnum = '$info[5]'
            WHERE custid = $_SESSION[id];";
            $result = mysqli_query($con,$sql); 
            if ($result){
                $_SESSION['deladdress']=$info[0];
                $_SESSION['deltown']=$info[1]; 
                $_SESSION['delcountry']=$info[2];
                $_SESSION['fname'] = $info[3];
                $_SESSION['lname'] = $info[4];
                $_SESSION['telnum'] = $info[5];
                return 2;
            }else 
                echo mysqli_error($con);
        }

        //~~ Edit security infomation
        elseif($type  == 'secedit'){  
            if (isset($_SESSION['acctype'])){
                $sql= "UPDATE employees SET epsecurequestion = '$info[0]', epanswer = '$info[1]' WHERE employeeid=$_SESSION[id];";
            }else{
                $sql= "UPDATE customers SET securequestion = '$info[0]', answer = '$info[1]' WHERE custid=$_SESSION[id];";
            }
            $result = mysqli_query($con,$sql); 
            if ($result){
                $_SESSION['security']=$info[0];
                $_SESSION['answer']=$info[1];
                return 2;
            }else
                return 3;
        }

        //~~ Creating accounts  
        elseif($type  == 'customers'){  //Creating a new customer account 
            $sql = sprintf('insert into customers (custgender,cfname,clname,cusername,cpassword,custelnum,custemail,securequestion,answer accaddress, acctown, acccountry, deladdress, deltown, delcountry, custdob)
            values ("%s","%s","%s","%s","%s","%s","%s","%s","%s","%s","%s","%s","%s","%s","%s","%s");',$info[0],$info[1],$info[3],$info[4],$info[5],$info[6],$info[7],$info[8],$info[9],$info[10],$info[11],$info[12],$info[13],$info[14],$info[15],$info[16]);
            $result = mysqli_query($con,$sql); 
            if ($result)
                echo '<script type = "text/javascript"> alert("Account Succefully Created");window.location.href="login.php";</script>'; 
            else
                echo '<script type = "text/javascript"> alert("'.mysqli_error($con).'");</script>';
        }
        
        elseif ($type  == 'employees'){ //Creating a new employee account
            //REVIEW - remove epsecure question from insert statement to allow for employee to set up on first time login
            //error_reporting(E_ERROR | E_WARNING | E_PARSE); 
            $sql = sprintf('insert into employees (epgender,epfname,eplname,epusername,epassword,eptelnum,epemail,epsecurequestion,epanswer,acctype)
            values ("%s","%s","%s","%s","%s","%s","%s","%s","%s","%s");',$info[0],$info[1],$info[2],$info[3],$info[4],$info[5],$info[6],$info[7],$info[8],$info[9]);
            $result = mysqli_query($con,$sql);
            if (!$result)
                echo mysqli_error($con);
            else
                echo '<script type="text/javascript">alert("Operation succesfull");window.location.href = "setup.php";</script>';
        }

        //~~ Customer orders and Package delieveries
        elseif ($type  == 'orders'){    // Create a new order 
            //error_reporting(E_ERROR | E_WARNING | E_PARSE);
            $sql = sprintf("insert into customerorders(custid,orderdate,addinfo,odelicate,itemqauntity,otype,ostatus)
            values( '%d',NOW(),'%s','%s','%d','%s','Pending');",$info[0],$info[2],$info[3],$info[4],$info[5]);
            $result = mysqli_query($con,$sql);  //create order
            if ($result){       // if order is created then insert items for order 
            // $check= $date->format('Y-m-d H:i:s');
                $sql = "select orderid from customerorders where custid = '$info[0]' and orderdate = '$info[1]';";
                $result = mysqli_query($con,$sql);
                $id = mysqli_fetch_array($result,MYSQLI_NUM);
                $sql = sprintf('insert into items(orderid,itemreference,storename,itemname,itemtype)
                values ("%d","%s","%s","%s","%s");',$id[0],$info[7],$info[8],$info[9],$info[10]);
                $result = mysqli_query($con,$sql);
                if($result){
                    return 2 ;
                }else 
                    return 3;
            }else 
                echo "something went wrong: ".mysqli_error($con);
        }

        elseif ($type  == 'edititems'){     //Updating an order's items/status 
            $orderid = $info[4];        //set variable name as orderid would be used more than once
            $itemsbasic = "UPDATE items SET storename = '$info[0]', itemname = '$info[1]' , itemtype = '$info[2]' WHERE orderid = '$orderid';"; //SQL to update Items that employees AND customers can edit
            if (isset($_SESSION['acctype'])){   //If employee account is editing order  
                $itemsaddition = "UPDATE items SET description = '$info[3]', weight = '$info[5]' , unitcost = '$info[6]', dimensions = '$info[7]' WHERE orderid= '$orderid';";    //Sql to update Order items that employees can edit
                //Math to calculate total price of order based on the weight of the item and the unit cost
                if ($info[5]=='5-10 pounds'){   
                    $clearing = $info[6] * 0.05;
                }
                elseif ($info[5]=='> 10 pounds'){
                    $clearing = $info[6] * 0.1;
                }
                elseif ($info[5]=='> 20 pounds'){
                    $clearing = $info[6] * 0.2;
                }
                elseif ($info[5]=='> 50 pounds'){
                    $clearing = $info[6] * 0.3;
                }
                elseif ($info[5]=='> 100 pounds'){
                    $clearing = $info[6] * 0.5;
                }
                elseif ($info[5]=='> 500 pounds'){
                    $clearing = $info[6] * 0.65;
                }
                $total = $info[6] + $clearing;
                $orderupdate = "UPDATE customerorders SET ostatus = '$info[8]', totalprice = $total where orderid = '$orderid';";   //sql to Update order total price and its status
                $sql = $itemsbasic.$itemsadditional.$orderupdate;   //full SQL statement if employee account is being used
            }else   //If customer account is editing order 
                $sql=$itemsbasic;
            $result = mysqli_multi_query($con,$sql); //Update order information 
            if ($result)    //If update is successful return 2 otherwise return 3 
                return 2;
            else
                return 3;
        }

       //~~ Payment information
        elseif ($type  == 'payments'){      //Insert payment record for a package delievery or order 
            $sql = sprintf('insert into payments(orderid,amount,receipt)
            values ("%s","%s","%s");',$info[0],$info[1],$info[2]);
            $result = mysqli_query($con,$sql); 
            if($result){
                echo '<script type= "text/javascript">alert("Operation succesfull");<script>';
            }else 
                echo '<script type="text/javascript">alert("Something went wrong while trying to insert item data for the order:\n'.mysqli_error($con).'");</script>';
        }
        
    }  
?>

