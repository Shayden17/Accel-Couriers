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
            <main><!--MAIN CONTENT CONTAINER (MINUS FOOTER)-->
                <header class = "lightheader"><!--HEADER-->
                    <?php header_('','');?>
                </header>
                <page> <!--MAIN CONTENT ON PAGE (MINUS HEADER)-->
                    <div class = 'row'>        
                        <br><br><br>
                            <div class = 'col_width_60'>
                                <br><br><br><br><br><br><br><br><br>
                                <h1> &emsp;&emsp;&emsp;&emsp;&emsp;Employees Login </h1>
                            </div>
                            <div class = 'col_width_40'>
                                <div class = "box" id='loginbox'>
                                    <?php login('employees');?>
                                </div>
                            </div>
                    </div>
                </page>
                
            </main>
        </div>
        <footer>    <!--FOOTER-->
            <?php footer_('contact'); ?>
        </footer>
    </body>
</html
                    
               
        
  
