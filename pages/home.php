<!doctype html> 
<html>
    <head> 
        <title> Accel Couriers </title>
        <link href ="../css/style.css" rel="stylesheet" type="text/css"/>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <?php session_start();include 'dbconnect.php'; include 'functions.php'; //if (isset($_SESSION['fname'])){header("location:userhome.php");}?>
    </head>
    <body>
        <main> <!--MAIN CONTENT CONTAINER (MINUS FOOTER)-->
            <header class = ' scrolled1 fadeIn'> <!--HEADER-->
                <?php header_('nav','user');?>  
            </header>
            <page> <!--MAIN CONTENT ON PAGE (MINUS HEADER)-->
                <div class= row id = landingpage>
                    <div class = col_width_60 > <!--WELCOME MESSAGE-->
                        <h1>The Fastest and Most Inclusive Courier Service in Trinidad And Tobago</h1><br>
                        <p>We aim to make Online Shopping and Package Delivery easy, accessible, and efficient for everyone.<p>
                        <br>
                        <button onclick = 'location.href="register.php"' id = getstarted class = animatedbutton>Get Started</button>
                    </div>  
                    <div class = col_width_40 >   <!--LANDING PAGE PICTURE-->
                        <img src='../images/landingpage.png' id = 'homepageimg' alt = 'Courier Clip Art'/>
                    </div>
                </div>
            </page>
        </main>
        <footer>    <!--FOOTER-->
            <?php footer_('contact'); ?>
        </footer>
        <script src="jquery.js"></script>    <!-- Rememmber to Add scripts from earilier to one Jquery File-->
    </body>
</html>
