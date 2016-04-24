<?php

$server 	=	'whm.empirestate.co.za';
$db 		=	'TDA_Bubblewave';
$user		=	'empirest_playar';
$password	=	'iloveempirestate';
$port		=	3306;

# ============================= #
# ==== database connection ==== #
# ============================= #
$mysqli = new mysqli($server, $user, $password, $db, 3306);
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}

//echo $mysqli->host_info . "\n";
?>