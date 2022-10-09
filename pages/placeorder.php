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
        <main>
            <header class = ' scrolled1 fadeIn'> <!--HEADER-->
                <?php header_('nav','user');?>  
            </header>
        
            <page class ="animated fadeInRight">  <!--MAIN CONTENT ON PAGE (MINUS HEADER)-->
                <br></br><br>
                <div class = 'row' id='order_package_nav'>  <!--NAVIGATION BAR FOR PAGE (ORRDER OR PACKAGE DELIVERY)-->
                    <a id = 'order' href="?tab=order&window=neworder"><button class ='submitbutton getstarted Getstarted'>&emsp;Order Product&emsp;</button></a></li>
                    &emsp;&emsp;&emsp;&emsp;
                    <a id = 'pack' href="?tab=pack&window=package"><button class ='submitbutton getstarted Getstarted'>&emsp;Package Delivery&emsp;</button></a></li>
                </div>
                <div id='package' class ='row hide'> <!--~ PACKAGE DELIVERY-->
                    <h2>Package Delivery</h2>
                    <div class = 'box'>
                        <h1>Package Details</h1>
                        <form method = "post">
                            <label>Item Type: </label> &emsp;
                            <select class = "gender" name = "ptype" required>
                                <option value ="">---</option>
                                <option value = "phone"> Phone </option>
                                <option value = "laptop"> Laptop </option>
                                <option value = "furniture"> Furniture </option>
                                <option value = "kitchen appliance"> Kitchen Appliance </option>
                                <option value = "headphone"> Headphone</option>
                                <option value = "pther"> Other </option> 
                            </select>
                            <br></br><br>
                            <Label>Item Name: </label> <br>
                            <input type = "text" name="pname" value=""/>
                            <br></br>
                            <label>Description of item: </label><br>
                            <input type = "text" name="link" value=""/>
                            <br></br>       
                            <label for = "dob"><b> Date and Time for Pickup:</b><span>*</span></label>
                            <label>Date: </label>
                            <input class = "dob" type = "date" name = "dob" required/>
                            <br><br><br>
                            <label>Pickup Time </label>
                            <input class = "dob" type = "time" name = "dob" required/><br>
                            <br><br>
                            <Label>Additional Info About Delivery(Optional): </label> <br>
                            <input type = "text" name="addinfo" value=""/>
                            <br></br>
                            <table><tr><td><h2>Pickup Address</h2></td><td>&nbsp;&nbsp;(If different from account address)</td></tr></table>
                            <label for = "deladdress"><b>Street Line</b></label><br>
                            <input type = "text" name = "deladdress" class = "delddress"/>
                            </br></br>
                            <label for = "town"><b>Town:</b></label><br>
                            <input type = "text" name = "deltown" class = "town"/>
                            </br></br>
                            <label for="country"><b>Country: </b></label><br>
                            <select class="country" name="delcountry" />
                                <option value ="">---</option>
                                <option value="Trinidad">Trinidad</option>
                                <option value="Tobago">Tobago</option>
                            </select>
                            <br><br>
                            <table><tr><td><h2>Delivery Address</h2></td><td>&nbsp;&nbsp;</td></tr></table>
                            <label><b>Street Line</b></label><br>
                            <input type = "text" name = "deladdress" class = "delddress"/>
                            </br></br>
                            <label><b>Town:</b></label><br>
                            <input type = "text" name = "deltown" class = "town"/>
                            </br></br>
                            <label><b>Country: </b></label><br>
                            <select class="country" name="delcountry" />
                                <option value ="">---</option>
                                <option value="Trinidad">Trinidad</option>
                                <option value="Tobago">Tobago</option>
                            </select>
                            <br><br>
                            <br></br><br><br><br>

                            <input type= "submit" class="submitbutton" id = 'placeorder' value= "Confirm"  name = "submitorder"/>
                        </form> 
                    </div>
                </div>
                <div id='neworder' class ='row hide'><!--~ NEW PRODUCT ORDER-->
                    <h1> Place Order </h1>
                    <div class = 'box' id="placeorder">
                        <?php
                            if (isset($_POST['submitorder'])){  //If submit order button is pressed 
                                date_default_timezone_set("America/New_York"); //Set the date and time format
                                $date = new DateTime(); //capture currennt date and time 
                                $info1=array($_SESSION['id'],               //Insert first set of information into $info array
                                            $date->format('Y-m-d H:i:s'),
                                            mysqli_real_escape_string($con,$_POST['addinfo']),
                                            );
                                if (!isset($_POST['delicate'])){
                                    $delicate = array('no');
                                }else{
                                    $delicate = array(mysqli_real_escape_string($con,$_POST['delicate']));
                                }
                                $info=array_merge($info1,$delicate);    //MErge $info1 and $delicate to place it at [3] position in the array
                                $info2= array(mysqli_real_escape_string($con,$_POST['quantity']), //Insert Rest of information into $info2 array
                                            mysqli_real_escape_string($con,$_POST['otype']),
                                            mysqli_real_escape_string($con,$_POST['link']),
                                            mysqli_real_escape_string($con,$_POST['storename']),
                                            mysqli_real_escape_string($con,$_POST['pname']),
                                            $_POST['ptype']);
                                $info=array_merge($info,$info2); //Merge info2 and $info
                                $result= insertinfo($info,'orders');    //Insert Information into orders
                                if($result==2)  //if result returned is 2 then show operation success alert
                                    echo '<script type= "text/javascript">alert("Operation succesfull");window.location.href="account.php?tab=orders&window=ord"</script>';
                                elseif($result==3) //Otherwie display error alert
                                    echo '<script type="text/javascript">alert("'.mysqli_error($con).'");</script>';
                            }
                        ?>
                        <h1> Product Details </h1>
                        <form method = "post"> <!--Form for New Order-->
                            <label>Product Type: </label> &emsp;
                            <select class = "gender" name = "ptype" required>
                                <option value ="">---</option>
                                <option value = "phone"> Phone </option>
                                <option value = "laptop"> Laptop </option>
                                <option value = "furniture"> Furniture </option>
                                <option value = "kitchen appliance"> Kitchen Appliance </option>
                                <option value = "headphone"> Headphone</option>
                                <option value = "pther"> Other </option> 
                            </select>
                            <br></br><br>
                            <Label>Name of Store: </label> <br>
                            <input type = "text" name="storename" value=""/>
                            <br></br>
                            <Label>Product Name: </label> <br>
                            <input type = "text" name="pname" value=""/>
                            <br></br>
                            <label>Quantity:</label>
                            <input class = "quantity" type = "number" value ="1"  name="quantity"/>
                            <br><br>
                            <label>Link to Item: </label><br>
                            <input type = "text" name="link" value=""/>
                            <br></br>       
                            <Label>Additional Info (Optional): </label> <br>
                            <input type = "text" name="addinfo" value=""/>
                            <br></br>
                            <label>Delicate Item: </label><br>
                            <input id='ordercheckbox' type = "checkbox" name="delicate"/>
                            <br><br>
                            <label>Order Type </label>
                            <select class = "gender" name = "otype" required>
                                <option value ="">---</option>
                                <option value = "Regular"> Regular</option>
                                <option value = "Fast"> Fast</option>
                            </select>
                            <br></br><br><br><br>

                            <input type= "submit" class="submitbutton" id = 'placeorder' value= "Place Order"  name = "submitorder"/>
                        </form> 
                    </div>
                </div>
                <script type="text/javascript">
                    function tab(t,win){
                        var win = win;
                        var tab = t;
                        
                        tab.classList.toggle("selected");
                        win.classList.toggle("show");
                    }
                </script>
                <script src="jquery.js"></script>
            </page>
        </main>      
        <footer><!--FOOTER-->
            <?php footer_('contact');?>
        </footer>
    </body>
</html>