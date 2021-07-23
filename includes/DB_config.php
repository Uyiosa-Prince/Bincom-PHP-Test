<?php
// connect to DB server

//heroku jawsDB Development connection
$HOST = 'kfgk8u2ogtoylkq9.cbetxkdyhwsb.us-east-1.rds.amazonaws.com';
$USER = 'l1oyhfke3y8sr7q8';
$PASSWORD = 'esdabajrsmrp7w04';
$DBNAME = 'ya1w5031pkspy3pv';


$connection = mysqli_connect($HOST, $USER, $PASSWORD, $DBNAME);

if ($connection === false) {
    die("Error: Unable to connect".mysqli_connect_error());
}
// //local host Development connection
// $HOST = 'localhost';
// $USER = 'root';
// $PASSWORD = '';
// $DBNAME = 'bincomphptest';


// $connection = mysqli_connect($HOST, $USER, $PASSWORD, $DBNAME);

// if ($connection === false) {
//     die("Error: Unable to connect".mysqli_connect_error());
// }

?>