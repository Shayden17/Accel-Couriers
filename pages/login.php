<!doctype html> 
<html>
    <head> 
        <title> Login </title>
        <link href ="../css/style.css" rel="stylesheet" type="text/css"/>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <?php session_start();include 'dbconnect.php'; include 'functions.php'; //if (isset($_SESSION['fname'])){header("location:userhome.php");}?>
    </head>
    <body>
        
        <main> <!--MAIN CONTENT CONTAINER (MINUS FOOTER)-->
            <header class = ' lightheader fadeIn'> <!--HEADER-->
                <?php header_('','');?>  
            </header>
            <page class ='animated FadeInRight'>   <!--MAIN CONTENT ON PAGE (MINUS HEADER)-->
                <div class = 'row'>
                    <br><br><br><br>
                    <div class = "box" id='loginbox'>
                       <?php login('customers'); ?>
                    </div>
                </div>
            </page>
        </main>
        <footer>    <!--FOOTER-->
            <?php footer_('contact'); ?>
        </footer>
        
    </body>
</html
                    
               
        
  
