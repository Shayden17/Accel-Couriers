<!doctype html> 
<html>
    <head> 
        <title> Template Page </title>
        <link href ="../css/style.css" rel="stylesheet" type="text/css"/>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"/>
        <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <?php session_start();include 'dbconnect.php'; include 'functions.php';?>
    </head>
    <body>
        <main> <!--MAIN CONTENT CONTAINER (MINUS FOOTER)-->
            <header class=" scrolled1 fadeIn"><!--~ Header-->
                <?php header_('','user');?>
            </header>
            <page class ='animated FadeInRight'><!--MAIN CONTENT ON PAGE (MINUS HEADER)-->
                <br><br>
                <div class= 'row '>
                    <h1 id= 'welcome'>Hello <?php echo $_SESSION['fname'];?>, Welcome Back</h1>
                    <br><br><br>
                     <button onclick = 'location.href="placeorder.php?tab=order&window=neworder"' class = 'userhomebutton'><i class="fa fa-plus-circle" aria-hidden="true"></i> New Order</button>
                     <button onclick = 'location.href="placeorder.php?tab=pack&window=package"' class = 'userhomebutton'><i class="fa fa-plus-circle" aria-hidden="true"></i> New Package Delivery</button>
                     <button onclick = 'location.href="orders.php?id=<?php echo$_SESSION['id'];?>"' class = 'userhomebutton'><i class="fa fa-history" aria-hidden="true"></i> My Orders/Deliveries </button>
                     <button onclick = 'location.href="account.php?tab=account&window=acc"' class = 'userhomebutton'><i class= "fa fa-fw fa-user"></i> My Account </button>
                    <br><br>
                </div>
            </page>
        </main>
        <footer>    <!--FOOTER-->
            <?php footer_(''); ?>
        </footer>

        <script src="jquery.js"></script>
    </body>
</html>