<!doctype html> 
<html>
    <head> 
        <title> About Us </title>
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
            <page> <!--MAIN CONTENT ON PAGE (MINUS HEADER)-->
            	<div id='row'>
            		<h1>Accel Couriers limited</h1>
                	<br><br>
            		<p id='aboutusmessage'>
                    	We believe that all persons in Trinidad and Tobago should have access to and be able to purchase from the extensive, online, world-wide ecommerce market.<br><br>
                    					
                    	The current nature of all online, e-commerce shopping stores requires that an individual has access to a visa credit/online-debit card. However, a visa credit or online debit card is not easily obtainable to everyone. Additionally, many online stores with international shipping do not deliver directly to trinidad and tobago.<br><br>

                    	At Accel Couriers we make online shopping easy for you, our customers, by handling the entire process of the online  purchase and delivery to you. Simply send us the link of the item, and once approved, pay by direct deposit to our bank account either online or with cash at yo6ur bank of choice.

                        end

            		</p>
				</div>
            
				<h1>
            	Our services 
            	</h1>
            </page>
        </main>
        <footer><!--FOOTER--> 
            <?php footer_('');?>
        </footer>
    <body>
        
</html>