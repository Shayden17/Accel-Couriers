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
        
        <main>
            <header class=" scrolled1 fadeIn"><!--~ Header-->
                <?php header_('','');?>
            </header>
            <page class ='animated FadeIn'><!--MAIN CONTENT ON PAGE (MINUS HEADER)-->
                <div class ='row'>
                    <br><br><br>
                    <div id ='pwreset' class = 'box'>
                        <h2> Reset Password</h2>
                        <?php
                            $check=passwordreset();     //passwordreset function 
                        ?>
                        <br><br><br><br><br><br>
                        <a href="<?php if(isset($_GET['employees'])){echo 'employeelogin';}else{echo 'login';}?>.php"><input type="submit" value = "Go Back To Log in " class = "submitbutton"/></a>
                    </div>
            </page>
        </main>
        <footer><!--FOOTER-->
            <?php footer_('contact'); ?>
        </footer>
    </body>
</html> 