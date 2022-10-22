<!doctype html> 
<html>
    <head> 
        <title> Customer Registration </title>
        <link href ="../css/style.css" rel="stylesheet" type="text/css"/>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <?php session_start();include 'dbconnect.php';include 'functions.php'; ?>
    </head>
    <body>
        <main>  <!--MAIN CONTENT CONTAINER (MINUS FOOTER)-->
            <header class = ' scrolled1 fadeIn'> <!--HEADER-->
                <?php header_('nav','user');?>  
            </header>
            <page> <!--MAIN CONTENT ON PAGE (MINUS HEADER)-->
                <div class ='row'>
                    <h1> Customer Registration</h1>
                    <div class = 'box'  id = 'signupbox'>
                        <p id="existingaccount"> Already have an Account? <a class = submitbutton href ='login.php'>Log In</button></a> instead.</p>
                        <?php register('customers');?>
                    </div>
                </div>
            </page>
        </main>
        <footer class="footer" > <!--FOOTER-->
            <?php footer_('contact');?>
        </footer>
        <script src='jquery.js'></script>
    <body>
</html>

