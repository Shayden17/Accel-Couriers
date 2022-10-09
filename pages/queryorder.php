<!doctype html> 
<html>
    <head> 
        <title> Place Order </title>
        <link href ="../css/style.css" rel="stylesheet" type="text/css"/>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <?php session_start();include 'dbconnect.php';include 'functions.php'; if (!isset($_SESSION['fname'])){header("location:register.php");}?>
    </head>
    <body>
        <main>
            <header class = ' scrolled1 fadeIn'><!--HEADER-->
                <?php header_('nav','user');?>  
            </header>
             
            <page class ='animated FadeInRight'><!--MAIN CONTENT ON PAGE (MINUS HEADER)-->
                <div class = 'row'>
                    <br>
                    <?php 
                        echo 
                        "<a href ='orders.php'><button class ='submitbutton'> Go Back</button></a>
                        <br><br>
                        <div class = 'box'>
                            <h2>Order ID: #".$_GET['orderid']."</h2>";
                            
                            $orderid = $_GET['orderid'];        //Initalize $orderid
                            $result = getinfo($orderid);        //Get info on order
                            $rows = mysqli_fetch_assoc($result);//Initialize $rows so that data can be pulled by column association
                            echo
                            "<h4>Customer Name: &emsp;".$rows['cfname']."&nbsp; ".$rows['clname']."&emsp;&emsp;&emsp;&emsp;Customer Id:&emsp;".$rows['custid']."</h4> 

                            <h4> Delivery Address:<br>
                                Street: "; if ($rows['deladdress']==''){ echo $rows['accaddress'];}else{ echo $rows['deladdress'];} echo "<br><br>
                                Town: "; if ($rows['deltown']==''){ echo $rows['acctown'];}else{ echo $rows['deltown'];} echo "&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;  Order Status: ".$rows['ostatus']."<br><br>
                                Country: "; if ($rows['delcountry']==''){ echo $rows['acccountry'];}else{ echo $rows['delcountry'];} echo "&emsp;&emsp;
                            </h4>
                            <br>
                            <h3>Items:</h3>";
                            
                            if (!isset($_GET['edit'])){    //If edit is not  sent in the url then table is only items 
                                if ((isset($_SESSION['acctype']))||($rows['ostatus']=='Pending')){      //if Order is Not approved and user is a manager/employyee they can make edits to the order
                                    echo '<a href="queryorder.php?orderid='.$orderid.'&edit"><button type = "submit" class ="submitbutton">Edit Items</button></a></br></br>';
                                }
                            }echo" 
                            <table id='items'>";
                                $result = getinfo($orderid);        //get information for order again (initalize $result again)
                                if (!isset($_GET['edit'])){         //If edit is sent in the URL then call editorder() funtion otherwise table = 'items' and print itmes based on order info
                                    $result = printrecords($result,'items'); 
                                }else{ 
                                    editorder($result);       //editorder()
                                }
                                echo" 
                                
                            </table>";
                            if ((!isset($_SESSION['acctype']))&&($rows['ostatus']== 'Approved')){
                                echo"<br>";
                                uploadpaymentreceipt('order');
                            }
                            echo" 
                        </div>";
                    ?>
                </div>
            </page> 
        </main>
        <footer><!--FOOTER-->
            <?php 
                if (isset($_SESSION['acctype']))
                    footer_('');
                else
                    footer_('contact');
            ?>
    </body> 
</html>