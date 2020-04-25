<?php
require "vendor/autoload.php";
require "konfig.php";
$connectionParams = getkonfig();

$conn = \Doctrine\DBAL\DriverManager::getConnection($connectionParams);

if (!$conn) {
    die("Error");
}
$queryBuilder = $conn->createQueryBuilder();
if (!$queryBuilder) {
    die('Ungültige Abfrage: ' . mysqli_error());
}

/*
$load = $queryBuilder
    ->select('id', 'name', 'hobby')
    ->from('person')
    ->execute()
    ->fetchAll();

*/
