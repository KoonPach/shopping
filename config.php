<?php

//var url
$base_url = 'http://localhost/shoppingcart/';

//database connection
$host = 'localhost';
$db_user = 'root';  
$db_pass = '';       
$db_name = 'shoppingcart'; 

//connect to database
$conn = mysqli_connect($host, $db_user, $db_pass, $db_name) or die('Connection failed: ' . mysqli_connect_error());
