<?php
$databaseHost = 'localhost';
$databaseName = 'poliklinik_db';
$databaseUsername = 'root';
$databasePassword = '';

$mysqli = mysqli_connect(
    $databaseHost,
    $databaseUsername,
    $databasePassword,
    $databaseName
);
