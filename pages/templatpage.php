<!doctype html> 
<html>
    <head> 
        <title> </title>
        <link href ="../css/style.css" rel="stylesheet" type="text/css"/>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <?php session_start();include 'dbconnect.php';include 'functions.php'; ?>
    </head>
    <body>
        <main>
            <header><!--HEADER-->
                <?php header_('','');?>
            </header>
            <page class ='animated FadeInRight'> <!--MAIN CONTENT ON PAGE (MINUS HEADER)-->
            </page>
        </main>
        <footer><!--FOOTER--> 
            <?php footer_('');?>
        </footer>
    <body>
        
</html>