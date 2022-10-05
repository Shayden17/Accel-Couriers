<!doctype html> 
<html>
    <head> 
    <title> Template Page </title>
        <link href ="../css/style.css" rel="stylesheet" type="text/css"/>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <?php 
            include 'functions.php'; include 'dbconnect.php'; session_start();
            if (!isset($_SESSION['username']))
                session_destroy();
            if ((!isset($_SESSION['acctype']))&&(!isset($_GET['id'])))
                header('location:?id="'.$_SESSION['id'].'"');
        ?>
    </head>
    <body>
        <main>
            <header class = ' scrolled1 fadeIn'> <!--HEADER-->
                <?php header_('nav','user');?>  
            </header>
            <page class ='animated FadeInRight'><!--MAIN CONTENT ON PAGE (MINUS HEADER)-->
                <div class = 'row'>
                    <h2> Customer Orders </h2>
                    <form method='get'>
                        <label>Filter By:</label>&emsp;<select name = 'filter'><option value = '<?php if (isset($_GET['filter'])){echo $_GET['filter'];}?>'> --<?php if (isset($_GET['filter'])){echo $_GET['filter'];}?>--</option><option value = 'all'> All </option><option value = 'Approved'> Approved </option><option value = 'Pending'> Not approved </option><option value = 'In transit'> In Transit </option><option value = 'Completed'> Completed </option></select> 
                        <?php if (isset($_GET['id'])){echo "<input type = 'hidden' name = 'id' value = '".$_GET['id']."'/>";}?>
                        <input type='submit' value ='Apply' class ='submitbutton'/>
                    </form>
                    <div class = 's-row'>
                        <table id='printrecords'>
                            <tr>
                                <th align = "left"><h4>Order ID &emsp;&emsp; </h4></th> 
                                <th align = "left"><h4>Order Date &emsp;&emsp;&emsp;&emsp;</h4></th> 
                                <th align = "left"><h4>Customer ID &emsp;&emsp;</h4></th> 
                                <th align = "left"><h4>Store &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</h4></th>
                                <th align = "left"><h4>Item Quantity &emsp;&emsp;</h4></th> 
                                <th align = "left"><h4>Order Type &emsp;&emsp;</h4></th>
                                <th align = "left"><h4>Status </h4></th>
                            </tr>
                                <?php 
                                    $table = 'allorders';
                                    $result = getinfo($table);                  //get info from customer orders table
                                    if (isset($_GET['filter']))
                                        $tab=array('allorders',$_GET['filter']);    //Filter for type of order 
                                    else
                                        $tab=array('allorders','all');
                                    $check = printrecords($result,$tab);        //print orders 
                                    if ($check == 0){
                                        printf('<td colspan ="7" align = "center"> No Records Available</td>');
                                    }
                                ?> 
                            </tr>
                        </table>
                        <br></br>
                    </div>
                </div>
            </page>
        </main>
        <footer>    <!--FOOTER-->
            <?php if (isset($_SESSION['acctype']))
                        footer_('');
                    else 
                        footer_('contact'); 
            ?>
        </footer>

    </body> 
</html>