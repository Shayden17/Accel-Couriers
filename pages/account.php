<!doctype html> 
<html>
    <head> 
        <title> Place Order </title>
        <link href ="../css/style.css" rel="stylesheet" type="text/css"/>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <?php session_start();include 'dbconnect.php';include 'functions.php';$tab= $_GET['tab'];$window= $_GET['window'];?>
    </head>
    <body onload='tab(<?php echo $tab;?> , <?php echo $window;?>)'>
        <main> <!--MAIN CONTENT CONTAINER (MINUS FOOTER)-->
            <header class='scrolled1'>
                <?php header_('nav','user');?>
            </header>
            <page class ='animated FadeInRight'>  <!--MAIN CONTENT ON PAGE (MINUS HEADER)-->
                <br><br><br>
                <div  class = 'sidebar'>     <!--VERTICAL NAVIGATION BAR ON LEFT SIDE OF 'WINDOW'--><!--~ SIDEBAR--> 
                    <br><br>
                    <ul class = 'sidenav'>
                        <li><a id = 'account' href="?tab=account&window=acc">Account Information</a></li>
                        <?php 
                            //if (!isset($_SESSION['acctype']))
                                //echo "<li><a id = 'notif' href='?tab=notif'>Notifications</a></li>";
                        ?>
                        <li><a id = 'security' href="?tab=security&window=sec">Security Settings</a></li>
                    </ul>
                </div>
                
                <div class = 'window'>  <!--'DIV WINDOW THAT DISPLAYS THE CONTENT BASE ON TAB VERITICAL NAVBAR SELECTION--><!--~ WINDOW-->
                    <div id = 'acc' class = 'hide'> <!--~ ACCOUNT-->
                            <?php
                                if (isset($_GET['edit'])){ //If Edit button is pressed 
                                    if (isset($_SESSION['acctype']))    //Depending on account type call function employeeedit or customer edit 
                                       $return= accountedit('emedit','details');
                                    else
                                        $return= accountedit('custedit','details');  

                                    if ($return ==3)    //If function returns 3 then reload page without edit function 
                                        header('location:account.php?tab=account&window=acc');
                                }else{                  //Else simply display account details 
                                    echo " <h1> Account Details: &emsp;&emsp;&emsp;<a href ='?tab=account&edit&window=acc'><button class= 'submitbutton'>Edit Info<i class ='fa fa-fw fa-pencil'></i></button></a> </h1>";
                                    viewaccount();
                                }
                            ?>
                    </div>
                    <div id = 'sec' class ='hide'><!--~ SECURITY SETTINGS-->
                        <h1>Security Settings</h1>
                        <?php 
                            if (isset($_GET['pwchange'])){      //if "change Password Button is pressed
                                if (isset($_POST['submit'])){   // If old and new passwords are suubmitted send the information to the changpassword() function
                                    $password=array(mysqli_real_escape_string($con,$_POST['current']),
                                                    mysqli_real_escape_string($con,$_POST['new']),
                                                    mysqli_real_escape_string($con,$_POST['confirm']));
                                    if ($_SESSION['acctype'])
                                        $return=changepassword($password,'employees','change');
                                    else 
                                        $return=changepassword($password,'customers','change');
                                   
                                    if ($return=='3'){  //if function returns a 3 then the new passwords do not match 
                                        echo '<script type="text/javascript">alert("New Passwords do not match");window.location.href="?tab=security&window=sec&pwchange"</script>;';                         
                                    }
                                    elseif ($return=='4'){// If function returns a 4 then the current password is incorrect
                                        echo '<script type="text/javascript">alert("Incorect Current Password");window.location.href="?tab=security&window=sec&pwchange"</script>;';                                    
                                    }
                                }
                                echo"
                                    <form id='pwchange' method =post>".//Password Chagnge form 
                                        "<input type ='password' name ='current' placeholder='Enter Old Password'/>
                                        <br><br>
                                        <input type ='password' name ='new' placeholder='Enter New Password'/>
                                        <br><br>
                                        <input type ='password' name ='confirm' placeholder='Confirm Password'/>
                                        <br><br>
                                    </form>
                                    <input type ='submit' form ='pwchange' name ='' class ='submitbutton' value ='Confirm'/>&emsp;&emsp;<a href='account.php?tab=security&window=sec'><input type ='submit' class ='submitbutton' value ='Cancel'/></a>";
                            }elseif (isset($_GET['edit'])){ //If Edit Recovery information button is pressed call the accountedit() funtion
                                if (isset($_SESSION['acctype']))
                                    accountedit('emedit','security');
                                else
                                    accountedit('custedit','security');
                            }else{ //Otherwise 'Show Change password' and 'Change Security information' buttons as well as the current security question & answer
                                echo 
                                    "<h3>Password:</h3>
                                    <a href='?tab=security&window=sec&pwchange'><button class ='submitbutton'>Change Password</button></a>
                                    <br><br>
                                    <h3>Account Recovery Information: &emsp; <a href ='?tab=security&edit&window=sec'><button class= 'submitbutton'>Edit Recovery Info<i class ='fa fa-fw fa-pencil'></i></button></a></h3>
                        
                                    <table>
                                        <tr>
                                            <td>
                                                <b>Security Question:&emsp;</b>";
                                                    $value=$_SESSION['security'];
                                                    if ($value =='dog')
                                                        echo "What was the name of your first dog?";
                                                    elseif ($value =='street')
                                                        echo "What street did you grow up on?";
                                                    else 
                                                        echo "What was the name of your first boyfriend/girfriend?";
                                                
                                echo"
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><b>Answer:&emsp;&emsp;</b>".$_SESSION['answer']."</td>  
                                        </tr>
                                    </table>";
                        
                            }
                        ?>
                    </div>
                    <script type="text/javascript"> //Scrip to select what information shows in the window as long as highlighting the vertical navigation tab
                        function tab(t,win){
                            var win = win;
                            var tab = t;
                            
                            tab.classList.toggle("selected");
                            win.classList.toggle("show");
                        }
                    </script>
                </div>
                <div class = row></div>
            </page>
        </main> 
        <footer><!--Footer-->
            <?php footer_('contact');?>
        </footer>
        
    </body>
</htm>