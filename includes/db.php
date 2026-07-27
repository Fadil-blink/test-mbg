<?php
/**
 * Simple mysqli connection used by the application.
 * Adjust credentials if your environment differs.
 */
$DB_HOST = '127.0.0.1';
$DB_USER = 'root';
$DB_PASS = '';
$DB_NAME = 'mbgfix';

$mysqli = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
if ($mysqli->connect_error) {
    die('Database connection error (' . $mysqli->connect_errno . '): ' . $mysqli->connect_error);
}
$mysqli->set_charset('utf8mb4');

?>
