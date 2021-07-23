<?php
// connect to DB server

// Development connection
$HOST = 'localhost';
$USER = 'root';
$PASSWORD = '';
$DBNAME = 'bincomphptest';




$connection = mysqli_connect($HOST, $USER, $PASSWORD, $DBNAME);

if ($connection === false) {
    die("Error: Unable to connect".mysqli_connect_error());
}

?>