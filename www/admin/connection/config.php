<?php

/**
 * Configuration for database connection
 *
 */

$host       = "localhost";
$username_db   = "root";
$password_db   = "";
$dbname     = "cvts_db";
$dsn        = "mysql:host=$host;dbname=$dbname";
$options    = array(
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
              );

?>
