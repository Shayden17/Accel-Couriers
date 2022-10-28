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

                        

            		</p>
				</div>
                <div class ="row">
                    <h1>
            	        Our services 
            	    </h1>
            	    <h3>Online Product Purchace, Shipping, And delivery</h3>
            	    <p> We handle the entire online transaction and shipping process for you. Simply send us the website link for the product you would like to purchace along with the quantity and any other specifcations. Our team will vet your order within 24-48 hours and let you knkw by email if the order has been apporoved. </br>
            	        Once approved, you can then make a deposit to our <a>bank account</a> by online transfer or over the counter.</br>
            	        We then purchase the product and have it delivered to you within 2-4 weeks.</p>
            	   </br></br>
            	   <h3>Additional Services:</h3>
            	    <ul>
            	        <li>Order Tracking</li>
            	        <li>Options for expidite shipping</li>
            	    </ul>
            	    <h3>Local Courier Services (Package Delivery)</h3>
            	    <p>We offer a local logistics and package delivery (Trinidad and Tobago) service for individual and business purposes. </p>
            	    <ul>
            	        <li>Remote Package Pickup</li>
            	        <li> Specify your pickup time (Up to 2 pm)</li>
            	    </ul>
                </div>

            </page>
        </main>
        <footer><!--FOOTER--> 
            <?php footer_('');?>
        </footer>
    <body>
        
</html>